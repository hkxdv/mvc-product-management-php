/**
 * Funciones PL/pgSQL
 * 
 * Este archivo contiene las funciones necesarias para realizar los cálculos
 * y operaciones relacionadas con el inventario, demanda y producción adicional.
 */

/**
 * Verifica si el inventario es suficiente para cubrir la demanda
 *
 * @return TABLE con los productos, su inventario, demanda y estado de suficiencia
 */
CREATE OR REPLACE FUNCTION verificar_inventario_suficiente()
RETURNS TABLE (
    producto_id INTEGER,
    producto_nombre VARCHAR(100),
    inventario_actual INTEGER,
    demanda_semanal INTEGER,
    es_suficiente BOOLEAN
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        p.pk_productos,
        p.nombre,
        i.cantidad AS inventario_actual,
        d.cantidad AS demanda_semanal,
        CASE WHEN i.cantidad >= d.cantidad THEN TRUE ELSE FALSE END AS es_suficiente
    FROM 
        productos p
    JOIN 
        inventario i ON p.pk_productos = i.fk_producto
    JOIN 
        demanda d ON p.pk_productos = d.fk_producto
    WHERE
        p.estado = 1 AND i.estado = 1 AND d.estado = 1;
END;
$$ LANGUAGE plpgsql;

/**
 * Calcula la producción adicional necesaria para cubrir la demanda
 *
 * @return TABLE con los productos, inventario, demanda y producción necesaria
 */
CREATE OR REPLACE FUNCTION calcular_produccion_adicional()
RETURNS TABLE (
    producto_id INTEGER,
    producto_nombre VARCHAR(100),
    inventario_actual INTEGER,
    demanda_semanal INTEGER,
    produccion_necesaria INTEGER,
    costo_produccion DECIMAL(10,2)
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        p.pk_productos,
        p.nombre,
        i.cantidad AS inventario_actual,
        d.cantidad AS demanda_semanal,
        CASE WHEN d.cantidad > i.cantidad 
            THEN d.cantidad - i.cantidad 
            ELSE 0 
        END AS produccion_necesaria,
        p.costo_produccion * 
            CASE WHEN d.cantidad > i.cantidad 
                THEN d.cantidad - i.cantidad 
                ELSE 0 
            END AS costo_produccion
    FROM 
        productos p
    JOIN 
        inventario i ON p.pk_productos = i.fk_producto
    JOIN 
        demanda d ON p.pk_productos = d.fk_producto
    WHERE
        p.estado = 1 AND i.estado = 1 AND d.estado = 1;
END;
$$ LANGUAGE plpgsql;

/**
 * Calcula los ingresos esperados de la semana basados en la demanda
 *
 * @return DECIMAL(10,2) Total de ingresos esperados
 */
CREATE OR REPLACE FUNCTION calcular_ingresos_esperados()
RETURNS DECIMAL(10,2) AS $$
DECLARE
    total_ingresos DECIMAL(10,2) := 0;
BEGIN
    SELECT SUM(p.precio_venta * d.cantidad)
    INTO total_ingresos
    FROM productos p
    JOIN demanda d ON p.pk_productos = d.fk_producto
    WHERE p.estado = 1 AND d.estado = 1;
    
    RETURN total_ingresos;
END;
$$ LANGUAGE plpgsql;

/**
 * Registra la producción adicional necesaria para satisfacer la demanda
 *
 * Elimina registros previos y crea nuevos registros de producción adicional
 * para los productos cuya demanda supera el inventario disponible.
 *
 * @return void
 */
CREATE OR REPLACE FUNCTION registrar_produccion_adicional()
RETURNS void AS $$
DECLARE
    rec RECORD;
BEGIN
    -- Iniciar transacción
    START TRANSACTION;
    
    -- Eliminar producciones adicionales previas que pudieran existir
    DELETE FROM produccion_adicional;
    
    -- Insertar nuevas producciones adicionales necesarias
    FOR rec IN 
        SELECT 
            p.pk_productos,
            p.nombre,
            CASE WHEN d.cantidad > i.cantidad 
                THEN d.cantidad - i.cantidad 
                ELSE 0 
            END AS cantidad_adicional
        FROM 
            productos p
        JOIN 
            inventario i ON p.pk_productos = i.fk_producto
        JOIN 
            demanda d ON p.pk_productos = d.fk_producto
        WHERE
            p.estado = 1 AND i.estado = 1 AND d.estado = 1
            AND d.cantidad > i.cantidad
    LOOP
        IF rec.cantidad_adicional > 0 THEN
            INSERT INTO produccion_adicional (fk_producto, cantidad)
            VALUES (rec.pk_productos, rec.cantidad_adicional);
        END IF;
    END LOOP;
    
    -- Finalizar transacción
    COMMIT;
EXCEPTION
    WHEN OTHERS THEN
        -- Revertir cambios en caso de error
        ROLLBACK;
        RAISE EXCEPTION 'Error al registrar producción adicional: %', SQLERRM;
END;
$$ LANGUAGE plpgsql;

/**
 * Actualiza el inventario después de realizar la producción adicional
 *
 * Incrementa la cantidad en inventario con las cantidades de producción adicional
 * para cada producto que requirió producción adicional.
 *
 * @return void
 */
CREATE OR REPLACE FUNCTION actualizar_inventario_post_produccion()
RETURNS void AS $$
DECLARE
    rec RECORD;
BEGIN
    -- Iniciar transacción
    START TRANSACTION;
    
    FOR rec IN 
        SELECT 
            fk_producto,
            cantidad
        FROM 
            produccion_adicional
        WHERE
            estado = 1
    LOOP
        UPDATE inventario
        SET cantidad = cantidad + rec.cantidad
        WHERE fk_producto = rec.fk_producto AND estado = 1;
    END LOOP;
    
    -- Finalizar transacción
    COMMIT;
EXCEPTION
    WHEN OTHERS THEN
        -- Revertir cambios en caso de error
        ROLLBACK;
        RAISE EXCEPTION 'Error al actualizar inventario: %', SQLERRM;
END;
$$ LANGUAGE plpgsql; 
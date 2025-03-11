<?php

class FabricaModelo extends Modelo
{
    // Verificar si el inventario es suficiente para cubrir la demanda
    static public function verificar_inventario($productos = null)
    {
        if ($productos === null) {
            $productos = ProductoModelo::obtener_todos();
        }

        $resultados = [];

        foreach ($productos as $producto) {
            $inventario = InventarioModelo::obtener_por_producto($producto['pk_productos']);
            $demanda = DemandaModelo::obtener_por_producto($producto['pk_productos']);

            if ($inventario && $demanda) {
                $resultado = [
                    'id_producto' => $producto['pk_productos'],
                    'producto' => $producto['nombre'],
                    'inventario' => $inventario['cantidad'],
                    'demanda' => $demanda['cantidad'],
                    // Fórmula: Inventario Suficiente = Inventario >= Demanda
                    'suficiente' => $inventario['cantidad'] >= $demanda['cantidad']
                ];

                $resultados[] = $resultado;
            }
        }

        return $resultados;
    }

    // Calcular la cantidad adicional que debe producirse
    static public function calcular_produccion_adicional($productos = null)
    {
        if ($productos === null) {
            $productos = ProductoModelo::obtener_todos();
        }

        $produccion_adicional = [];

        foreach ($productos as $producto) {
            $inventario = InventarioModelo::obtener_por_producto($producto['pk_productos']);
            $demanda = DemandaModelo::obtener_por_producto($producto['pk_productos']);

            if ($inventario && $demanda) {
                // Si la demanda es mayor que el inventario
                if ($demanda['cantidad'] > $inventario['cantidad']) {
                    // Fórmula: Cantidad Adicional = Demanda - Inventario
                    $cantidad_adicional = $demanda['cantidad'] - $inventario['cantidad'];

                    $produccion_adicional[] = [
                        'id_producto' => $producto['pk_productos'],
                        'producto' => $producto['nombre'],
                        'inventario' => $inventario['cantidad'],
                        'demanda' => $demanda['cantidad'],
                        'cantidad_adicional' => $cantidad_adicional,
                        'costo_produccion' => $producto['costo_produccion'],
                        'costo_total' => $cantidad_adicional * $producto['costo_produccion']
                    ];
                }
            }
        }

        return $produccion_adicional;
    }

    // Registrar producción adicional
    static public function registrar_produccion_adicional($id_producto, $cantidad)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO produccion_adicional (fk_producto, cantidad) VALUES (:id_producto, :cantidad)");

        $stmt->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
        $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Actualizar inventario
            $inventario = InventarioModelo::obtener_por_producto($id_producto);

            if ($inventario) {
                $nueva_cantidad = $inventario['cantidad'] + $cantidad;
                InventarioModelo::actualizar($id_producto, $nueva_cantidad);
            }

            return "ok";
        } else {
            return "error";
        }
    }
}

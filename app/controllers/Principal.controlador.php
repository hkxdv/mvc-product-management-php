<?php

class Controlador
{
    // Llamada a la plantilla
    static public function pagina()
    {
        include "app/views/plantilla.php";
    }

    // Llamada a los diversos módulos
    static public function enlaces_paginas_controlador()
    {
        if (isset($_GET["option"])) {
            $enlace = $_GET["option"];
        } else {
            $enlace = "principal";
        }

        $respuesta = Paginas::enlaces_paginas_modelo($enlace);
        include $respuesta;
    }

    // ---- MÉTODOS PARA PRODUCTOS ---- //

    // Registrar producto
    static public function registro_producto_controlador()
    {
        if (isset($_POST['nombre']) && isset($_POST['costo_produccion']) && isset($_POST['precio_venta'])) {
            $datos = [
                'nombre' => $_POST['nombre'],
                'costo_produccion' => $_POST['costo_produccion'],
                'precio_venta' => $_POST['precio_venta']
            ];

            $respuesta = ProductoModelo::registrar($datos);

            $mensajes = [
                'exito' => 'Producto registrado exitosamente',
                'error' => 'Error al registrar el producto'
            ];

            Alertas::mostrar_alerta($respuesta, $mensajes, "index.php?option=productos");
        }
    }

    // Listar productos
    static public function listar_productos_controlador()
    {
        return ProductoModelo::obtener_todos();
    }

    // Editar producto
    static public function editar_producto_controlador()
    {
        if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['costo_produccion']) && isset($_POST['precio_venta'])) {
            $id = $_POST['id'];
            $datos = [
                'nombre' => $_POST['nombre'],
                'costo_produccion' => $_POST['costo_produccion'],
                'precio_venta' => $_POST['precio_venta']
            ];

            $respuesta = ProductoModelo::actualizar($id, $datos);

            $mensajes = [
                'exito' => 'Producto actualizado exitosamente',
                'error' => 'Error al actualizar el producto'
            ];

            Alertas::mostrar_alerta($respuesta, $mensajes, "index.php?option=productos");
        }
    }

    // Eliminar producto
    static public function eliminar_producto_controlador()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $respuesta = ProductoModelo::eliminar($id);

            $mensajes = [
                'exito' => 'Producto eliminado exitosamente',
                'error' => 'Error al eliminar el producto'
            ];

            Alertas::mostrar_alerta($respuesta, $mensajes, "index.php?option=productos");
        }
    }

    // ---- MÉTODOS PARA INVENTARIO ---- //

    // Actualizar inventario
    static public function actualizar_inventario_controlador()
    {
        if (isset($_POST['pk_producto']) && isset($_POST['cantidad'])) {
            $pk_producto = $_POST['pk_producto'];
            $cantidad = $_POST['cantidad'];

            $respuesta = InventarioModelo::registrar($pk_producto, $cantidad);

            $mensajes = [
                'exito' => 'Inventario actualizado exitosamente',
                'error' => 'Error al actualizar el inventario'
            ];

            Alertas::mostrar_alerta($respuesta, $mensajes, "index.php?option=inventario");
        }
    }

    // Mostrar inventario
    static public function mostrar_inventario_controlador()
    {
        return InventarioModelo::obtener_todos();
    }

    // ---- MÉTODOS PARA DEMANDA ---- //

    // Registrar demanda
    static public function registrar_demanda_controlador()
    {
        if (isset($_POST['pk_producto']) && isset($_POST['cantidad'])) {
            $pk_producto = $_POST['pk_producto'];
            $cantidad = $_POST['cantidad'];

            $respuesta = DemandaModelo::registrar($pk_producto, $cantidad);

            $mensajes = [
                'exito' => 'Demanda registrada exitosamente',
                'error' => 'Error al registrar la demanda'
            ];

            Alertas::mostrar_alerta($respuesta, $mensajes, "index.php?option=demanda");
        }
    }

    // Calcular ingresos esperados
    static public function calcular_ingresos_esperados_controlador()
    {
        return DemandaModelo::calcular_ingresos_esperados();
    }

    // Mostrar demanda
    static public function mostrar_demanda_controlador()
    {
        return DemandaModelo::obtener_todos();
    }

    // ---- MÉTODOS PARA FÁBRICA ---- //

    // Verificar inventario suficiente
    static public function verificar_inventario_suficiente_controlador()
    {
        return FabricaModelo::verificar_inventario();
    }

    // Calcular producción adicional
    static public function calcular_produccion_adicional_controlador()
    {
        return FabricaModelo::calcular_produccion_adicional();
    }

    // Registrar producción adicional
    static public function registrar_produccion_adicional_controlador()
    {
        if (isset($_POST['pk_producto']) && isset($_POST['cantidad'])) {
            $pk_producto = $_POST['pk_producto'];
            $cantidad = $_POST['cantidad'];

            $respuesta = FabricaModelo::registrar_produccion_adicional($pk_producto, $cantidad);

            $mensajes = [
                'exito' => 'Producción adicional registrada exitosamente',
                'error' => 'Error al registrar la producción adicional'
            ];

            Alertas::mostrar_alerta($respuesta, $mensajes, "index.php?option=calculos");
        }
    }

    // Mostrar resultados de fabricación
    static public function mostrar_resultados_fabricacion_controlador()
    {
        $verificacion = self::verificar_inventario_suficiente_controlador();
        $produccion_adicional = self::calcular_produccion_adicional_controlador();
        $ingresos_esperados = self::calcular_ingresos_esperados_controlador();

        return [
            'verificacion' => $verificacion,
            'produccion_adicional' => $produccion_adicional,
            'ingresos_esperados' => $ingresos_esperados
        ];
    }
}

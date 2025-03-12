<?php

/**
 * Principal.controlador.php
 * Controlador principal que maneja las interacciones entre modelos y vistas
 * 
 * Este controlador implementa los métodos necesarios para resolver la problemática planteada:
 * - Gestión de productos (solo lectura)
 * - Gestión de inventario (visualización y actualización)
 * - Gestión de demanda (registro y visualización)
 * - Cálculos relacionados con la verificación de inventario y producción adicional
 */
class Controlador
{
    /**
     * Carga la plantilla principal de la aplicación
     */
    static public function pagina()
    {
        include "app/views/plantilla.php";
    }

    /**
     * Maneja la navegación entre las diferentes secciones
     * Carga los módulos correspondientes según la opción seleccionada
     */
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

    /**
     * Obtiene la lista de todos los productos para mostrarlos en la vista
     * 
     * @return array Lista de productos ordenados por nombre
     */
    static public function listar_productos_controlador()
    {
        return ProductoModelo::obtener_todos();
    }

    // ---- MÉTODOS PARA INVENTARIO ---- //

    /**
     * Actualiza la cantidad en inventario para un producto específico
     * Procesa los datos del formulario de actualización
     */
    static public function actualizar_inventario_controlador()
    {
        // Debug para verificar si se está recibiendo el POST
        error_log("POST en actualizar_inventario_controlador: " . print_r($_POST, true));
        
        if (isset($_POST['fk_producto']) && isset($_POST['cantidad'])) {
            $fk_producto = $_POST['fk_producto'];
            $cantidad = $_POST['cantidad'];

            $respuesta = InventarioModelo::registrar($fk_producto, $cantidad);

            $mensajes = [
                'exito' => 'Inventario actualizado exitosamente',
                'error' => 'Error al actualizar el inventario'
            ];

            Alertas::mostrar_alerta($respuesta, $mensajes, "index.php?option=inventario");
        } else {
            error_log("No se recibieron los parámetros necesarios para actualizar el inventario");
        }
    }

    /**
     * Obtiene los datos de inventario formateados para la vista
     * 
     * @return array Datos de inventario con información del producto
     */
    static public function mostrar_inventario_controlador()
    {
        $datos_inventario = InventarioModelo::obtener_todos();
        $inventario_formateado = [];
        
        foreach ($datos_inventario as $item) {
            $inventario_formateado[] = [
                'fk_producto' => $item['fk_producto'],
                'producto' => $item['nombre_producto'],
                'cantidad' => $item['cantidad']
            ];
        }
        
        return $inventario_formateado;
    }

    // ---- MÉTODOS PARA DEMANDA ---- //

    /**
     * Registra la demanda semanal para un producto específico
     * Procesa los datos del formulario de registro de demanda
     */
    static public function registrar_demanda_controlador()
    {
        // Debug para verificar si se está recibiendo el POST
        error_log("POST en registrar_demanda_controlador: " . print_r($_POST, true));
        
        if (isset($_POST['fk_producto']) && isset($_POST['cantidad'])) {
            $fk_producto = $_POST['fk_producto'];
            $cantidad = $_POST['cantidad'];

            $respuesta = DemandaModelo::registrar($fk_producto, $cantidad);

            $mensajes = [
                'exito' => 'Demanda registrada exitosamente',
                'error' => 'Error al registrar la demanda'
            ];

            Alertas::mostrar_alerta($respuesta, $mensajes, "index.php?option=demanda");
        } else {
            error_log("No se recibieron los parámetros necesarios para registrar la demanda");
        }
    }

    /**
     * Calcula los ingresos esperados basados en la demanda y precio de venta
     * 
     * @return array Detalles de ingresos esperados por producto y total
     */
    static public function calcular_ingresos_esperados_controlador()
    {
        return DemandaModelo::calcular_ingresos_esperados();
    }

    /**
     * Obtiene los datos de demanda formateados para la vista
     * 
     * @return array Datos de demanda con información del producto
     */
    static public function mostrar_demanda_controlador()
    {
        $datos_demanda = DemandaModelo::obtener_todos();
        $demanda_formateada = [];
        
        foreach ($datos_demanda as $item) {
            $demanda_formateada[] = [
                'fk_producto' => $item['fk_producto'],
                'producto' => $item['nombre_producto'],
                'cantidad' => $item['cantidad']
            ];
        }
        
        return $demanda_formateada;
    }

    // ---- MÉTODOS PARA CÁLCULOS ---- //

    /**
     * Verifica si el inventario actual es suficiente para cubrir la demanda
     * 
     * @return array Resultados de la verificación para cada producto
     */
    static public function verificar_inventario_suficiente_controlador()
    {
        return FabricaModelo::verificar_inventario();
    }

    /**
     * Calcula la producción adicional necesaria cuando el inventario es insuficiente
     * 
     * @return array Cantidad y costo de producción adicional por producto
     */
    static public function calcular_produccion_adicional_controlador()
    {
        return FabricaModelo::calcular_produccion_adicional();
    }

    /**
     * Recopila todos los resultados de los cálculos para mostrarlos en un informe completo
     * 
     * @return array Información completa de verificación, producción e ingresos
     */
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

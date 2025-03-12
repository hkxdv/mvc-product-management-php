<?php

/**
 * PostgreSQL.modelo.php
 * Modelo para aprovechar las funciones específicas de PostgreSQL
 */
class PostgreSQLModelo extends Modelo
{
    /**
     * Verifica si el inventario es suficiente para cubrir la demanda
     * Utiliza la función de PostgreSQL 'verificar_inventario_suficiente'
     */
    static public function verificar_inventario_suficiente()
    {
        try {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM verificar_inventario_suficiente()");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al verificar inventario (PostgreSQL): " . $e->getMessage());
            return [];
        }
    }

    /**
     * Calcula la producción adicional necesaria
     * Utiliza la función de PostgreSQL 'calcular_produccion_adicional'
     */
    static public function calcular_produccion_adicional()
    {
        try {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM calcular_produccion_adicional()");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al calcular producción adicional (PostgreSQL): " . $e->getMessage());
            return [];
        }
    }

    /**
     * Calcula los ingresos esperados de la semana
     * Utiliza la función de PostgreSQL 'calcular_ingresos_esperados'
     */
    static public function calcular_ingresos_esperados()
    {
        try {
            $stmt = Conexion::conectar()->prepare("SELECT calcular_ingresos_esperados() AS ingresos_esperados");
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado ? $resultado['ingresos_esperados'] : 0;
        } catch (PDOException $e) {
            error_log("Error al calcular ingresos esperados (PostgreSQL): " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Registra la producción adicional necesaria
     * Utiliza la función de PostgreSQL 'registrar_produccion_adicional'
     */
    static public function registrar_produccion_adicional()
    {
        try {
            $stmt = Conexion::conectar()->prepare("SELECT registrar_produccion_adicional()");
            $stmt->execute();
            return "ok";
        } catch (PDOException $e) {
            error_log("Error al registrar producción adicional (PostgreSQL): " . $e->getMessage());
            return "error";
        }
    }

    /**
     * Actualiza el inventario después de la producción adicional
     * Utiliza la función de PostgreSQL 'actualizar_inventario_post_produccion'
     */
    static public function actualizar_inventario_post_produccion()
    {
        try {
            $stmt = Conexion::conectar()->prepare("SELECT actualizar_inventario_post_produccion()");
            $stmt->execute();
            return "ok";
        } catch (PDOException $e) {
            error_log("Error al actualizar inventario post producción (PostgreSQL): " . $e->getMessage());
            return "error";
        }
    }

    /**
     * Ejecuta todas las operaciones de cálculo en secuencia
     * Ideal para procesar todo en una sola transacción
     */
    static public function ejecutar_calculo_completo()
    {
        $conexion = Conexion::conectar();

        try {
            // Iniciar transacción
            $conexion->beginTransaction();

            // 1. Registrar producción adicional
            $stmt1 = $conexion->prepare("SELECT registrar_produccion_adicional()");
            $stmt1->execute();

            // 2. Actualizar inventario
            $stmt2 = $conexion->prepare("SELECT actualizar_inventario_post_produccion()");
            $stmt2->execute();

            // Confirmar transacción
            $conexion->commit();

            return "ok";
        } catch (PDOException $e) {
            // Revertir en caso de error
            $conexion->rollBack();
            error_log("Error en el cálculo completo: " . $e->getMessage());
            return "error: " . $e->getMessage();
        }
    }
}

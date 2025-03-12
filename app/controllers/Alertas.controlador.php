<?php
/**
 * Alertas.controlador.php
 * Controlador para gestionar las alertas de la aplicación
 * 
 * Esta clase proporciona un metodo para mostrar mensajes de éxito o error
 * utilizando la biblioteca SweetAlert para una mejor experiencia de usuario.
 */
class Alertas
{
    /**
     * Muestra una alerta con SweetAlert según el tipo de respuesta
     * 
     * Genera una alerta visual con mensaje personalizado y opcionalmente
     * redirige a otra página después de mostrar la alerta.
     * 
     * @param string $respuesta Tipo de respuesta ("ok" para éxito, cualquier otro valor para error)
     * @param array $mensajes Arreglo con mensajes de éxito y error ['exito' => '', 'error' => '']
     * @param string|null $redireccion URL a la que redirigir después de mostrar la alerta (opcional)
     * @return void
     */
    public static function mostrar_alerta($respuesta, $mensajes, $redireccion = null)
    {
        $icon = ($respuesta == "ok") ? "success" : "error";
        $title = ($respuesta == "ok") ? $mensajes['exito'] : $mensajes['error']; ?>

        <script>
            Swal.fire({
                position: 'top-end',
                icon: '<?php echo $icon; ?>',
                title: '<?php echo $title; ?>',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                <?php if ($redireccion) { ?>
                    window.location.href = "<?php echo $redireccion; ?>";
                <?php } ?>
            });
        </script>
    <?php
    }
}
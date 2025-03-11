<?php
class Alertas
{
    // Alerta general para mostrar mensajes de éxito o error
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
<div class="container">
    <h2 class="mt-4">Gestión de Inventario</h2>
    <table class="table table-striped table-hover mt-4">
        <thead class="thead-dark">
            <tr>
                <th>ID Producto</th>
                <th>Producto</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $inventario = Controlador::mostrar_inventario_controlador();
            foreach ($inventario as $item) { ?>
                <tr>
                    <td><?php echo $item['id_producto'] ?></td>
                    <td><?php echo $item['producto'] ?></td>
                    <td><?php echo $item['cantidad'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
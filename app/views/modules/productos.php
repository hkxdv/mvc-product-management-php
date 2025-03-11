<div class="container">
    <h2 class="mt-4">Gestión de Productos</h2>
    <table class="table table-striped table-hover mt-4">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Costo de Producción</th>
                <th>Precio de Venta</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $productos = Controlador::listar_productos_controlador();
            foreach ($productos as $producto) { ?>
                <tr>
                    <td><?php echo $producto['pk_productos'] ?></td>
                    <td><?php echo $producto['nombre'] ?></td>
                    <td><?php echo $producto['costo_produccion'] ?></td>
                    <td><?php echo $producto['precio_venta'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="container">
    <h2 class="mt-4">Gestión de Demanda</h2>
    <table class="table table-striped table-hover mt-4">
        <thead class="thead-dark">
            <tr>
                <th>ID Producto</th>
                <th>Producto</th>
                <th>Demanda Semanal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $demandas = Controlador::mostrar_demanda_controlador();
            foreach ($demandas as $demanda) { ?>
                <tr>
                    <td><?php echo $demanda['id_producto'] ?></td>
                    <td><?php echo $demanda['producto'] ?></td>
                    <td><?php echo $demanda['cantidad'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
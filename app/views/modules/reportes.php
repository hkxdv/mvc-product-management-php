<div class="container">
    <h2 class="mt-4">Reportes de Ingresos Esperados</h2>
    <table class="table table-striped table-hover mt-4">
        <thead class="thead-dark">
            <tr>
                <th>Producto</th>
                <th>Demanda</th>
                <th>Precio de Venta</th>
                <th>Ingreso Esperado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $ingresos = Controlador::calcular_ingresos_esperados_controlador();
            foreach ($ingresos['detalles'] as $ingreso) { ?>
                <tr>
                    <td><?php echo $ingreso['producto'] ?></td>
                    <td><?php echo $ingreso['demanda'] ?></td>
                    <td><?php echo $ingreso['precio_venta'] ?></td>
                    <td><?php echo $ingreso['ingreso_esperado'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <h4 class="mt-5">Total Ingresos Esperados: $<?php echo $ingresos['total']; ?></h4>
</div>
<div class="container">
    <h2 class="mt-4 mb-4">Cálculos de Inventario y Producción</h2>
    <h4>Verificación de Inventario</h4>
    <table class="table table-striped table-hover mt-4">
        <thead class="thead-dark">
            <tr>
                <th>Producto</th>
                <th>Inventario</th>
                <th>Demanda</th>
                <th>Suficiente</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $verificacion = Controlador::verificar_inventario_suficiente_controlador();
            foreach ($verificacion as $item) {
                $suficiente = $item['suficiente'] ? 'Sí' : 'No'; ?>
                <tr>
                    <td><?php echo $item['producto'] ?></td>
                    <td><?php echo $item['inventario'] ?></td>
                    <td><?php echo $item['demanda'] ?></td>
                    <td><?php echo $suficiente ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h4 class="mt-5">Producción Adicional Necesaria</h4>
    <table class="table table-striped table-hover mt-4">
        <thead class="thead-dark">
            <tr>
                <th>Producto</th>
                <th>Cantidad Adicional</th>
                <th>Costo Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $produccion_adicional = Controlador::calcular_produccion_adicional_controlador();
            foreach ($produccion_adicional as $item) { ?>
                <tr>
                    <td><?php echo $item['producto'] ?></td>
                    <td><?php echo $item['cantidad_adicional'] ?></td>
                    <td><?php echo $item['costo_total'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
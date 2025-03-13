<div class="container">
    <!-- Encabezado -->
    <div class="row mb-4">
        <div class="col-12 bg-light p-4 rounded shadow-sm">
            <h2 class="text-warning"><i class="fas fa-calculator me-2"></i>Cálculos de Inventario y Producción</h2>
            <p class="lead">Esta sección muestra los cálculos principales del sistema según la problemática original</p>
        </div>
    </div>

    <!-- Verificación de Inventario -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i>Verificación de Inventario</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">Comparación entre el inventario disponible y la demanda semanal para determinar si es suficiente</p>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Producto</th>
                                    <th scope="col" class="text-center">Inventario</th>
                                    <th scope="col" class="text-center">Demanda</th>
                                    <th scope="col" class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $verificacion = Controlador::verificar_inventario_suficiente_controlador();
                                if (empty($verificacion)) { ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-3 text-muted">No hay datos disponibles para verificar el inventario</td>
                                    </tr>
                                <?php } else {
                                    foreach ($verificacion as $item) {
                                        $suficiente = $item['suficiente'] ? '<span class="badge bg-success px-3 py-2">Suficiente</span>' : '<span class="badge bg-danger px-3 py-2">Insuficiente</span>';
                                    ?>
                                        <tr>
                                            <td class="fw-bold"><?php echo $item['producto'] ?></td>
                                            <td class="text-center"><?php echo $item['inventario'] ?> unidades</td>
                                            <td class="text-center"><?php echo $item['demanda'] ?> unidades</td>
                                            <td class="text-center"><?php echo $suficiente ?></td>
                                        </tr>
                                    <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Producción Adicional Necesaria -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0"><i class="fas fa-industry me-2"></i>Producción Adicional Necesaria</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">Cálculo de la cantidad adicional que debe producirse y su costo estimado</p>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Producto</th>
                                    <th scope="col" class="text-center">Cantidad Adicional</th>
                                    <th scope="col" class="text-end">Costo Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $produccion_adicional = Controlador::calcular_produccion_adicional_controlador();
                                if (empty($produccion_adicional)) { ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-3 text-success">No se requiere producción adicional</td>
                                    </tr>
                                <?php } else {
                                    foreach ($produccion_adicional as $item) { ?>
                                        <tr>
                                            <td class="fw-bold"><?php echo $item['producto'] ?></td>
                                            <td class="text-center"><?php echo $item['cantidad_adicional'] ?> unidades</td>
                                            <td class="text-end">$<?php echo number_format($item['costo_total'], 2) ?></td>
                                        </tr>
                                    <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información adicional -->
    <div class="row">
        <div class="col-12">
            <div class="alert alert-light shadow-sm border">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle fa-2x text-warning me-3"></i>
                    </div>
                    <div>
                        <h5>¿Cómo se realizan los cálculos?</h5>
                        <p class="mb-0">El sistema verifica si el inventario es suficiente comparando con la demanda semanal. Si no es suficiente, calcula la cantidad adicional que debe producirse (Demanda - Inventario) y el costo total de esa producción adicional (Cantidad × Costo unitario).</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
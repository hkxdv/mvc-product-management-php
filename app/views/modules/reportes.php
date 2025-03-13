<div class="container">
    <!-- Encabezado -->
    <div class="row mb-4">
        <div class="col-12 bg-light p-4 rounded shadow-sm">
            <h2 class="text-danger"><i class="fas fa-chart-pie me-2"></i>Reportes de Ingresos Esperados</h2>
            <p class="lead">Cálculo del total de ingresos esperados semanalmente según la demanda</p>
        </div>
    </div>
    
    <!-- Reporte de Ingresos -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-danger text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-file-invoice-dollar me-2"></i>Detalles de Ingresos por Producto</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Producto</th>
                                    <th scope="col" class="text-center">Demanda</th>
                                    <th scope="col" class="text-end">Precio de Venta</th>
                                    <th scope="col" class="text-end">Ingreso Esperado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $ingresos = Controlador::calcular_ingresos_esperados_controlador();
                                if (empty($ingresos['detalles'])) { ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-3 text-muted">No hay datos disponibles para calcular ingresos</td>
                                    </tr>
                                <?php } else {
            foreach ($ingresos['detalles'] as $ingreso) { ?>
                <tr>
                                            <td class="fw-bold"><?php echo $ingreso['producto'] ?></td>
                                            <td class="text-center"><?php echo $ingreso['demanda'] ?> unidades</td>
                                            <td class="text-end">$<?php echo number_format($ingreso['precio_venta'], 2) ?></td>
                                            <td class="text-end fw-bold">$<?php echo number_format($ingreso['ingreso_esperado'], 2) ?></td>
                </tr>
                                    <?php }
                                } ?>
        </tbody>
                            <tfoot>
                                <tr class="table-light">
                                    <td colspan="3" class="text-end fw-bold">Total Ingresos Esperados:</td>
                                    <td class="text-end fw-bold fs-5 text-danger">$<?php echo number_format($ingresos['total'], 2); ?></td>
                                </tr>
                            </tfoot>
    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Distribución de Ingresos</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($ingresos['detalles'])) { ?>
                        <div class="py-3">
                            <?php foreach ($ingresos['detalles'] as $ingreso) { 
                                $porcentaje = ($ingreso['ingreso_esperado'] / $ingresos['total']) * 100;
                            ?>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="fw-bold"><?php echo $ingreso['producto'] ?></span>
                                        <span><?php echo number_format($porcentaje, 1) ?>%</span>
                                    </div>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-<?php echo ($porcentaje > 40) ? 'danger' : (($porcentaje > 20) ? 'warning' : 'success'); ?>" 
                                             role="progressbar" 
                                             style="width: <?php echo $porcentaje ?>%;" 
                                             aria-valuenow="<?php echo $porcentaje ?>" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-chart-bar fa-3x mb-3"></i>
                            <p>No hay datos disponibles para mostrar estadísticas</p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Información Importante</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex">
                            <div class="flex-shrink-0 text-primary me-3">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div>
                                <strong>Ingresos Esperados:</strong> Calculados multiplicando la demanda semanal por el precio de venta de cada producto.
                            </div>
                        </li>
                        <li class="list-group-item d-flex">
                            <div class="flex-shrink-0 text-warning me-3">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div>
                                <strong>Importante:</strong> Estos son ingresos proyectados basados en la demanda y asumiendo que se vende todo lo demandado.
                            </div>
                        </li>
                        <li class="list-group-item d-flex">
                            <div class="flex-shrink-0 text-success me-3">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <div>
                                <strong>Tip:</strong> Compara estos reportes con la producción adicional para optimizar tus estrategias de fabricación y ventas.
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
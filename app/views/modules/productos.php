<div class="container">
    <!-- Encabezado -->
    <div class="row mb-4">
        <div class="col-12 bg-light p-4 rounded shadow-sm">
            <h2 class="text-primary"><i class="fas fa-boxes me-2"></i>Gestión de Productos</h2>
            <p class="lead">Listado de los productos disponibles en el sistema</p>
        </div>
    </div>
    
    <!-- Tabla de Productos -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Productos Registrados</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col" class="text-end">Costo de Producción</th>
                                    <th scope="col" class="text-end">Precio de Venta</th>
                                    <th scope="col" class="text-center">Margen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $productos = Controlador::listar_productos_controlador();
                                if (empty($productos)) { ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-3 text-muted">No hay productos registrados en el sistema</td>
                                    </tr>
                                <?php } else {
                                    foreach ($productos as $producto) { 
                                        $margen = ($producto['precio_venta'] - $producto['costo_produccion']) / $producto['precio_venta'] * 100;
                                    ?>
                                        <tr>
                                            <td><?php echo $producto['pk_productos'] ?></td>
                                            <td class="fw-bold"><?php echo $producto['nombre'] ?></td>
                                            <td class="text-end">$<?php echo number_format($producto['costo_produccion'], 2) ?></td>
                                            <td class="text-end">$<?php echo number_format($producto['precio_venta'], 2) ?></td>
                                            <td class="text-center">
                                                <span class="badge bg-<?php echo ($margen >= 30) ? 'success' : (($margen >= 15) ? 'warning' : 'danger'); ?> px-2 py-1">
                                                    <?php echo number_format($margen, 1) ?>%
                                                </span>
                                            </td>
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
    <div class="row mt-4">
        <div class="col-12">
            <div class="alert alert-light shadow-sm border">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle fa-2x text-primary me-3"></i>
                    </div>
                    <div>
                        <h5>Información de Productos</h5>
                        <p class="mb-0">Esta tabla muestra los productos definidos en el sistema. El margen de ganancia se calcula como la diferencia entre el precio de venta y el costo de producción, dividido por el precio de venta.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
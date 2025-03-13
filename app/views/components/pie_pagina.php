<footer class="bg-dark text-white py-4 mt-auto shadow-lg">
    <div class="container">
        <div class="row align-items-center">
            <!-- Información del sistema -->
            <div class="col-md-6 mb-3 mb-md-0">
                <h5 class="text-white mb-3"><i class="fas fa-warehouse me-2"></i>Sistema de Gestión de Inventario y Demanda</h5>
                <p class="text-light mb-1 small">Solución optimizada para la problemática de producción, inventario y demanda.</p>
                <p class="text-light mb-0 small">Desarrollada con PHP, PostgreSQL y Arquitectura MVC.</p>
            </div>

            <!-- Enlaces y GitHub -->
            <div class="col-md-6 text-md-end">
                <div class="d-flex flex-column align-items-md-end">
                    <!-- Enlaces rápidos -->
                    <div class="mb-3">
                        <h6 class="text-white">Enlaces Rápidos</h6>
                        <div class="d-flex justify-content-md-end gap-3">
                            <a href="index.php" class="text-light text-decoration-none small"><i class="fas fa-home me-1"></i>Inicio</a>
                            <a href="index.php?option=productos" class="text-light text-decoration-none small"><i class="fas fa-boxes me-1"></i>Productos</a>
                            <a href="index.php?option=reportes" class="text-light text-decoration-none small"><i class="fas fa-chart-pie me-1"></i>Reportes</a>
                        </div>
                    </div>
                    
                    <!-- GitHub -->
                    <div>
                        <a class="btn btn-dark btn-sm border-light" href="https://github.com/hk4u-dxv/mvc-inventario-productos" role="button" target="_blank">
                            <i class="fab fa-github me-2"></i>Ver en GitHub
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="row mt-3 pt-3 border-top border-secondary">
            <div class="col-12 text-center">
                <p class="mb-0 text-muted small">
                    &copy; <?php echo date('Y'); ?> - Sistema de Gestión de Inventario y Demanda
                </p>
            </div>
        </div>
    </div>
</footer>
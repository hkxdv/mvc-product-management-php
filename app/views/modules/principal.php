<div class="container">
    <!-- Encabezado con banner -->
    <div class="row mb-5">
        <div class="col-12 text-center py-4 bg-light rounded shadow-sm">
            <p class="lead">Control y administración para una fábrica con tres tipos de productos</p>
            <hr class="my-4 w-75 mx-auto">
            <p class="text-muted">Optimizado para PostgreSQL | Arquitectura MVC</p>
        </div>
    </div>

    <!-- Tarjetas principales -->
    <div class="row mb-5">
        <!-- Productos -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title mb-0 text-center">
                        <i class="fas fa-boxes me-2"></i>Productos
                    </h5>
                </div>
                <div class="card-body text-center">
                    <p class="card-text">Administra información de los productos fabricados incluyendo costos y precios.</p>
                    <div class="d-grid">
                        <a href="index.php?option=productos" class="btn btn-outline-primary">
                            Gestionar Productos <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventario -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="card-title mb-0 text-center">
                        <i class="fas fa-warehouse me-2"></i>Inventario
                    </h5>
                </div>
                <div class="card-body text-center">
                    <p class="card-text">Controla las cantidades disponibles de cada producto en el inventario.</p>
                    <div class="d-grid">
                        <a href="index.php?option=inventario" class="btn btn-outline-success">
                            Gestionar Inventario <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Demanda -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="card-title mb-0 text-center">
                        <i class="fas fa-chart-line me-2"></i>Demanda
                    </h5>
                </div>
                <div class="card-body text-center">
                    <p class="card-text">Establece la demanda semanal estimada para cada uno de los productos.</p>
                    <div class="d-grid">
                        <a href="index.php?option=demanda" class="btn btn-outline-info">
                            Gestionar Demanda <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas secundarias -->
    <div class="row">
        <!-- Cálculos -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="card-title mb-0 text-center">
                        <i class="fas fa-calculator me-2"></i>Cálculos
                    </h5>
                </div>
                <div class="card-body text-center">
                    <p class="card-text">Verifica si el inventario es suficiente y calcula la producción adicional necesaria.</p>
                    <div class="d-grid">
                        <a href="index.php?option=calculos" class="btn btn-outline-warning">
                            Ver Cálculos <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reportes -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-header bg-danger text-white py-3">
                    <h5 class="card-title mb-0 text-center">
                        <i class="fas fa-chart-pie me-2"></i>Reportes
                    </h5>
                </div>
                <div class="card-body text-center">
                    <p class="card-text">Genera reportes detallados de ingresos esperados según la demanda semanal.</p>
                    <div class="d-grid">
                        <a href="index.php?option=reportes" class="btn btn-outline-danger">
                            Ver Reportes <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información adicional -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="alert alert-light border shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle fa-2x text-primary me-3"></i>
                    </div>
                    <div>
                        <h5>Sobre este sistema</h5>
                        <p class="mb-0">Este sistema implementa una solución para gestionar inventario, demanda y producción en una fábrica. Desarrollado con PHP, PostgreSQL y arquitectura MVC, optimizado para rendimiento y escalabilidad.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
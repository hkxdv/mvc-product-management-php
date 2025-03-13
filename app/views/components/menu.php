<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
    <div class="container">
        <!-- Logo y nombre -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <i class="fas fa-warehouse me-2"></i>
            <span>Inventario & Demanda</span>
        </a>
        
        <!-- Botón hamburguesa para móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Elementos del menú -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link px-3 d-flex align-items-center" href="index.php">
                        <i class="fas fa-home me-2"></i>Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 d-flex align-items-center" href="index.php?option=productos">
                        <i class="fas fa-boxes me-2"></i>Productos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 d-flex align-items-center" href="index.php?option=inventario">
                        <i class="fas fa-warehouse me-2"></i>Inventario
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 d-flex align-items-center" href="index.php?option=demanda">
                        <i class="fas fa-chart-line me-2"></i>Demanda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 d-flex align-items-center" href="index.php?option=calculos">
                        <i class="fas fa-calculator me-2"></i>Cálculos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 d-flex align-items-center" href="index.php?option=reportes">
                        <i class="fas fa-chart-pie me-2"></i>Reportes
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar-nav .nav-link {
        position: relative;
        transition: color 0.3s ease;
        border-radius: 4px;
    }
    
    .navbar-nav .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
    
    @media (min-width: 992px) {
        .navbar-nav .nav-link {
            margin: 0 2px;
        }
    }
</style>
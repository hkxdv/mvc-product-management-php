<div class="container">
    <!-- Encabezado -->
    <div class="row mb-4">
        <div class="col-12 bg-light p-4 rounded shadow-sm">
            <h2 class="text-success"><i class="fas fa-warehouse me-2"></i>Gestión de Inventario</h2>
            <p class="lead">Visualización y actualización del inventario para los productos disponibles</p>
        </div>
    </div>
    
    <!-- Tabla de Inventario -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Inventario Actual</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ID Producto</th>
                                    <th scope="col">Producto</th>
                                    <th scope="col" class="text-center">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $inventario = Controlador::mostrar_inventario_controlador();
                                if (empty($inventario)) { ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-3 text-muted">No hay registros de inventario disponibles</td>
                                    </tr>
                                <?php } else {
                                    foreach ($inventario as $item) { ?>
                                        <tr>
                                            <td><?php echo $item['fk_producto'] ?></td>
                                            <td><?php echo $item['producto'] ?></td>
                                            <td class="text-center fw-bold"><?php echo $item['cantidad'] ?> unidades</td>
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

    <!-- Formulario para actualizar inventario -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Actualizar Inventario</h5>
                </div>
                <div class="card-body p-4">
                    <form method="post" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="fk_producto" class="form-label">Seleccione un producto:</label>
                            <select class="form-select form-select-lg" id="fk_producto" name="fk_producto" required>
                                <option value="">-- Seleccione un producto --</option>
                                <?php
                                $productos = Controlador::listar_productos_controlador();
                                foreach ($productos as $producto) {
                                    echo '<option value="' . $producto['pk_productos'] . '">' . $producto['nombre'] . '</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">
                                Por favor seleccione un producto
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="cantidad" class="form-label">Nueva cantidad:</label>
                            <div class="input-group input-group-lg">
                                <input type="number" class="form-control" id="cantidad" name="cantidad" required min="0" placeholder="Ingrese la cantidad">
                                <span class="input-group-text">unidades</span>
                                <div class="invalid-feedback">
                                    Por favor ingrese una cantidad válida
                                </div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg"><i class="fas fa-save me-2"></i>Actualizar Inventario</button>
                        </div>
                    </form>
                    <?php Controlador::actualizar_inventario_controlador(); ?>
                </div>
            </div>
            
            <!-- Información adicional -->
            <div class="alert alert-light shadow-sm border">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle fa-2x text-success me-3"></i>
                    </div>
                    <div>
                        <h5>¿Cómo funciona?</h5>
                        <p class="mb-0">Actualice el inventario seleccionando un producto y estableciendo la nueva cantidad disponible. El sistema validará que la información ingresada sea correcta.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para validación del formulario -->
<script>
(function () {
    'use strict'
    
    // Obtener todos los formularios a los que queremos aplicar validación de Bootstrap
    var forms = document.querySelectorAll('.needs-validation')
    
    // Bucle sobre ellos y prevenir envío
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                
                form.classList.add('was-validated')
            }, false)
        })
})()
</script>
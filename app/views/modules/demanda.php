<div class="container">
    <!-- Encabezado -->
    <div class="row mb-4">
        <div class="col-12 bg-light p-4 rounded shadow-sm">
            <h2 class="text-info"><i class="fas fa-chart-line me-2"></i>Gestión de Demanda</h2>
            <p class="lead">Registro y actualización de la demanda semanal para los productos</p>
        </div>
    </div>
    
    <!-- Tabla de Demanda -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Demanda Registrada</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ID Producto</th>
                                    <th scope="col">Producto</th>
                                    <th scope="col" class="text-center">Demanda Semanal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $demandas = Controlador::mostrar_demanda_controlador();
                                if (empty($demandas)) { ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-3 text-muted">No hay registros de demanda disponibles</td>
                                    </tr>
                                <?php } else {
                                    foreach ($demandas as $demanda) { ?>
                                        <tr>
                                            <td><?php echo $demanda['fk_producto'] ?></td>
                                            <td><?php echo $demanda['producto'] ?></td>
                                            <td class="text-center fw-bold"><?php echo $demanda['cantidad'] ?> unidades</td>
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

    <!-- Formulario para registrar demanda -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Registrar Demanda</h5>
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
                            <label for="cantidad" class="form-label">Cantidad demandada:</label>
                            <div class="input-group input-group-lg">
                                <input type="number" class="form-control" id="cantidad" name="cantidad" required min="0" placeholder="Ingrese la cantidad demandada">
                                <span class="input-group-text">unidades</span>
                                <div class="invalid-feedback">
                                    Por favor ingrese una cantidad válida
                                </div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-info btn-lg text-white"><i class="fas fa-save me-2"></i>Registrar Demanda</button>
                        </div>
                    </form>
                    <?php Controlador::registrar_demanda_controlador(); ?>
                </div>
            </div>
            
            <!-- Información adicional -->
            <div class="alert alert-light shadow-sm border">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle fa-2x text-info me-3"></i>
                    </div>
                    <div>
                        <h5>¿Cómo funciona?</h5>
                        <p class="mb-0">Registre la demanda semanal seleccionando un producto y estableciendo la cantidad estimada. Si ya existe una demanda para el producto, se actualizará con el nuevo valor.</p>
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
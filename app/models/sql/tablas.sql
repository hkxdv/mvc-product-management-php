-- Tabla de productos
CREATE TABLE productos (
    pk_productos INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    costo_produccion DECIMAL(10,2) NOT NULL,
    precio_venta DECIMAL(10,2) NOT NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de inventario
CREATE TABLE inventario (
    pk_inventario INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    fk_producto INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 0,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (fk_producto) REFERENCES productos(pk_productos) ON DELETE CASCADE
);

-- Tabla de demanda semanal
CREATE TABLE demanda (
    pk_demanda INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    fk_producto INT NOT NULL,
    cantidad INT NOT NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (fk_producto) REFERENCES productos(pk_productos) ON DELETE CASCADE
);

-- Tabla de producción adicional
CREATE TABLE produccion_adicional (
    pk_produccion_adicional INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    fk_producto INT NOT NULL,
    cantidad INT NOT NULL,
    fecha_produccion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (fk_producto) REFERENCES productos(pk_productos) ON DELETE CASCADE
);

-- Tabla de enlaces para el sistema de navegación
CREATE TABLE enlaces (
    pk_enlaces INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(55) NOT NULL,
    ruta VARCHAR(100) NOT NULL,
    estado INT NOT NULL DEFAULT 1,
    hora TIMESTAMP NOT NULL,
    fecha DATE NOT NULL
);

-- Insertar enlaces 
INSERT INTO enlaces (nombre, ruta, estado, hora, fecha) VALUES 
('principal', 'app/views/modules/principal.php', 1, CURRENT_TIME, CURRENT_DATE),
('productos', 'app/views/modules/productos.php', 1, CURRENT_TIME, CURRENT_DATE),
('inventario', 'app/views/modules/inventario.php', 1, CURRENT_TIME, CURRENT_DATE),
('demanda', 'app/views/modules/demanda.php', 1, CURRENT_TIME, CURRENT_DATE),
('calculos', 'app/views/modules/calculos.php', 1, CURRENT_TIME, CURRENT_DATE),
('reportes', 'app/views/modules/reportes.php', 1, CURRENT_TIME, CURRENT_DATE);

-- Insertar productos (los tres tipos de productos mencionados en el problema)
INSERT INTO productos (nombre, costo_produccion, precio_venta) VALUES 
('Producto A', 50.00, 120.00),
('Producto B', 75.00, 180.00),
('Producto C', 100.00, 250.00);

-- Insertar inventario inicial
INSERT INTO inventario (fk_producto, cantidad) VALUES 
(1, 100), -- 100 unidades del Producto A
(2, 150), -- 150 unidades del Producto B
(3, 80);  -- 80 unidades del Producto C

-- Insertar demanda semanal estimada
INSERT INTO demanda (fk_producto, cantidad) VALUES 
(1, 120), -- Demanda de 120 unidades del Producto A
(2, 100), -- Demanda de 100 unidades del Producto B
(3, 90);  -- Demanda de 90 unidades del Producto C


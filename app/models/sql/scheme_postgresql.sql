-- Esquema SQL para PostgreSQL con Normalizacion 3FN --
-- Sistema de Gestion de Inventario y Demanda

-- Tabla de productos
CREATE TABLE productos (
    pk_productos SERIAL PRIMARY KEY NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    costo_produccion DECIMAL(10,2) NOT NULL,
    precio_venta DECIMAL(10,2) NOT NULL,
    hora TIME NOT NULL DEFAULT CURRENT_TIME,
    fecha DATE NOT NULL DEFAULT CURRENT_DATE,
    estado SMALLINT NOT NULL DEFAULT 1
);

-- Tabla de inventario
CREATE TABLE inventario (
    pk_inventario SERIAL PRIMARY KEY NOT NULL,
    fk_producto INTEGER NOT NULL,
    cantidad INTEGER NOT NULL DEFAULT 0,
    hora TIME NOT NULL DEFAULT CURRENT_TIME,
    fecha DATE NOT NULL DEFAULT CURRENT_DATE,
    estado SMALLINT NOT NULL DEFAULT 1,
    FOREIGN KEY (fk_producto) REFERENCES productos(pk_productos) ON DELETE RESTRICT
);

-- Tabla de demanda semanal
CREATE TABLE demanda (
    pk_demanda SERIAL PRIMARY KEY NOT NULL,
    fk_producto INTEGER NOT NULL,
    cantidad INTEGER NOT NULL,
    hora TIME NOT NULL DEFAULT CURRENT_TIME,
    fecha DATE NOT NULL DEFAULT CURRENT_DATE,
    estado SMALLINT NOT NULL DEFAULT 1,
    FOREIGN KEY (fk_producto) REFERENCES productos(pk_productos) ON DELETE RESTRICT
);

-- Tabla de producción adicional
CREATE TABLE produccion_adicional (
    pk_produccion_adicional SERIAL PRIMARY KEY NOT NULL,
    fk_producto INTEGER NOT NULL,
    cantidad INTEGER NOT NULL,
    hora TIME NOT NULL DEFAULT CURRENT_TIME,
    fecha DATE NOT NULL DEFAULT CURRENT_DATE,
    estado SMALLINT NOT NULL DEFAULT 1,
    FOREIGN KEY (fk_producto) REFERENCES productos(pk_productos) ON DELETE RESTRICT
);

-- Tabla de enlaces para el sistema de navegación
CREATE TABLE enlaces (
    pk_enlaces SERIAL PRIMARY KEY NOT NULL,
    nombre VARCHAR(55) NOT NULL,
    ruta VARCHAR(100) NOT NULL,
    hora TIME NOT NULL DEFAULT CURRENT_TIME,
    fecha DATE NOT NULL DEFAULT CURRENT_DATE,
    estado SMALLINT NOT NULL DEFAULT 1
);

-- Insertar enlaces 
INSERT INTO enlaces (nombre, ruta) VALUES 
('principal', 'app/views/modules/principal.php'),
('productos', 'app/views/modules/productos.php'),
('inventario', 'app/views/modules/inventario.php'),
('demanda', 'app/views/modules/demanda.php'),
('calculos', 'app/views/modules/calculos.php'),
('reportes', 'app/views/modules/reportes.php');

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

-- Esquema de la tabla de productos
DROP TABLE IF EXISTS productos;
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombreProducto VARCHAR(100) NOT NULL,
    descripcionProducto TEXT,
    precioProducto DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Datos de ejemplo para la tabla productos
INSERT INTO productos (nombreProducto, descripcionProducto, precioProducto) VALUES
('Laptop HP', 'Laptop HP 15.6 pulgadas, Core i5, 8GB RAM, 256GB SSD', 899.99),
('Monitor LG', 'Monitor LG 24 pulgadas, Full HD', 199.99),
('Teclado Mecánico', 'Teclado mecánico RGB con switches Cherry MX', 89.99),
('Mouse Inalámbrico', 'Mouse inalámbrico ergonómico con 6 botones', 29.99);

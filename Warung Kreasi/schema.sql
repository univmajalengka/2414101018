CREATE DATABASE IF NOT EXISTS warung_kreasi CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE warung_kreasi;

CREATE TABLE foods (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  price DECIMAL(12,2) NOT NULL,
  category VARCHAR(100) DEFAULT 'Umum',
  image VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_name VARCHAR(150) NOT NULL,
  phone VARCHAR(50) NOT NULL,
  visit_date DATE NOT NULL,
  total DECIMAL(14,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  food_id INT NOT NULL,
  name VARCHAR(150) NOT NULL,
  price DECIMAL(12,2) NOT NULL,
  quantity INT NOT NULL,
  subtotal DECIMAL(14,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

INSERT INTO admins (username, password) VALUES ('admin', MD5('admin123'));

INSERT INTO foods (name, description, price, category, image) VALUES
('Tahu Goreng', 'Tahu goreng renyah di luar, lembut di dalam, gurihnya bikin nagih!', 10000, 'Makanan', 'tahugoreng.jpg'),
('Sosis Bakar', 'Sosis bakar gurih dengan bumbu pedas manis', 12000, 'Makanan', 'sosisbakar.jpg'),
('Pisang Lumer', 'Pisang lumer keju dan cokelat, cocok untuk cemilan sore', 8000, 'Dessert', 'pisanglumer.jpg');

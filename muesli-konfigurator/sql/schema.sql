CREATE DATABASE IF NOT EXISTS muesli_konfigurator CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE muesli_konfigurator;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    street VARCHAR(150) NOT NULL,
    zip_code VARCHAR(20) NOT NULL,
    city VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS configurations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    config_name VARCHAR(150) NOT NULL,
    base VARCHAR(100) NOT NULL,
    ingredients TEXT NOT NULL,
    extras TEXT,
    label_text VARCHAR(150),
    total_price DECIMAL(10,2) NOT NULL,
    coupon_code VARCHAR(50) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

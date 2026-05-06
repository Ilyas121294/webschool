CREATE DATABASE school_db;
USE school_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    nama VARCHAR(100),
    role VARCHAR(20) DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pendaftaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_reg VARCHAR(20) UNIQUE,
    nisn VARCHAR(20),
    nama VARCHAR(100),
    jurusan VARCHAR(50),
    status VARCHAR(20) DEFAULT 'Menunggu',
    telp VARCHAR(15),
    data JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username,password,nama) VALUES 
('admin','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','Admin');

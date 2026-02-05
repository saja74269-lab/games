-- Database setup for PT Roti
-- Run this SQL script to create the required tables

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS pt_roti1;
USE pt_roti1;

-- Table for barang masuk (incoming goods)
CREATE TABLE IF NOT EXISTS barang_masuk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    nama_barang VARCHAR(255) NOT NULL,
    supplier VARCHAR(255) NOT NULL,
    jumlah INT NOT NULL,
    satuan VARCHAR(50) NOT NULL,
    harga_satuan DECIMAL(15,2) NOT NULL,
    total_harga DECIMAL(15,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for barang keluar (outgoing goods/sales)
CREATE TABLE IF NOT EXISTS barang_keluar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    nama_produk VARCHAR(255) NOT NULL,
    customer VARCHAR(255) NOT NULL,
    jumlah INT NOT NULL,
    satuan VARCHAR(50) NOT NULL,
    harga_jual DECIMAL(15,2) NOT NULL,
    total_penjualan DECIMAL(15,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for gaji karyawan (employee salaries)
CREATE TABLE IF NOT EXISTS gaji (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    jabatan VARCHAR(255) NOT NULL,
    gaji_pokok DECIMAL(15,2) NOT NULL,
    lembur DECIMAL(15,2) DEFAULT 0,
    potongan DECIMAL(15,2) DEFAULT 0,
    total_gaji DECIMAL(15,2) NOT NULL,
    tanggal_bayar DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for pengeluaran (company expenses)
CREATE TABLE IF NOT EXISTS pengeluaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    jenis VARCHAR(255) NOT NULL,
    biaya DECIMAL(15,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for users (login system) - Updated structure
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for suppliers
CREATE TABLE IF NOT EXISTS suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_supplier VARCHAR(255) NOT NULL,
    alamat TEXT,
    telepon VARCHAR(20),
    email VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for customers
CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_customer VARCHAR(255) NOT NULL,
    alamat TEXT,
    telepon VARCHAR(20),
    email VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for jabatan (positions)
CREATE TABLE IF NOT EXISTS jabatan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_jabatan VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (password: admin123)
INSERT IGNORE INTO users (nama_lengkap, email, username, password) VALUES 
('Administrator', 'admin@ptroti.com', 'admin', MD5('admin123'));

-- Insert sample suppliers
INSERT IGNORE INTO suppliers (nama_supplier, alamat, telepon, email) VALUES 
('PT Tepung Terigu Indonesia', 'Jl. Industri No. 123, Jakarta', '021-1234567', 'info@tepungterigu.com'),
('CV Gula Pasir Makmur', 'Jl. Perdagangan No. 456, Bandung', '022-7654321', 'sales@gulapasir.com'),
('UD Ragi Roti Segar', 'Jl. Pasar No. 789, Surabaya', '031-9876543', 'order@ragiroti.com'),
('PT Minyak Goreng Sehat', 'Jl. Industri No. 321, Medan', '061-4567890', 'contact@minyakgoreng.com'),
('CV Garam Laut Bersih', 'Jl. Pelabuhan No. 654, Semarang', '024-1357924', 'info@garamlaut.com');

-- Insert sample customers
INSERT IGNORE INTO customers (nama_customer, alamat, telepon, email) VALUES 
('Toko Roti Sari', 'Jl. Pasar No. 111, Jakarta', '021-1111111', 'sari@tokoroti.com'),
('Bakery Cita Rasa', 'Jl. Raya No. 222, Bandung', '022-2222222', 'info@bakerycita.com'),
('Warung Roti Enak', 'Jl. Gang No. 333, Surabaya', '031-3333333', 'enak@warungroti.com'),
('Kedai Roti Manis', 'Jl. Utama No. 444, Medan', '061-4444444', 'manis@kedairoti.com'),
('Toko Kue Lezat', 'Jl. Indah No. 555, Semarang', '024-5555555', 'lezat@tokokue.com');

-- Insert sample jabatan
INSERT IGNORE INTO jabatan (nama_jabatan) VALUES 
('Manager Produksi'),
('Supervisor'),
('Operator Mesin'),
('Pembuat Roti'),
('Packing'),
('Quality Control'),
('Driver'),
('Security'),
('Cleaning Service'),
('Admin');

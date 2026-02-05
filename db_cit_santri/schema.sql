-- Create database and table for CIT Boarding School santri login system
CREATE DATABASE IF NOT EXISTS db_cit_santri CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE db_cit_santri;

-- Table: tb_santri
DROP TABLE IF EXISTS tb_santri;
CREATE TABLE tb_santri (
    id_santri INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL, -- MD5 or bcrypt hash
    nama_lengkap VARCHAR(100) NOT NULL,
    kelas VARCHAR(30) NOT NULL,
    pengalaman TEXT NOT NULL,
    PRIMARY KEY (id_santri)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



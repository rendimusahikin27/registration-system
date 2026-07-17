-- schema.sql
-- Jalankan file ini di phpMyAdmin atau lewat CLI mysql untuk membuat database & tabel.
-- Contoh CLI: mysql -u root -p < schema.sql

CREATE DATABASE IF NOT EXISTS sistem_pendaftaran
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE sistem_pendaftaran;

CREATE TABLE IF NOT EXISTS peserta (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  whatsapp VARCHAR(20) NOT NULL,
  acara VARCHAR(150) NOT NULL,
  catatan TEXT NULL,
  waktu_daftar DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Contoh data (opsional, boleh dihapus)
INSERT INTO peserta (nama, email, whatsapp, acara, catatan) VALUES
('Contoh Peserta', 'contoh@email.com', '081234567890', 'Workshop Web Development', 'Datang bersama 1 teman');

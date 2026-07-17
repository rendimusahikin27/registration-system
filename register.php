<?php
/**
 * register.php
 * Memproses form pendaftaran: validasi input lalu simpan ke tabel `peserta`
 * menggunakan prepared statement (aman dari SQL injection).
 */

// Cegah warning/notice PHP ikut tercetak dan merusak output JSON.
// Error tetap dicatat ke log server, hanya tidak ditampilkan ke browser.
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

// Tampung semua output "liar" (warning, notice, dsb) lalu buang,
// supaya hanya JSON yang benar-benar dikirim ke browser.
ob_start();

header('Content-Type: application/json');
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Metode tidak diizinkan.']);
    exit;
}

$nama     = isset($_POST['nama']) ? trim(strip_tags($_POST['nama'])) : '';
$email    = isset($_POST['email']) ? trim(strip_tags($_POST['email'])) : '';
$whatsapp = isset($_POST['whatsapp']) ? trim(strip_tags($_POST['whatsapp'])) : '';
$acara    = isset($_POST['acara']) ? trim(strip_tags($_POST['acara'])) : '';
$catatan  = isset($_POST['catatan']) ? trim(strip_tags($_POST['catatan'])) : '';

$errors = [];

if ($nama === '' || mb_strlen($nama) < 2) {
    $errors[] = 'Nama minimal 2 karakter.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Format email tidak valid.';
}
if (!preg_match('/^[0-9+\-\s()]{8,20}$/', $whatsapp)) {
    $errors[] = 'Nomor WhatsApp tidak valid.';
}
if ($acara === '') {
    $errors[] = 'Acara harus dipilih.';
}

if (!empty($errors)) {
    http_response_code(422);
    ob_clean();
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

$conn = getDbConnection();

$stmt = $conn->prepare(
    'INSERT INTO peserta (nama, email, whatsapp, acara, catatan) VALUES (?, ?, ?, ?, ?)'
);
$stmt->bind_param('sssss', $nama, $email, $whatsapp, $acara, $catatan);

if ($stmt->execute()) {
    ob_clean();
    echo json_encode(['success' => true, 'message' => 'Pendaftaran berhasil.']);
} else {
    http_response_code(500);
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan data. Coba lagi.']);
}

$stmt->close();
$conn->close();
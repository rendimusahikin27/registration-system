<?php

define("DB_HOST", "localhost");
define("DB_USER", "");
define("DB_PASS", "");
define("DB_NAME", "");

define("ADMIN_USERNAME", "admin");
define("ADMIN_PASSWORD", "admin123");

function getDbConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        http_response_code((500));
        die(json_encode([
            "success" => false,
            "message" => "Koneksi database gagal. Periksa konfigurasi di config.php."
        ]));
    }
    $conn->set_charset("utf8mb4");
    return $conn;
}
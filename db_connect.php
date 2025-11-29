<?php
// DB connection parameters (ganti sesuai yang Railway berikan)
$db_host = "shuttle.proxy.rlwy.net";
$db_port = 12655;
$db_user = "root";
$db_pass = "qdWOxsWxeRuVwiBvVvjTZTDsOpthownw";  // ganti dengan password asli
$db_name = "railway";

// buat koneksi
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

// cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// opsional: set charset
$conn->set_charset("utf8mb4");
?>
<?php
$servername = "localhost";
$username = "root"; // Default username untuk XAMPP/WAMP
$password = "";     // Default password kosong untuk XAMPP/WAMP
$dbname = "register_wa";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
echo "Koneksi berhasil!";
?>


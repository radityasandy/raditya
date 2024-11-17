<?php
include 'koneksi.php';
include 'notifwa.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Menyaring input untuk mencegah XSS
    $nama = htmlspecialchars($_POST['nama']);
    $kelas = htmlspecialchars($_POST['kelas']);
    $nisn = htmlspecialchars($_POST['nisn']);
    $absen = htmlspecialchars($_POST['absen']);
    $email = htmlspecialchars($_POST['email']);
    $telepon = htmlspecialchars($_POST['telepon']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $rfid = htmlspecialchars($_POST['rfid']);


    // Perbaikan query untuk memasukkan data ke dalam database
    $sql = "INSERT INTO siswa_tabel (nama, kelas, nisn, absen, email, telepon, alamat, rfid) VALUES (?, ?, ?, ?, ?, ?,?,?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('MySQL prepare error: ' . $conn->error);
    }

    // Binding parameter ke query
    $stmt->bind_param("ssisssss", $nama, $kelas, $nisn, $absen, $email, $telepon, $alamat, $rfid);



    // Eksekusi statement dan cek hasilnya
    if ($stmt->execute()) {
        $message = "Data Berhasil disimpan.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    // Menutup statement dan koneksi
    $stmt->close();
    $conn->close();

    // Redirect user dengan pesan sukses
    header("Location: list.php?success=$message");
    exit();
} else {
    // Menampilkan pesan kesalahan jika metode yang digunakan bukan POST
    echo "Invalid request method.";
}
?>

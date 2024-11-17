<?php
include 'koneksi.php';

// Ambil data waktu masuk dan pulang saat ini
$query = "SELECT * FROM setting_waktu_absen WHERE id = 1";
$result = mysqli_query($conn, $query);
$current_setting = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$waktu_masuk = $_POST['waktu_masuk'];
$waktu_pulang = $_POST['waktu_pulang'];

if ($current_setting) {
// Update jika sudah ada pengaturan
$update_query = "UPDATE setting_waktu_absen SET waktu_masuk = '$waktu_masuk',
waktu_pulang = '$waktu_pulang' WHERE id = 1";
mysqli_query($conn, $update_query);
} else {

// Insert jika belum ada pengaturan
$insert_query = "INSERT INTO setting_waktu_absen (waktu_masuk, waktu_pulang) VALUES
('$waktu_masuk', '$waktu_pulang')";
mysqli_query($conn, $insert_query);
}
echo "Pengaturan waktu berhasil disimpan!";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<title>Pengaturan Waktu Masuk dan Pulang</title>
</head>

<body>
<h2>Pengaturan Waktu Masuk dan Pulang</h2>
<form method="POST">
<label>Waktu Masuk:</label>
<input type="time" name="waktu_masuk" value="<?php echo $current_setting['waktu_masuk']
?? ''; ?>" required><br><br>

<label>Waktu Pulang:</label>
<input type="time" name="waktu_pulang" value="<?php echo
$current_setting['waktu_pulang'] ?? ''; ?>" required><br><br>

<button type="submit">Simpan</button>
</form>
</body>

</html>
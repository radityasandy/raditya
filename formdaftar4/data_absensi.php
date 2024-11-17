<?php
include 'koneksi.php'; // Menghubungkan ke database

// Set waktu standar masuk dan pulang
$waktu_masuk_standar = "06:45:00";
$waktu_pulang_standar = "14:00:00";

// Query untuk mendapatkan data absensi siswa
$sql = "
    SELECT
        siswa_tabel.id,
        siswa_tabel.nama,
        siswa_tabel.kelas,
        absensi.tanggal,
        absensi.waktu_masuk,
        absensi.waktu_pulang
    FROM absensi
    JOIN siswa_tabel ON absensi.id_siswa = siswa_tabel.id
    ORDER BY absensi.tanggal DESC
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Membuat tabel jika ada data
    echo '<table border="1">
        <tr>
            <th>ID Siswa</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Tanggal</th>
            <th>Waktu Masuk</th>
            <th>Status Masuk</th>
            <th>Waktu Pulang</th>
            <th>Status Pulang</th>
        </tr>';

    // Output data dari setiap baris
    while ($row = $result->fetch_assoc()) {
        // Tentukan status masuk berdasarkan waktu masuk
        if (strtotime($row['waktu_masuk']) > strtotime($waktu_masuk_standar)) {
            $status_masuk = "Terlambat";
        } else {
            $status_masuk = "Tepat Waktu";
        }

        // Tentukan status pulang berdasarkan waktu pulang
        if (strtotime($row['waktu_pulang']) < strtotime($waktu_pulang_standar)) {
            $status_pulang = "Pulang";
        } else {
            $status_pulang = "Tepat Waktu";
        }

        echo "<tr>
            <td>" . $row['id'] . "</td>
            <td>" . $row['nama'] . "</td>
            <td>" . $row['kelas'] . "</td>
            <td>" . $row['tanggal'] . "</td>
            <td>" . $row['waktu_masuk'] . "</td>
            <td>" . $status_masuk . "</td>
            <td>" . $row['waktu_pulang'] . "</td>
            <td>" . $status_pulang . "</td>
        </tr>";
    }

    echo "</table>"; // Menutup tabel
} else {
    echo "Tidak ada data absensi."; // Pesan jika tidak ada data
}

$conn->close(); // Menutup koneksi
?>

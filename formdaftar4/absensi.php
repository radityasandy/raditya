<?php
// Sertakan file koneksi.php dan notifikasi_absensi.php untuk menghubungkan ke database dan mengirimkan notifikasi
date_default_timezone_set('Asia/Jakarta');
include 'koneksi.php';
include 'notif_absensi.php';
// include 'setting_waktu.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rfid = $_POST['rfid'];
    $tanggal = date("Y-m-d");
    $waktu = date("H:i:s");

    // Waktu standar masuk dan pulang
    $waktu_masuk_standar = "06:45:00";
    $waktu_pulang_standar = "14:00:00";

    // Query untuk mencari siswa dengan RFID tersebut
    $query_siswa = $conn->prepare("SELECT id, nama, telepon FROM siswa_tabel WHERE rfid = ?");
    $query_siswa->bind_param("s", $rfid);
    $query_siswa->execute();
    $result_siswa = $query_siswa->get_result();

    if ($result_siswa->num_rows > 0) {
        $siswa = $result_siswa->fetch_assoc();
        $id_siswa = $siswa['id'];
        $nama_siswa = $siswa['nama'];
        $no_hp_siswa = $siswa['telepon'];

        // Cek apakah sudah absen masuk hari ini
        $query_absen = $conn->prepare("SELECT * FROM absensi WHERE id_siswa = ? AND tanggal = ?");
        $query_absen->bind_param("is", $id_siswa, $tanggal);
        $query_absen->execute();
        $result_absen = $query_absen->get_result();

        if ($result_absen->num_rows == 0) {
            // Insert absen masuk jika belum ada absen hari ini
            $status_masuk = (strtotime($waktu) > strtotime($waktu_masuk_standar)) ? "Terlambat" : "Tepat Waktu";
            $insert_query = $conn->prepare("INSERT INTO absensi (id_siswa, tanggal, waktu_masuk, status_masuk) VALUES (?, ?, ?, ?)");
            $insert_query->bind_param("isss", $id_siswa, $tanggal, $waktu, $status_masuk);

            if ($insert_query->execute()) {
                // Respons berhasil untuk absensi masuk
                echo "Absensi masuk berhasil untuk $nama_siswa pada $tanggal pukul $waktu dengan status: $status_masuk.";

                // Kirim notifikasi WA
                $pesan = "Halo, $nama_siswa telah melakukan absen masuk pada tanggal $tanggal pukul $waktu dengan status $status_masuk.";
                kirimNotifikasi($no_hp_siswa, $pesan);
            } else {
                echo "Error: Gagal mencatat absensi masuk.";
            }
        } else {
            // Update absen untuk waktu pulang
            $status_pulang = (strtotime($waktu) < strtotime($waktu_pulang_standar)) ? "Pulang" : "Tepat Waktu";
            $update_query = $conn->prepare("UPDATE absensi SET waktu_pulang = ?, status_pulang = ? WHERE id_siswa = ? AND tanggal = ?");
            $update_query->bind_param("ssis", $waktu, $status_pulang, $id_siswa, $tanggal);

            if ($update_query->execute()) {
                // Respons berhasil untuk absensi pulang
                echo "Absensi pulang berhasil untuk $nama_siswa pada $tanggal pukul $waktu dengan status: $status_pulang.";

                // Kirim notifikasi WA
                $pesan = "Halo, $nama_siswa telah melakukan absen pulang pada tanggal $tanggal pukul $waktu dengan status $status_pulang.";
                kirimNotifikasi($no_hp_siswa, $pesan);
            } else {
                echo "Error: Gagal mencatat waktu pulang.";
            }
        }
    } else {
        echo "RFID tidak ditemukan atau belum terdaftar.";
    }
} else {
    echo "Metode request tidak valid.";
}
?>

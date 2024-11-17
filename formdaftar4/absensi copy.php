<?php
include 'koneksi.php';
include 'notif_absensi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rfid = $_POST['rfid'];
    $tanggal = date("Y-m-d");
    $waktu = date("H:i:s");

    // Query untuk mencari ID siswa berdasarkan RFID
    $query_siswa = "SELECT id FROM siswa_tabel WHERE rfid = ?";
    $stmt = $conn->prepare($query_siswa);

    // Cek apakah prepare berhasil
    if (!$stmt) {
        die("Query error (siswa): " . $conn->error);
    }

    $stmt->bind_param("s", $rfid);
    $stmt->execute();
    $result_siswa = $stmt->get_result();

    if ($result_siswa->num_rows > 0) {
        $siswa = $result_siswa->fetch_assoc();
        $id_siswa = $siswa['id'];

        // Query untuk memeriksa apakah siswa sudah absen masuk di tanggal yang sama
        $query_absen = "SELECT * FROM absensi WHERE id_siswa = ? AND tanggal = ?";
        $stmt_absen = $conn->prepare($query_absen);

        if (!$stmt_absen) {
            die("Query error (absen): " . $conn->error);
        }

        $stmt_absen->bind_param("is", $id_siswa, $tanggal);
        $stmt_absen->execute();
        $result_absen = $stmt_absen->get_result();

        if ($result_absen->num_rows > 0) {
            // Jika siswa sudah absen masuk, maka catat waktu pulang
            $update_query = "UPDATE absensi SET waktu_pulang = ?, status_pulang = 'Pulang' WHERE id_siswa = ? AND tanggal = ?";
            $stmt_update = $conn->prepare($update_query);

            if (!$stmt_update) {
                die("Query error (update): " . $conn->error);
            }

            $stmt_update->bind_param("sis", $waktu, $id_siswa, $tanggal);
            if ($stmt_update->execute()) {
                echo "Waktu pulang berhasil tercatat pada pukul $waktu!";
            } else {
                echo "Error: " . $stmt_update->error;
            }

            $stmt_update->close();
        } else {
            // Jika belum absen, masukkan data absensi sebagai waktu masuk
            $insert_query = "INSERT INTO absensi (id_siswa, tanggal, waktu_masuk, status_masuk) VALUES (?, ?, ?, 'Hadir')";
            $stmt_insert = $conn->prepare($insert_query);

            if (!$stmt_insert) {
                die("Query error (insert): " . $conn->error);
            }

            $stmt_insert->bind_param("iss", $id_siswa, $tanggal, $waktu);
            if ($stmt_insert->execute()) {
                echo "Absensi masuk berhasil tercatat pada pukul $waktu!";
            } else {
                echo "Error: " . $stmt_insert->error;
            }

            $stmt_insert->close();
        }
    } else {
        echo "RFID tidak ditemukan.";
    }

    $stmt->close();
    $stmt_absen->close();
}

$conn->close(); // Menutup koneksi
?>

<?php
function kirimNotifikasi($telepon, $pesan)
{
    $token = "qYWngG_LBBbcKSwz8_ad"; // Ganti dengan token Fonnte kamu
    $url = "https://api.fonnte.com/send";

    // Data yang akan dikirim
    $data = [
        'target'  => $telepon,    // Nomor HP tujuan (gunakan format internasional, misal: 628xxxxxxxxxx)
        'message' => $pesan,      // Pesan yang akan dikirim
    ];

    // Header untuk otentikasi
    $header = [
        "Authorization: $token",
        "Content-Type: application/x-www-form-urlencoded"
    ];

    // Inisiasi cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Eksekusi dan ambil respons
    $response = curl_exec($ch);

    // Cek apakah ada error
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        echo "Error: " . $error_msg;  // Menampilkan error jika ada
    } else {
        // Menampilkan response dari API
        echo "Response dari API: " . $response;
    }

    // Tutup cURL
    curl_close($ch);
}
?>

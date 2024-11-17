document.getElementById('absenform').addEventListener('submit', function (event) {
    event.preventDefault(); // Mencegah halaman melakukan refresh saat form dikirim

    const formData = new FormData(this); // Mengambil data dari form

    fetch('absensi.php', {
        method: 'POST', // Menggunakan metode POST untuk pengiriman data
        body: formData // Mengirimkan data form ke server
    })
    .then(response => response.text()) // Mengambil response dalam bentuk teks
    .then(data => {
        document.getElementById('response').textContent = data; // Menampilkan hasil respons dari server
        document.getElementById('rfid').value = ''; // Mengosongkan input setelah submit
    })
    .catch(error => console.error('Error:', error)); // Menangkap dan menampilkan kesalahan jika ada
});

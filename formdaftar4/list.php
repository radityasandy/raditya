<?php
include 'koneksi.php';

// Fetch students from database
$sql = "SELECT * FROM siswa_tabel";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    padding: 20px;
    margin: 0;
}

.container {
    max-width: 1000px;
    margin: auto;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    overflow-x: auto; /* Allows horizontal scrolling if content overflows */
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    min-width: 1000px; /* Ensures the table has a minimum width */
}

th, td {
    padding: 12px;
    text-align: left;
    vertical-align: middle;
    border-bottom: 2px solid #ddd;
    border-right: 2px solid #ddd;
}

th {
    background-color: #f4f4f4;
    color: #333;
    border-top: 2px solid #ccc;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f1f1f1;
}

tr:last-child td {
    border-bottom: 0;
}

td:last-child, th:last-child {
    border-right: 0;
}

.no-data {
    text-align: center;
    padding: 20px;
    font-size: 18px;
    color: #666;
}

a {
    display: inline-block;
    margin-top: 20px;
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
}

.actions a {
    margin-right: 10px;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Siswa</h1>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Nama Lengkap</th>
                        <th>NISN</th>
                        <th>Kelas</th>
                        <th>Absen</th>
                        <th>Email</th>
                        <th>Nomor Telepon</th>
                        <th>Alamat</th>
                        <th>rfid</th>
                        <th>tanggal_daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td><?php echo htmlspecialchars($row['nisn']); ?></td>
                            <td><?php echo htmlspecialchars($row['kelas']); ?></td>
                            <td><?php echo htmlspecialchars($row['absen']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['telepon']); ?></td>
                            <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                            <td><?php echo htmlspecialchars($row['rfid']); ?></td>
                            <td><?php echo htmlspecialchars($row['tanggal_daftar']); ?></td>
                            <td>
                                <a href="update.php?id=<?php echo htmlspecialchars($row['id']); ?>">Update</a>  
                                <a href="delete.php?id=<?php echo htmlspecialchars($row['id']); ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">Belum ada data siswa.</p>
        <?php endif; ?>
        <a href="register.html">Kembali ke Formulir Pendaftaran</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>

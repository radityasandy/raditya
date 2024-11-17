<?php
include 'koneksi.php';

$id = $_GET['id'] ?? null;

if ($id) {
    // Fetch the student data
    $sql = "SELECT * FROM siswa_tabel WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();
} else {
    header("Location: index.php"); // Redirect if no ID is provided
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $name = htmlspecialchars($_POST['name']);
    $nisn = htmlspecialchars($_POST['nisn']);
    $kelas = htmlspecialchars($_POST['kelas']);
    $absen = htmlspecialchars($_POST['absen']);
    $email = htmlspecialchars($_POST['email']);
    $telepon = htmlspecialchars($_POST['telepon']);
    $alamat = htmlspecialchars($_POST['alamat']);

    // Update student data
    $sql = "UPDATE siswa_tabel SET nama = ?, nisn = ?, kelas = ?, absen = ?, email = ?, telepon = ?, alamat = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissssi", $name, $nisn, $kelas, $absen, $email, $telepon, $alamat, $id);

    if ($stmt->execute()) {
        $message = "Data Berhasil diperbarui.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            color: green;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            width: 100%;
            margin-top: 10px;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Update Data Siswa</h1>
        <div class="message"><?php echo isset($message) ? $message : ''; ?></div>
        <form action="update.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
            <div class="form-group">
                <label for="name">Nama Lengkap:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($student['nama']); ?>" required />
            </div>
            <div class="form-group">
                <label for="nisn">NISN:</label>
                <input type="text" id="nisn" name="nisn" value="<?php echo htmlspecialchars($student['nisn']); ?>" required />
            </div>
            <div class="form-group">
                <label for="kelas">Kelas:</label>
                <input type="text" id="kelas" name="kelas" value="<?php echo htmlspecialchars($student['kelas']); ?>" required />
            </div>
            <div class="form-group">
                <label for="absen">Absen:</label>
                <input type="number" id="absen" name="absen" value="<?php echo htmlspecialchars($student['absen']); ?>" required />
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required />
            </div>
            <div class="form-group">
                <label for="telepon">Nomor Telepon:</label>
                <input type="tel" id="telepon" name="telepon" value="<?php echo htmlspecialchars($student['telepon']); ?>" required />
            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" id="alamat" name="alamat" value="<?php echo htmlspecialchars($student['alamat']); ?>" required />
            </div>
            <div class="form-group">
                <button type="submit">Update</button>
            </div>
        </form>
        <a href="list.php">Kembali ke List Siswa</a>
    </div>
</body>
</html>

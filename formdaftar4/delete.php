<?php
include 'koneksi.php';

$id = $_GET['id'] ?? null;

if ($id) {
    // Sanitize and validate the ID to ensure it is a valid integer
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        // Prepare the SQL delete statement
        $sql = "DELETE FROM siswa_tabel WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind the ID to the statement
            $stmt->bind_param("i", $id);

            // Execute the statement and check if it was successful
            if ($stmt->execute()) {
                $message = "Data Berhasil dihapus.";
            } else {
                $message = "Error: " . $stmt->error;
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            $message = "Error: Unable to prepare statement.";
        }
    } else {
        $message = "ID tidak valid.";
    }

    // Close the database connection
    $conn->close();
} else {
    $message = "ID tidak ditemukan.";
}

// Redirect to the list page with a message
header("Location: list.php?message=" . urlencode($message));
exit();
?>

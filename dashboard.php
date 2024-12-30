<?php
session_start();
include 'db.php'; // Menghubungkan ke database

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Arahkan ke halaman login jika belum login
    exit;
}

// Ambil total buku
$stmt = $conn->query("SELECT COUNT(*) as total FROM books");
$totalBooks = $stmt->fetchColumn();

// Ambil total pengguna
$stmt = $conn->query("SELECT COUNT(*) as total FROM users");
$totalUsers = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- CSS Link -->
</head>
<body>
    <div class="container">
        <h1>Dashboard</h1>
        <div class="dashboard">
            <div class="card total">
                <h2>Total Buku</h2>
                <p class="total"><?php echo $totalBooks; ?></p>
            </div>
            <div class="card total">
                <h2>Total Pengguna</h2>
                <p class="total"><?php echo $totalUsers; ?></p>
            </div>
        </div>
        <div class="action-list">
            <div class="button-group">
                <a href="create.php" class="action-button blue-button">
                    Tambahkan Buku
                </a>
                <a href="searching_book.php" class="action-button blue-button">
                    Cari Buku
                </a>
                <a href="index.php" class="action-button blue-button">
                    Lihat Buku
                </a>
                <a href="logout.php" class="action-button logout-button">
                    Keluar
                </a>
            </div>
        </div>
        <footer>
            <p>&copy; 2024 E-Library</p>
        </footer>
    </div>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
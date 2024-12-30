<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $published_date = $_POST['published_date'];
    $genre = $_POST['genre'];

    $stmt = $conn->prepare("INSERT INTO books (title, author, published_date, genre) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $author, $published_date, $genre]);

    header('Location: dashboard.php'); // Arahkan kembali ke dashboard setelah menambah buku
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="style.css"> <!-- Menggunakan CSS yang sama -->
</head>
<body>
    <div class="container">
        <h1>Tambah Buku</h1>
        <form method="POST">
            <input type="text" name="title" placeholder="Judul Buku" required>
            <input type="text" name="author" placeholder="Penulis Buku" required>
            <input type="date" name="published_date" required>
            <input type="text" name="genre" placeholder="Genre">
            <button type="submit">Tambah Buku</button>
        </form>
        <a href="dashboard.php">Kembali ke Dashboard</a>
    </div>
</body>
</html>
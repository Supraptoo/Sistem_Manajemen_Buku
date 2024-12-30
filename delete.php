<?php
session_start();
include 'db.php'; // Menghubungkan ke database

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Arahkan ke halaman login jika belum login
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: index.php');
    exit;
} else {
    header('Location: index.php');
    exit;
}
?>
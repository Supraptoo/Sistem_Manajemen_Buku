<?php
session_start();
include 'db.php'; // Menghubungkan ke database

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Arahkan ke halaman login jika belum login
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->execute([$id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        header('Location: index.php');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $published_date = $_POST['published_date'];
    $genre = $_POST['genre'];

    $stmt = $conn->prepare("UPDATE books SET title = ?, author = ?, published_date = ?, genre = ? WHERE id = ?");
    $stmt->execute([$title, $author, $published_date, $genre, $id]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="style.css"> <!-- CSS Link -->
</head>
<body>
    <div class="container">
        <h1>Edit Buku</h1>
        <a href="dashboard.php" class="back-button">Dashboard</a>
        <form method="POST" class="edit-form">
            <div class="form-group">
                <label for="title">Judul:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="author">Penulis:</label>
                <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
            </div>
            <div class="form-group">
                <label for="published_date">Tanggal Terbit:</label>
                <input type="date" id="published_date" name="published_date" value="<?php echo $book['published_date']; ?>" required>
            </div>
            <div class="form-group">
                <label for="genre">Genre:</label>
                <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($book['genre']); ?>">
            </div>
            <button type="submit" class="submit-button">Update Buku</button>
        </form>
        <p class="back-link"><a href="index.php">Kembali ke Daftar Buku</a></p>
    </div>
</body>
</html>
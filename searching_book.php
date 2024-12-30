<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Arahkan ke halaman login jika belum login
    exit;
}

// Koneksi ke database
include 'db.php'; 

// Inisialisasi variabel buku
$books = [];

// Cek apakah ada query pencarian
if (isset($_GET['search_query'])) {
    $searchQuery = $_GET['search_query'];
    
    // Ambil data buku berdasarkan pencarian
    try {
        $stmt = $conn->prepare("SELECT title, author FROM books WHERE title LIKE :search OR author LIKE :search");
        $stmt->execute(['search' => '%' . $searchQuery . '%']);
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mencari Buku</title>
    <link rel="stylesheet" href="style.css"> <!-- Menggunakan CSS terpisah -->
</head>
<body>
    <div class="container">
        <h1>Mencari Buku</h1>
        <form method="GET" action="searching_book.php">
            <div class="form-group">
                <label for="search_query">Masukkan Judul atau Pengarang:</label>
                <input type="text" name="search_query" id="search_query" required>
            </div>
            <div class="actions">
                <button type="submit" class="action-button">Cari</button>
            </div>
        </form>
        
        <div class="actions">
            <a href="dashboard.php" class="action-button">Kembali ke Dashboard</a>
        </div>

        <?php if (!empty($books)): ?>
            <h2>Hasil Pencarian:</h2>
            <table>
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Pengarang</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($book['title']); ?></strong></td>
                            <td><strong><?php echo htmlspecialchars($book['author']); ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Tidak ada buku ditemukan.</p>
        <?php endif; ?>
    </div>
</body>
</html>
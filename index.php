<?php
session_start();
include 'db.php'; // Menghubungkan ke database

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Arahkan ke halaman login jika belum login
    exit;
}

// Hapus buku jika permintaan POST diterima
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $bookId = $_POST['book_id'];
    $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $stmt->execute([$bookId]);
}

// Ambil daftar buku dari database
$stmt = $conn->query("SELECT * FROM books");
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <link rel="stylesheet" href="style.css"> <!-- Menggunakan CSS yang terpisah -->
</head>
<body>
    <div class="container">
        <h1>Daftar Buku</h1>
        <div class="book-list">
            <?php if (count($books) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($book['title']); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="edit.php?id=<?php echo $book['id']; ?>" class="action-button">Edit</a>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                                            <button type="submit" name="delete" class="action-button delete-button" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="info-table">
                                        <table>
                                            <tr>
                                                <th>Penulis</th>
                                                <td><?php echo htmlspecialchars($book['author']); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Terbit</th>
                                                <td><?php echo htmlspecialchars($book['published_date']); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Genre</th>
                                                <td><?php echo htmlspecialchars($book['genre']); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-results">Tidak ada buku yang ditemukan.</p>
            <?php endif; ?>
        </div>
        <div class="actions">
            <a href="create.php" class="action-button">Tambah Buku</a>
            <a href="dashboard.php" class="action-button">Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
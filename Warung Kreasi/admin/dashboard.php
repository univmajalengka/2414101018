<?php
session_start();
require '../db.php';
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// urutkan dari ID terkecil ke terbesar (1,2,3,4,...)
$foods = $pdo->query("SELECT * FROM foods ORDER BY id ASC")->fetchAll();
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h2>Dashboard Admin — 🌿 Warung Kreasi</h2>
            <div class="admin-user">
                <p>Halo, <strong><?= htmlspecialchars($_SESSION['admin']) ?></strong></p>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
            <nav class="admin-nav">
                <a href="add_food.php" class="nav-btn">Tambah Makanan</a>
                <a href="orders.php" class="nav-btn">Lihat Pesanan</a>
            </nav>
        </header>

        <main>
            <h3>Daftar Menu</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($foods as $f): ?>
                    <tr>
                        <td><?= $f['id'] ?></td>
                        <td><?= htmlspecialchars($f['name']) ?></td>
                        <td><?= htmlspecialchars($f['category']) ?></td>
                        <td>Rp <?= number_format($f['price'],0,',','.') ?></td>
                        <td>
                            <a href="edit_food.php?id=<?= $f['id'] ?>" class="edit-btn">Edit</a>
                            <a href="delete_food.php?id=<?= $f['id'] ?>" class="delete-btn" onclick="return confirm('Hapus menu ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>

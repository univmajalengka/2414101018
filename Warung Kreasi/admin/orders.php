<?php
session_start();
require '../db.php';

// Cek login admin
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// ==== FITUR HAPUS SEMUA PESANAN ====
if (isset($_GET['delete_all'])) {
    try {
        // Hapus semua data item terlebih dahulu
        $pdo->query("DELETE FROM order_items");
        $pdo->query("DELETE FROM orders");
        $pdo->query("ALTER TABLE orders AUTO_INCREMENT = 1");

        $_SESSION['message'] = "Semua riwayat pesanan berhasil dihapus.";
        header("Location: orders.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['message'] = "Gagal menghapus semua pesanan: " . $e->getMessage();
        header("Location: orders.php");
        exit;
    }
}

// Ambil semua pesanan
$orders = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC")->fetchAll();
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Pesanan</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .delete-btn {
            background: #e74c3c;
            color: #fff;
            padding: 5px 10px;
            border-radius: 6px;
            text-decoration: none;
            transition: 0.2s;
        }
        .delete-btn:hover {
            background: #c0392b;
        }
        .delete-all-btn {
            background: #ff9800;
            color: white;
            padding: 7px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.2s;
        }
        .delete-all-btn:hover {
            background: #e68900;
        }
        .message {
            background: #dff0d8;
            color: #3c763d;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
        }
        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .data-table td a {
            margin-right: 6px;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <header>
            <h2>Daftar Pesanan</h2>
            <a href="dashboard.php" class="back-btn">← Kembali</a>
        </header>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="message"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>

        <div class="top-actions">
            <div></div>
            <?php if (!empty($orders)): ?>
                <a href="orders.php?delete_all=true" class="delete-all-btn" onclick="return confirm('Yakin ingin menghapus SEMUA riwayat pesanan?');">🗑️ Hapus Semua</a>
            <?php endif; ?>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>HP</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($orders): ?>
                    <?php foreach ($orders as $o): ?>
                    <tr>
                        <td><?= $o['id'] ?></td>
                        <td><?= htmlspecialchars($o['customer_name']) ?></td>
                        <td><?= htmlspecialchars($o['phone']) ?></td>
                        <td><?= htmlspecialchars($o['visit_date']) ?></td>
                        <td>Rp <?= number_format($o['total'], 0, ',', '.') ?></td>
                        <td>
                            <a href="../receipt.php?id=<?= $o['id'] ?>" target="_blank">Nota</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center;">Belum ada pesanan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
require 'db.php';
$id = $_GET['id'] ?? 0;

// Ambil data pesanan
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id=?");
$stmt->execute([$id]);
$order = $stmt->fetch();

// Jika tidak ditemukan
if (!$order) {
  die("❌ Pesanan tidak ditemukan.");
}

// Ambil item pesanan
$stmt2 = $pdo->prepare("SELECT * FROM order_items WHERE order_id=?");
$stmt2->execute([$id]);
$items = $stmt2->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Nota Pesanan | Warung Kreasi</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
  <style>
    /* 🌿 WARUNG KREASI - RECEIPT STYLE 🌿 */
    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(180deg, #f6fff6 0%, #eafaea 100%);
      color: #264d26;
      margin: 0;
      padding: 0;
    }

    .navbar {
      background: linear-gradient(90deg, #7dcf88, #56b870);
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 40px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .logo {
      font-size: 1.6em;
      font-weight: 600;
    }

    .container {
      max-width: 800px;
      background: #fff;
      margin: 60px auto;
      padding: 40px 50px;
      border-radius: 18px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #2f5e35;
      margin-bottom: 25px;
    }

    .info {
      background: #f0fff2;
      border: 1px solid #b7e4c7;
      padding: 15px 20px;
      border-radius: 10px;
      margin-bottom: 25px;
      line-height: 1.6;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 25px;
    }

    th, td {
      border-bottom: 1px solid #e0e0e0;
      padding: 12px 10px;
      text-align: center;
    }

    th {
      background: #d1f2d4;
      color: #2f5e35;
      font-weight: 600;
    }

    tr:hover {
      background: #f9fff9;
    }

    .total {
      text-align: right;
      font-size: 1.2em;
      font-weight: 600;
      color: #2f5e35;
      margin-top: 15px;
    }

    .btn-container {
      text-align: center;
      margin-top: 30px;
    }

    .btn {
      background: #57b565;
      color: white;
      padding: 14px 25px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: 500;
      transition: 0.3s;
      display: inline-block;
      margin: 5px;
    }

    .btn:hover {
      background: #4da85c;
      transform: scale(1.05);
    }

    footer {
      background: #7dcf88;
      color: white;
      text-align: center;
      padding: 15px;
      margin-top: 50px;
      font-size: 0.9em;
      letter-spacing: 0.5px;
    }

    @media print {
      .navbar, .btn-container, footer {
        display: none;
      }
      .container {
        box-shadow: none;
        margin: 0;
      }
    }
  </style>
</head>
<body>

<nav class="navbar">
  <div class="logo">🍲 Warung Kreasi</div>
  <div class="nav-links">
    <a href="index.php" style="color:#fff;text-decoration:none;">Beranda</a>
  </div>
</nav>

<div class="container">
  <h2>🧾 Nota Pesanan</h2>

  <div class="info">
    <strong>ID Pesanan:</strong> <?= htmlspecialchars($order['id']) ?><br>
    <strong>Nama Pemesan:</strong> <?= htmlspecialchars($order['customer_name']) ?><br>
    <strong>No. HP:</strong> <?= htmlspecialchars($order['phone']) ?><br>
    <strong>Tanggal Kunjungan:</strong> <?= htmlspecialchars($order['visit_date']) ?><br>
  </div>

  <table>
    <thead>
      <tr>
        <th>Nama Menu</th>
        <th>Harga</th>
        <th>Qty</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($items as $it): ?>
      <tr>
        <td><?= htmlspecialchars($it['name']) ?></td>
        <td>Rp<?= number_format($it['price'],0,',','.') ?></td>
        <td><?= $it['quantity'] ?></td>
        <td>Rp<?= number_format($it['subtotal'],0,',','.') ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="total">
    Total Pembayaran: Rp<?= number_format($order['total'],0,',','.') ?>
  </div>

  <div class="btn-container">
    <button onclick="window.print()" class="btn">🖨️ Cetak Nota</button>
    <a href="index.php" class="btn" style="background:#a2a2a2;">Kembali ke Beranda</a>
  </div>
</div>

<footer>© <?= date('Y') ?> Warung Kreasi | Cita rasa lokal yang istimewa 🌿</footer>
</body>
</html>

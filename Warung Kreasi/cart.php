<?php
session_start();
$cart = $_SESSION['cart'] ?? [];

// Logic tambah/kurang qty
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['id'])) {
    $id = $_POST['id'];
    $action = $_POST['action'];

    if (isset($_SESSION['cart'][$id])) {
        if ($action === 'plus') $_SESSION['cart'][$id]['qty']++;
        elseif ($action === 'minus') {
            $_SESSION['cart'][$id]['qty']--;
            if ($_SESSION['cart'][$id]['qty'] <= 0) unset($_SESSION['cart'][$id]);
        }
    }
    header("Location: cart.php");
    exit;
}

$total = 0;
foreach ($cart as $it) $total += $it['price'] * $it['qty'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Keranjang | Warung Kreasi</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
  <style>
    /* 🌿 WARUNG KREASI - TEMA HIJAU MODERN 🌿 */
    * {margin:0; padding:0; box-sizing:border-box;}
    body {
      font-family: "Poppins", sans-serif;
      background: #f7fff8;
      color: #264d26;
      line-height: 1.6;
    }

    /* 🔸 NAVBAR */
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
    .nav-links a {
      color: #fff;
      text-decoration: none;
      margin-left: 20px;
      font-weight: 500;
      transition: 0.3s;
    }
    .nav-links a:hover {
      color: #013220;
    }

    /* 🔸 CONTAINER */
    .checkout-container {
      background: #fff;
      max-width: 900px;
      margin: 50px auto;
      padding: 40px;
      border-radius: 18px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
      text-align: center;
    }

    h2 {
      color: #2f5e35;
      margin-bottom: 25px;
      font-size: 1.8em;
    }

    p {
      font-size: 1em;
      color: #3a5733;
    }

    /* 🔸 TABLE */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 12px;
      border-bottom: 1px solid #dcead8;
    }
    th {
      background: #e9f7ef;
      color: #1f4a1f;
    }
    tr:nth-child(even) {
      background: #f7fff8;
    }

    /* 🔸 QTY BUTTONS */
    .qty-form {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .qty-btn {
      background: #6bc979;
      border: none;
      color: white;
      width: 30px;
      height: 30px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 1.1em;
      transition: 0.3s;
    }
    .qty-btn:hover {
      background: #57b565;
    }
    .qty {
      min-width: 25px;
      display: inline-block;
      text-align: center;
      font-weight: 600;
      color: #2f5e35;
    }

    /* 🔸 BUTTON */
    .btn {
      background: #57b565;
      color: white;
      border: none;
      padding: 12px 25px;
      border-radius: 10px;
      font-size: 1em;
      cursor: pointer;
      transition: 0.3s;
      text-decoration: none;
      font-weight: 500;
    }
    .btn:hover {
      background: #4da85c;
      transform: scale(1.05);
    }

    /* 🔸 FOOTER */
    footer {
      background: #7dcf88;
      color: white;
      text-align: center;
      padding: 15px;
      margin-top: 50px;
      font-size: 0.9em;
      letter-spacing: 0.5px;
    }

    @media (max-width: 600px) {
      .navbar {
        flex-direction: column;
        padding: 10px;
      }
      .nav-links a {
        display: inline-block;
        margin: 10px;
      }
      .checkout-container {
        padding: 25px;
      }
      table, th, td {
        font-size: 0.9em;
      }
    }
  </style>
</head>
<body>

<nav class="navbar">
  <div class="logo">🥗 Warung Kreasi</div>
  <div class="nav-links">
    <a href="index.php">Beranda</a>
    <a href="checkout.php">Checkout</a>
  </div>
</nav>

<div class="checkout-container">
  <h2>🛒 Keranjang Belanja</h2>

  <?php if (!$cart): ?>
    <p>Keranjang kamu masih kosong. Yuk pilih menu dulu!</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Nama Menu</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cart as $id => $it): ?>
        <tr>
          <td><?= htmlspecialchars($it['name']) ?></td>
          <td>Rp<?= number_format($it['price'],0,',','.') ?></td>
          <td>
            <form method="post" class="qty-form">
              <input type="hidden" name="id" value="<?= $id ?>">
              <button type="submit" name="action" value="minus" class="qty-btn">−</button>
              <span class="qty"><?= $it['qty'] ?></span>
              <button type="submit" name="action" value="plus" class="qty-btn">+</button>
            </form>
          </td>
          <td>Rp<?= number_format($it['price']*$it['qty'],0,',','.') ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
          <th colspan="3">Total</th>
          <th>Rp<?= number_format($total,0,',','.') ?></th>
        </tr>
      </tbody>
    </table>

    <div style="margin-top:30px;">
      <a href="checkout.php" class="btn">Lanjut ke Checkout</a>
    </div>
  <?php endif; ?>
</div>

<footer>© <?= date('Y') ?> Warung Kreasi | Cita rasa lokal yang segar 🌿</footer>

</body>
</html>

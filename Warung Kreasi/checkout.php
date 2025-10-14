<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
if (!$cart) {
  header("Location: cart.php");
  exit;
}

$total = 0;
foreach ($cart as $item) $total += $item['price'] * $item['qty'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Checkout | Warung Kreasi</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
  <style>
    /* 🌿 WARUNG KREASI - CHECKOUT STYLE 🌿 */
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
      max-width: 800px;
      margin: 50px auto;
      padding: 40px;
      border-radius: 18px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    h2 {
      color: #2f5e35;
      margin-bottom: 25px;
      text-align: center;
    }

    /* 🔸 FORM */
    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    label {
      font-weight: 500;
      color: #2f5e35;
      margin-bottom: 5px;
    }

    input[type="text"], input[type="tel"], input[type="date"] {
      width: 100%;
      padding: 12px 15px;
      border: 1.5px solid #c6e3c3;
      border-radius: 10px;
      font-size: 1em;
      transition: 0.3s;
    }

    input:focus {
      border-color: #57b565;
      outline: none;
      box-shadow: 0 0 6px rgba(87,181,101,0.4);
    }

    /* 🔸 BUTTON */
    .btn {
      background: #57b565;
      color: white;
      border: none;
      padding: 14px 20px;
      border-radius: 10px;
      font-size: 1em;
      cursor: pointer;
      transition: 0.3s;
      font-weight: 500;
    }

    .btn:hover {
      background: #4da85c;
      transform: scale(1.05);
    }

    /* 🔸 TOTAL BOX */
    .total-box {
      background: #e9f7ef;
      padding: 15px;
      border-radius: 10px;
      margin: 15px 0;
      font-weight: 600;
      text-align: center;
      color: #1f4a1f;
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
    }
  </style>
</head>
<body>

<nav class="navbar">
  <div class="logo">🥗 Warung Kreasi</div>
  <div class="nav-links">
    <a href="index.php">Beranda</a>
    <a href="cart.php">Keranjang</a>
  </div>
</nav>

<div class="checkout-container">
  <h2>🧾 Checkout Pesanan</h2>

  <div class="total-box">
    Total Pembayaran: <strong>Rp<?= number_format($total,0,',','.') ?></strong>
  </div>

  <form method="post" action="process_checkout.php">
    <div>
      <label for="customer_name">Nama Pemesan:</label>
      <input type="text" name="customer_name" id="customer_name" required>
    </div>
    <div>
      <label for="phone">Nomor Telepon:</label>
      <input type="tel" name="phone" id="phone" required>
    </div>
    <div>
      <label for="visit_date">Tanggal Kunjungan:</label>
      <input type="date" name="visit_date" id="visit_date" required>
    </div>

    <button type="submit" class="btn">Proses Pesanan</button>
  </form>
</div>

<footer>© <?= date('Y') ?> Warung Kreasi | Cita rasa lokal yang segar 🌿</footer>

</body>
</html>

<?php
session_start();
require 'db.php';

// Ambil data makanan
$foods = $pdo->query("SELECT * FROM foods ORDER BY id DESC")->fetchAll();

// Proses tombol
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $name = $_POST['name'];
    $price = (float)$_POST['price'];

    if (isset($_POST['add_to_cart'])) {
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                $item['qty']++;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['cart'][] = ['id'=>$id,'name'=>$name,'price'=>$price,'qty'=>1];
        }
        header("Location: cart.php");
        exit;
    }

    if (isset($_POST['buy_now'])) {
        $_SESSION['buy_now'] = ['id'=>$id,'name'=>$name,'price'=>$price,'qty'=>1];
        header("Location: checkout.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Warung Kreasi | Cita Rasa Menggunggah Selera</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap">
  <style>
/* 🌿 WARUNG KREASI THEME 🌿 */
html, body {
  margin: 0;
  padding: 0;
  font-family: "Poppins", sans-serif;
  background: #fafaf6;
  color: #2f3e2f;
  scroll-behavior: smooth;
}

/* Navbar */
.navbar {
  background: linear-gradient(90deg, #8fd19e, #c5e3b4);
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 18px 60px;
  box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}
.logo {
  font-size: 26px;
  font-weight: 700;
  color: #2a4c2a;
  letter-spacing: 1px;
}
.navbar a {
  color: #2a4c2a;
  margin-left: 18px;
  text-decoration: none;
  font-weight: 500;
  transition: all 0.3s;
}
.navbar a:hover {
  color: #145a32;
  border-bottom: 2px solid #145a32;
}

/* Hero / Jumbotron */
.jumbotron {
  background: url('assets/img/bg-pattern.jpg') no-repeat center/cover;
  background-color: #bce6b7;
  color: #083c1b;
  text-align: center;
  padding: 90px 25px;
  border-bottom-left-radius: 50px;
  border-bottom-right-radius: 50px;
  box-shadow: inset 0 -5px 20px rgba(0,0,0,0.05);
}
.jumbotron h1 {
  font-size: 45px;
  font-weight: 700;
  margin-bottom: 12px;
}
.jumbotron p {
  font-size: 18px;
  color: #355b36;
  opacity: 0.9;
}

/* Menu */
.menu-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 30px;
  padding: 60px;
}
.menu-card {
  background: #ffffff;
  border-radius: 20px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  text-align: center;
  transition: all 0.3s;
}
.menu-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 6px 18px rgba(0,0,0,0.12);
}
.menu-card img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  border-top-left-radius: 20px;
  border-top-right-radius: 20px;
}
.menu-card h3 {
  margin: 15px 0 5px;
  color: #1f5c28;
}
.menu-card p.description {
  color: #4f624f;
  font-size: 14px;
  margin: 0 15px 10px;
  min-height: 45px;
  line-height: 1.5;
}
.menu-card .price {
  color: #228b22;
  font-weight: 700;
  font-size: 17px;
  margin-bottom: 10px;
}
.btn {
  display: inline-block;
  padding: 10px 18px;
  border: none;
  border-radius: 10px;
  margin: 6px;
  cursor: pointer;
  font-weight: 500;
  transition: 0.3s;
}
.btn {
  background: #228b22;
  color: #fff;
}
.btn:hover {
  background: #1a6820;
}
.btn-green {
  background: #8fd19e;
  color: #1f3f1f;
}
.btn-green:hover {
  background: #75c185;
}

/* Tentang Kami */
.about {
  background: #f1fff4;
  padding: 80px 50px;
  text-align: center;
}
.about h2 {
  color: #1f5c28;
  font-size: 2em;
  margin-bottom: 20px;
}
.about p {
  max-width: 800px;
  margin: 0 auto;
  line-height: 1.7;
  color: #2f3e2f;
}

/* Kontak Kami */
.contact {
  background: linear-gradient(180deg, #d3f8d3, #fafffa);
  padding: 80px 50px;
  text-align: center;
}
.contact h2 {
  color: #1f5c28;
  margin-bottom: 15px;
}
.contact p {
  color: #3c563c;
}
.contact-info {
  display: flex;
  justify-content: center;
  gap: 50px;
  flex-wrap: wrap;
  margin-top: 30px;
}
.contact-card {
  background: #ffffff;
  padding: 25px;
  border-radius: 15px;
  width: 250px;
  box-shadow: 0 3px 10px rgba(0,0,0,0.1);
  transition: all 0.3s;
}
.contact-card:hover {
  transform: scale(1.05);
}
.contact-card h4 {
  color: #145a32;
  margin-bottom: 8px;
}

/* Testimoni */
.testimoni {
  text-align: center;
  background: #ffffff;
  padding: 60px 30px;
  border-radius: 25px;
  margin: 70px auto;
  max-width: 850px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.testimoni h2 {
  color: #1f5c28;
  margin-bottom: 20px;
}
.testimoni img {
  width: 180px;
  height: 180px;
  border-radius: 50%;
  object-fit: cover;
  box-shadow: 0 3px 10px rgba(0,0,0,0.2);
}
.testimoni p {
  font-style: italic;
  color: #4a634b;
  margin-top: 15px;
  line-height: 1.6;
}

/* Footer */
footer {
  text-align: center;
  padding: 20px;
  background: #228b22;
  color: #eaffea;
  margin-top: 50px;
  font-weight: 500;
}
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <div class="logo">🌿 Warung Kreasi</div>
  <div>
    <a href="#menu">Menu</a>
    <a href="#about">Tentang Kami</a>
    <a href="#contact">Kontak</a>
    <a href="cart.php">Keranjang (<?= isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0 ?>)</a>
    <a href="admin/login.php" class="admin-btn">Login Admin</a>
  </div>
</nav>

<!-- HERO -->
<section class="jumbotron">
  <h1>Selamat Datang di Warung Kreasi 🌾</h1>
  <p>Rasakan cita rasa menggunggah selera dengan sentuhan modern dan cinta!</p>
</section>

<!-- TENTANG KAMI -->
<section id="about" class="about">
  <h2>Tentang Warung Kreasi</h2>
  <p>
    Warung Kreasi hadir dengan semangat menghadirkan kelezatan makanan yang autentik,
    dikombinasikan dengan konsep modern yang ramah dan hangat. Kami percaya bahwa setiap hidangan
    punya cerita — mulai dari bahan lokal terbaik hingga proses penyajian yang penuh cinta.
  </p>
</section>

<!-- MENU -->
<section id="menu" class="menu-section">
  <h2 class="menu-title">🍽️ Menu Makanan</h2>

  <div class="menu-container">
    <?php foreach ($foods as $food): ?>
    <div class="menu-card">
      <img src="assets/img/<?= htmlspecialchars($food['image'] ?? 'noimg.jpg') ?>" alt="<?= htmlspecialchars($food['name']) ?>">
      <h3><?= htmlspecialchars($food['name']) ?></h3>
      <p class="description"><?= htmlspecialchars($food['description']) ?></p>
      <p class="price">Rp<?= number_format($food['price'],0,',','.') ?></p>
      <form method="POST">
        <input type="hidden" name="id" value="<?= $food['id'] ?>">
        <input type="hidden" name="name" value="<?= htmlspecialchars($food['name']) ?>">
        <input type="hidden" name="price" value="<?= $food['price'] ?>">
        <button type="submit" name="add_to_cart" class="btn">Tambah ke Keranjang</button>
        <button type="submit" name="buy_now" class="btn btn-green">Beli Sekarang</button>
      </form>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- KONTAK -->
<section id="contact" class="contact">
  <h2>Hubungi Kami</h2>
  <p>Untuk pemesanan, kerjasama, atau pertanyaan lainnya, silakan hubungi kontak di bawah ini.</p>
  <div class="contact-info">
    <div class="contact-card">
      <h4>📍 Alamat</h4>
      <p>Jl.Desa Kudangwangi,dsn pasir,Kudangwangi,Kec.Ujung Jaya,Kab.Sumedang</p>
    </div>
    <div class="contact-card">
      <h4>📞 Telepon</h4>
      <p>+62 85640201838</p>
    </div>
    <div class="contact-card">
      <h4>✉️ Email</h4>
      <p>info@warungkreasi.com</p>
    </div>
  </div>
</section>

<!-- TESTIMONI -->
<section class="testimoni">
  <h2>Testimoni Pelanggan Kami</h2>
  <img src="assets/img/Hibban.jpeg" alt="Hibban makan di sini">
  <p>"Rasanya luar biasa! Warung Kreasi benar-benar nyaman tempatnya dan nikmat."</p>
</section>

<!-- FOOTER -->
<footer>© <?= date('Y') ?> Warung Kreasi | Cita Rasa Menggungah Selera</footer>

</body>
</html>

<?php
session_start();
require '../db.php';
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = (float)$_POST['price'];
    $cat = $_POST['category'];
    $imgPath = null;

    if (!empty($_FILES['image']['name'])) {
        $target = '../assets/img/';
        if (!is_dir($target)) mkdir($target,0777,true);
        $fn = time().'_'.basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target.$fn);
        $imgPath = $fn;
    }

    $st = $pdo->prepare("INSERT INTO foods (name, description, price, category, image) VALUES (?, ?, ?, ?, ?)");
    $st->execute([$name, $desc, $price, $cat, $imgPath]);

    header('Location: dashboard.php');
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Tambah Makanan</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <header><h2>Tambah Menu</h2></header>
        <form method="post" enctype="multipart/form-data" class="admin-form">
            <input name="name" placeholder="Nama" required>
            <input name="category" placeholder="Kategori" required>
            <input name="price" placeholder="Harga (contoh: 25000)" required>
            <textarea name="description" placeholder="Deskripsi"></textarea>
            <input type="file" name="image">
            <button type="submit">Simpan</button>
        </form>
        <a href="dashboard.php" class="back-btn">← Kembali</a>
    </div>
</body>
</html>

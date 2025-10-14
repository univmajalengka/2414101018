<?php
session_start();
require '../db.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';

    $st = $pdo->prepare("SELECT * FROM admins WHERE username = ? AND password = MD5(?)");
    $st->execute([$u, $p]);
    $adm = $st->fetch();

    if ($adm) {
        $_SESSION['admin'] = $adm['username'];
        header('Location: dashboard.php');
        exit;
    } else {
        $msg = 'Login gagal. Periksa username/password.';
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="login-body">
    <div class="login-box">
        <h2>Login Admin</h2>
        <?php if ($msg): ?>
            <p class="error"><?= $msg ?></p>
        <?php endif; ?>
        <form method="post">
            <input name="username" placeholder="Username" required>
            <input name="password" type="password" placeholder="Password" required>
            <button type="submit">Masuk</button>
        </form>
    </div>
</body>
</html>

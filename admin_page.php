<?php
// admin_page.php: หน้าแดชบอร์ดสำหรับผู้ดูแลระบบ
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
if (($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: user_page.php');
    exit;
}
?>
<!doctype html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Page - GameHub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container"><a class="navbar-brand" href="#">GameHub Admin</a></div>
</nav>
<div class="container py-4">
  <div class="alert alert-warning">ผู้ดูแลระบบ: <?= htmlspecialchars($_SESSION['username']); ?></div>
  <a href="show_product.php" class="btn btn-success">จัดการสินค้า</a>
  <a href="product.php" class="btn btn-primary">ดูหน้าร้าน</a>
  <a href="logout.php" class="btn btn-outline-danger">ออกจากระบบ</a>
</div>
</body>
</html>

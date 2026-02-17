<?php
// user_page.php: หน้าแดชบอร์ดของผู้ใช้ทั่วไป
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!doctype html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Page - GameHub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container"><a class="navbar-brand" href="#">GameHub</a></div>
</nav>
<div class="container py-4">
  <div class="alert alert-info">ยินดีต้อนรับคุณ <?= htmlspecialchars($_SESSION['username']); ?> (user)</div>
  <a href="product.php" class="btn btn-primary">ไปหน้าร้านเกม</a>
  <a href="logout.php" class="btn btn-outline-danger">ออกจากระบบ</a>
</div>
</body>
</html>

<?php
// product.php: หน้าร้านแสดงสินค้าและปุ่มเพิ่มลงตะกร้า
session_start();
require 'connect.php';
$products = $pdo->query('SELECT * FROM products ORDER BY id DESC')->fetchAll();
?>
<!doctype html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GameHub Store</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="product.php">GameHub Store</a>
    <div>
      <a href="cart.php" class="btn btn-outline-light btn-sm">ตะกร้า</a>
      <?php if (!empty($_SESSION['user_id'])): ?>
        <a href="logout.php" class="btn btn-danger btn-sm">ออกจากระบบ</a>
      <?php else: ?>
        <a href="login.php" class="btn btn-success btn-sm">เข้าสู่ระบบ</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div class="container py-4">
  <div class="row g-3">
    <?php foreach ($products as $p): ?>
    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <?php if (!empty($p['image'])): ?><img src="<?= htmlspecialchars($p['image']); ?>" class="card-img-top" style="height:220px; object-fit:cover;" alt="img"><?php endif; ?>
        <div class="card-body d-flex flex-column">
          <h5><?= htmlspecialchars($p['name']); ?></h5>
          <p class="text-muted">฿<?= number_format((float)$p['price'], 2); ?></p>
          <a href="product_detail.php?id=<?= $p['id']; ?>" class="btn btn-outline-primary btn-sm mb-2">รายละเอียด</a>
          <a href="cart.php?action=add&id=<?= $p['id']; ?>" class="btn btn-primary btn-sm mt-auto">เพิ่มลงตะกร้า</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>
</body>
</html>

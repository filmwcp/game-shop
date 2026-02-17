<?php
// product_detail.php: หน้าแสดงข้อมูลรายละเอียดสินค้า
session_start();
require 'connect.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
$stmt->execute([$id]);
$p = $stmt->fetch();
if (!$p) { die('ไม่พบสินค้า'); }
?>
<!doctype html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detail - <?= htmlspecialchars($p['name']); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
  <a href="product.php" class="btn btn-secondary btn-sm mb-3">กลับหน้าร้าน</a>
  <div class="card">
    <div class="row g-0">
      <div class="col-md-4"><?php if ($p['image']): ?><img src="<?= htmlspecialchars($p['image']); ?>" class="img-fluid rounded-start" alt="img"><?php endif; ?></div>
      <div class="col-md-8">
        <div class="card-body">
          <h3><?= htmlspecialchars($p['name']); ?></h3>
          <p><?= nl2br(htmlspecialchars($p['detail'])); ?></p>
          <h4 class="text-primary">฿<?= number_format((float)$p['price'], 2); ?></h4>
          <a href="cart.php?action=add&id=<?= $p['id']; ?>" class="btn btn-primary">เพิ่มลงตะกร้า</a>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>

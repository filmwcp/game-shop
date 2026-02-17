<?php
// edit_product.php: ฟอร์มแก้ไขข้อมูลสินค้า (admin)
session_start();
require 'connect.php';
if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: login.php');
    exit;
}
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
$stmt->execute([$id]);
$product = $stmt->fetch();
if (!$product) { die('ไม่พบสินค้า'); }
?>
<!doctype html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <div class="card">
    <div class="card-body">
      <h4>แก้ไขสินค้า #<?= $product['id']; ?></h4>
      <form method="post" action="update.php">
        <input type="hidden" name="id" value="<?= $product['id']; ?>">
        <div class="mb-2"><label>ชื่อเกม</label><input class="form-control" name="name" value="<?= htmlspecialchars($product['name']); ?>" required></div>
        <div class="mb-2"><label>ราคา</label><input class="form-control" type="number" step="0.01" name="price" value="<?= $product['price']; ?>" required></div>
        <div class="mb-2"><label>รายละเอียด</label><textarea class="form-control" name="detail"><?= htmlspecialchars($product['detail']); ?></textarea></div>
        <div class="mb-2"><label>URL รูปภาพ</label><input class="form-control" name="image" value="<?= htmlspecialchars($product['image']); ?>"></div>
        <button class="btn btn-primary">อัปเดต</button>
        <a href="show_product.php" class="btn btn-secondary">ยกเลิก</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>

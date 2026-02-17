<?php
// show_product.php: หน้าแสดงรายการสินค้าและฟอร์มเพิ่มสินค้า (admin)
session_start();
require 'connect.php';
if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: login.php');
    exit;
}
$products = $pdo->query('SELECT * FROM products ORDER BY id DESC')->fetchAll();
?>
<!doctype html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Products - GameHub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <h2>จัดการสินค้า</h2>
  <?php if (!empty($_SESSION['success'])): ?><div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div><?php endif; ?>
  <?php if (!empty($_SESSION['error'])): ?><div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div><?php endif; ?>

  <div class="card mb-4">
    <div class="card-body">
      <h5>เพิ่มสินค้าใหม่</h5>
      <form method="post" action="insert_product.php" class="row g-2">
        <div class="col-md-3"><input type="text" name="name" class="form-control" placeholder="ชื่อเกม" required></div>
        <div class="col-md-2"><input type="number" step="0.01" name="price" class="form-control" placeholder="ราคา" required></div>
        <div class="col-md-4"><input type="text" name="detail" class="form-control" placeholder="รายละเอียด"></div>
        <div class="col-md-3"><input type="text" name="image" class="form-control" placeholder="URL รูปภาพ"></div>
        <div class="col-12"><button class="btn btn-success">บันทึกสินค้า</button></div>
      </form>
    </div>
  </div>

  <table class="table table-striped table-bordered bg-white">
    <thead><tr><th>ID</th><th>ชื่อ</th><th>ราคา</th><th>รายละเอียด</th><th>จัดการ</th></tr></thead>
    <tbody>
      <?php foreach ($products as $p): ?>
      <tr>
        <td><?= $p['id']; ?></td>
        <td><?= htmlspecialchars($p['name']); ?></td>
        <td><?= number_format((float)$p['price'], 2); ?></td>
        <td><?= htmlspecialchars($p['detail']); ?></td>
        <td>
          <a class="btn btn-sm btn-primary" href="edit_product.php?id=<?= $p['id']; ?>">แก้ไข</a>
          <a class="btn btn-sm btn-danger" href="delete.php?id=<?= $p['id']; ?>" onclick="return confirm('ยืนยันการลบ?')">ลบ</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <a href="admin_page.php" class="btn btn-outline-secondary">กลับหน้าแอดมิน</a>
</div>
</body>
</html>

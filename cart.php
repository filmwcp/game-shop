<?php
// cart.php: จัดการตะกร้าสินค้าด้วย session
session_start();
require 'connect.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_GET['action'] ?? '';
$id = (int)($_GET['id'] ?? 0);

if ($action === 'add' && $id > 0) {
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    header('Location: cart.php');
    exit;
}
if ($action === 'remove' && $id > 0) {
    unset($_SESSION['cart'][$id]);
    header('Location: cart.php');
    exit;
}

$items = [];
$grandTotal = 0;
if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll();

    foreach ($products as $p) {
        $qty = $_SESSION['cart'][$p['id']] ?? 0;
        $total = $qty * (float)$p['price'];
        $grandTotal += $total;
        $items[] = ['product' => $p, 'qty' => $qty, 'total' => $total];
    }
}
?>
<!doctype html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cart - GameHub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <h2>ตะกร้าสินค้า</h2>
  <table class="table table-bordered bg-white">
    <thead><tr><th>สินค้า</th><th>ราคา</th><th>จำนวน</th><th>รวม</th><th></th></tr></thead>
    <tbody>
      <?php if (empty($items)): ?>
        <tr><td colspan="5" class="text-center">ยังไม่มีสินค้าในตะกร้า</td></tr>
      <?php else: ?>
        <?php foreach ($items as $item): ?>
          <tr>
            <td><?= htmlspecialchars($item['product']['name']); ?></td>
            <td><?= number_format((float)$item['product']['price'], 2); ?></td>
            <td><?= $item['qty']; ?></td>
            <td><?= number_format($item['total'], 2); ?></td>
            <td><a class="btn btn-sm btn-danger" href="cart.php?action=remove&id=<?= $item['product']['id']; ?>">ลบ</a></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>

  <h4>ยอดรวม: ฿<?= number_format($grandTotal, 2); ?></h4>
  <a href="product.php" class="btn btn-secondary">เลือกสินค้าต่อ</a>
  <a href="order.php" class="btn btn-success <?= empty($items) ? 'disabled' : ''; ?>">ยืนยันสั่งซื้อ</a>
</div>
</body>
</html>

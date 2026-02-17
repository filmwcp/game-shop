<?php
// order.php: บันทึกคำสั่งซื้อลงตาราง orders (ต้อง login ก่อน)
session_start();
require 'connect.php';

if (empty($_SESSION['user_id'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบก่อนสั่งซื้อ';
    header('Location: login.php');
    exit;
}

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header('Location: cart.php');
    exit;
}

$ids = array_keys($cart);
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("SELECT id, price FROM products WHERE id IN ($placeholders)");
$stmt->execute($ids);
$products = $stmt->fetchAll();

$pdo->beginTransaction();
try {
    foreach ($products as $p) {
        $qty = (int)$cart[$p['id']];
        $total = $qty * (float)$p['price'];
        $insert = $pdo->prepare('INSERT INTO orders (user_id, product_id, quantity, total) VALUES (?, ?, ?, ?)');
        $insert->execute([$_SESSION['user_id'], $p['id'], $qty, $total]);
    }
    $pdo->commit();
    $_SESSION['cart'] = [];
    echo '<!doctype html><html><head><meta charset="UTF-8"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="p-5"><div class="alert alert-success">สั่งซื้อสำเร็จ</div><a class="btn btn-primary" href="product.php">กลับหน้าร้าน</a></body></html>';
} catch (Throwable $e) {
    $pdo->rollBack();
    echo 'เกิดข้อผิดพลาด: ' . $e->getMessage();
}

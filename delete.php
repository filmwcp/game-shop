<?php
// delete.php: ลบสินค้า (admin)
session_start();
require 'connect.php';
if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: login.php');
    exit;
}
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
$stmt->execute([$id]);
$_SESSION['success'] = 'ลบสินค้าเรียบร้อย';
header('Location: show_product.php');
exit;

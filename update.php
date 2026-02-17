<?php
// update.php: อัปเดตข้อมูลสินค้าในฐานข้อมูล (admin)
session_start();
require 'connect.php';
if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: login.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$price = (float)($_POST['price'] ?? 0);
$detail = trim($_POST['detail'] ?? '');
$image = trim($_POST['image'] ?? '');

$stmt = $pdo->prepare('UPDATE products SET name=?, price=?, detail=?, image=? WHERE id=?');
$stmt->execute([$name, $price, $detail, $image, $id]);
$_SESSION['success'] = 'อัปเดตสินค้าเรียบร้อย';
header('Location: show_product.php');
exit;

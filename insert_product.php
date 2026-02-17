<?php
// insert_product.php: รับข้อมูลและเพิ่มสินค้าใหม่ (admin เท่านั้น)
session_start();
require 'connect.php';

if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: login.php');
    exit;
}

$name = trim($_POST['name'] ?? '');
$price = (float)($_POST['price'] ?? 0);
$detail = trim($_POST['detail'] ?? '');
$image = trim($_POST['image'] ?? '');

if ($name === '' || $price <= 0) {
    $_SESSION['error'] = 'กรุณากรอกชื่อสินค้าและราคาที่ถูกต้อง';
    header('Location: show_product.php');
    exit;
}

$stmt = $pdo->prepare('INSERT INTO products (name, price, detail, image) VALUES (?, ?, ?, ?)');
$stmt->execute([$name, $price, $detail, $image]);
$_SESSION['success'] = 'เพิ่มสินค้าเรียบร้อย';
header('Location: show_product.php');
exit;

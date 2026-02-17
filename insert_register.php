<?php
// insert_register.php: รับข้อมูลสมัครสมาชิกแล้วบันทึกลงฐานข้อมูล
session_start();
require 'connect.php';

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
$role = $_POST['role'] ?? 'user';

if ($username === '' || $password === '' || !in_array($role, ['admin', 'user'], true)) {
    $_SESSION['error'] = 'กรอกข้อมูลไม่ครบหรือรูปแบบไม่ถูกต้อง';
    header('Location: register.php');
    exit;
}

$check = $pdo->prepare('SELECT id FROM users WHERE username = ?');
$check->execute([$username]);
if ($check->fetch()) {
    $_SESSION['error'] = 'Username นี้ถูกใช้งานแล้ว';
    header('Location: register.php');
    exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, ?)');
$stmt->execute([$username, $hashed, $role]);

$_SESSION['success'] = 'สมัครสมาชิกสำเร็จ กรุณาเข้าสู่ระบบ';
header('Location: login.php');
exit;

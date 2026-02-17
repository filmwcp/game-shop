<?php
// check_login.php: ตรวจสอบข้อมูลล็อกอินและสร้าง session
session_start();
require 'connect.php';

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

$stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
$stmt->execute([$username]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password'])) {
    $_SESSION['error'] = 'Username หรือ Password ไม่ถูกต้อง';
    header('Location: login.php');
    exit;
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];

if ($user['role'] === 'admin') {
    header('Location: admin_page.php');
} else {
    header('Location: user_page.php');
}
exit;

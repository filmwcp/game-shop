<?php
// register.php: หน้าแบบฟอร์มสมัครสมาชิก
session_start();
?>
<!doctype html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register - GameHub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="mb-3">สมัครสมาชิก GameHub</h3>
          <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
          <?php endif; ?>
          <form action="insert_register.php" method="post">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Role</label>
              <select name="role" class="form-select">
                <option value="user">user</option>
                <option value="admin">admin</option>
              </select>
            </div>
            <button class="btn btn-primary w-100">สมัครสมาชิก</button>
          </form>
          <hr>
          <a href="login.php" class="btn btn-outline-secondary w-100">ไปหน้าเข้าสู่ระบบ</a>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>

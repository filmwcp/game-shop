<?php
// logout.php: ทำลาย session และออกจากระบบ
session_start();
session_unset();
session_destroy();
header('Location: login.php');
exit;

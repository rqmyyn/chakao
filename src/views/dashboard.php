<?php
session_start();

if (!isset($_SESSION['teluser'])) {
    header("Location: ../../public/index.php"); // ถ้ายังไม่ล็อกอิน ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอิน
}

// นำเสนอข้อมูลของลูกค้าที่เข้าสู่ระบบตรงนี้
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard ลูกค้า</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Dashboard ลูกค้า</h1>
    
    <br>
    <a href="../controller/user-logout.php">ออกจากระบบ</a> <!-- เพิ่มลิงก์ออกจากระบบ -->
</body>
</html>
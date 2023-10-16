<?php
session_start();
include('../config/database.php');

if (isset($_SESSION['teluser'])) {
    // ผู้ใช้เข้าสู่ระบบแล้ว
    header('Location: views/dashboard.php'); // หรือไปยังหน้าที่คุณต้องการ
    exit();

} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teluser = $_POST["tel"];
    $password = $_POST["password"];

    // ตรวจสอบลูกค้า
    $stmt = $conn->prepare("SELECT * FROM member WHERE member_tel = ? AND password = ?");
    $stmt->bind_param("ss", $teluser, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // ล็อกอินเป็นลูกค้า
        $customerData = $result->fetch_assoc();
        $_SESSION['teluser'] = $teluser; // เก็บ session สำหรับลูกค้า
        $_SESSION['customer_id'] = $customerData['customer_id']; // เก็บ customer_id ใน session

        // ดึงข้อมูลจากตาราง "customer" โดยอ้างอิงจาก customer_id
        $customerStmt = $conn->prepare("SELECT * FROM customer WHERE customer_id = ?");
        $customerStmt->bind_param("i", $customerData['customer_id']);
        $customerStmt->execute();
        $customerResult = $customerStmt->get_result();

        if ($customerResult->num_rows > 0) {
            $customerInfo = $customerResult->fetch_assoc();
            // เก็บข้อมูลจากตาราง "customer" ใน session
            $_SESSION['firstname'] = $customerInfo['first_name'];
            // เพิ่มข้อมูลอื่น ๆ ที่ต้องการเก็บใน session

            sleep(0.5);
            header('Location: views/dashboard.php'); // ให้ลูกค้าไปยังหน้า dashboard ของลูกค้า
            exit();
        }
    } else {
        require('assets/pop/user-notfound.html');
    }

    $conn->close();
}
?>

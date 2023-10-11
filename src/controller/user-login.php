<?php
session_start();
include('../../config/database.php');

// ตรวจสอบ Session และควบคุมการใช้งานปุ่ม Back
if (isset($_SESSION['teluser'])) {
    // ผู้ใช้เข้าสู่ระบบแล้ว
    header('Location: ../views/dashboard.php'); // หรือไปยังหน้าที่คุณต้องการ
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
            $_SESSION['teluser'] = $teluser; // เก็บ session สำหรับลูกค้า
            sleep(1);
            header('Location: ../views/dashboard.php'); // ให้ลูกค้าไปยังหน้า dashboard ของลูกค้า
            exit();
    } else {
        include('../../public/assets/popup/user-not_found.html');
    }

    $conn->close();
}

?>
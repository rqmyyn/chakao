<?php
session_start();

if (!isset($_SESSION['teluser'])) {
    header("Location: ../../public/index.php"); // ถ้ายังไม่ล็อกอิน ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอิน
}
// นำเสนอข้อมูลของลูกค้าที่เข้าสู่ระบบตรงนี้
?>

<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-5">83 My Website</h1>
        <div class="row">
            <div class="col-md-6">
                <h2>Home</h2>
                <p>Welcome to 83 My Website. This is a basic example of a website built with Bootstrap.</p>
            </div>
            <div class="col-md-6">
                <h2>Contact</h2>
                <p><button href="../controller/user-logout.php"></button></p>
                <!-- ปุ่มล็อกเอาท์ -->
                <button class="btn btn-primary" id="logoutButton">ล็อกเอาท์</button>

                <script>
                    document.getElementById("logoutButton").addEventListener("click", function() {
                        // ส่งคำร้องขอไปยังเซิร์ฟเวอร์เพื่อดำเนินการล็อกเอาท์
                        fetch('../controller/user-logout.php', {
                                method: 'POST',
                                credentials: 'same-origin' // ส่งคำร้องขอพร้อมกับคุกกี้เพื่อการยืนยัน
                            })
                            .then(function(response) {
                                if (response.status === 200) {
                                    // ล็อกเอาท์สำเร็จ
                                    window.location.href = '../views/login.php'; // หน้าล็อกอิน
                                } else {
                                    // ไม่สามารถล็อกเอาท์ได้
                                    console.error('เกิดข้อผิดพลาดในการล็อกเอาท์');
                                }
                            })
                            .catch(function(error) {
                                console.error('เกิดข้อผิดพลาดในการส่งคำร้องขอ: ' + error);
                            });
                    });
                </script>
            </div>

        </div>
    </div>

</body>

</html>
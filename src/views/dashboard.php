<?php
session_start();
if (!isset($_SESSION['teluser'])) {
    header("Location: ../login.php"); // ถ้ายังไม่ล็อกอิน ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอิน
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สวัสดี!</title>
    <!--Link google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <!-- เพิ่ม Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="icon" href="../../public/img/chakao.ico" type="image/x-icon" />
    <style>
        body {
            font-family: "Kanit", sans-serif;
        }
    </style>
</head>

<body>
    <div class="container">
    <h1 class="text-center mt-5">ยินดีต้อนรับ, <?php echo $_SESSION['firstname']; ?></h1>
        <div class="row">
            <div class="col-md-6">
                <h2>Home</h2>
                <p>Welcome to 83 My Website. This is a basic example of a website built with Bootstrap.</p>
            </div>
            <div class="col-md-6">
                <h2>Contact</h2>
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
                                    window.location.href = '../login.php'; // หน้าล็อกอิน
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
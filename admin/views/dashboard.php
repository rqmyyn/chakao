<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../../public/index.php"); // ถ้ายังไม่ล็อกอิน ให้เปลี่ยนเส้นทางไปที่หน้าล็อกอิน
}

// นำเสนอข้อมูลของลูกค้าที่เข้าสู่ระบบตรงนี้
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แดชบอร์ด</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Kanit', sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .h1 {
            text-align: center;
            padding: 20px;
        }

        .dashboard {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .dashboard-button {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            min-width: 250px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }

        .dashboard-button:hover {
            transform: translateY(-5px);
        }

        .dashboard-button a {
            text-decoration: none;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .dashboard-button i {
            font-size: 36px;
        }

        @media screen and (max-width: 768px) {
            .dashboard-button {
                min-width: 100%;
            }
        }
    </style>
</head>

<body>
    <div>
        <div class="h1">
            <h1>ระบบจัดการร้านค้า</h1>
        </div>

        <div class="dashboard">
            <div class="dashboard-button">
                <a href="purchase-add.php">
                    <i class="fas fa-shopping-cart"></i>
                    <span>บันทึกการขาย</span>
                </a>
            </div>
            <div class="dashboard-button">
                <a href="purchase-list.php">
                    <i class="fas fa-book icon"></i>
                    <span>ประวัติรายการขาย</span>
                </a>
            </div>
            <div class="dashboard-button">
                <a href="prod-add.php">
                    <i class="fas fa-plus-circle"></i>
                    <span>เพิ่มรายการสินค้า</span>
                </a>
            </div>
            <div class="dashboard-button">
                <a href="prod-showall.php">
                    <i class="fas fa-box"></i>
                    <span>เรียกดูรายการสินค้า</span> <!--Finished-->
                </a>
            </div>
            <div class="dashboard-button">
                <a href="member-show.php">
                    <i class="fas fa-users"></i>
                    <span>เรียกดูรายการสมาชิก</span>
                </a>
            </div>

        </div>
        <div style="text-align: center; margin-top: 20px;">
            <a href="../controller/logout.php">ออกจากระบบ</a>
        </div>
    </div>

</body>

</html>
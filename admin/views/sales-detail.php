<?php
// เรียกใช้ไฟล์เช็คสถานะเซสชัน (session-status.php)
include('../controller/session-status.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดการขาย</title>
    <!-- เรียกใช้ Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <!-- Navbar -->
    <header>
        <div id="navbar-container"></div>
    </header>
    <div class="container mt-5">
        <h1>รายละเอียดการขาย</h1>
        <?php
        // ตรวจสอบว่ามีรหัสการขาย (sales_id) ถูกส่งผ่าน URL หรือไม่
        if (isset($_GET['sales_id'])) {
            $sales_id = $_GET['sales_id'];

            // เรียกใช้ไฟล์เชื่อมกับฐานข้อมูล (database.php)
            include('../../config/database.php');

            // สร้าง SQL สำหรับดึงรายละเอียดการขาย
            $sql = "SELECT s.sales_id, s.sales_date, s.total_price, s.total_points, d.product_name, d.price, d.points, d.quantity
                    FROM sales AS s
                    JOIN sales_details AS d ON s.sales_id = d.sales_id
                    WHERE s.sales_id = ?";

            // สร้างคำสั่ง SQL Prepared Statement
            $stmt = $conn->prepare($sql);

            // ผูกค่ารหัสการขาย
            $stmt->bind_param("i", $sales_id);

            // ประมวลผลคิวรี่
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
        ?>
        <!-- แสดงรายละเอียดการขายในตาราง -->
        <table class="table">
            <thead>
                <tr>
                    <th>รหัสการขาย</th>
                    <th>วันที่และเวลา</th>
                    <th>ราคารวม (บาท)</th>
                    <th>แต้มทั้งหมด</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $row = $result->fetch_assoc();
                ?>
                <tr>
                    <td><?php echo $row['sales_id']; ?></td>
                    <td><?php echo $row['sales_date']; ?></td>
                    <td><?php echo $row['total_price']; ?></td>
                    <td><?php echo $row['total_points']; ?></td>
                </tr>
            </tbody>
        </table>

        <!-- แสดงรายละเอียดรายการสินค้า -->
        <table class="table">
            <thead>
                <tr>
                    <th>สินค้า</th>
                    <th>ราคา (บาท)</th>
                    <th>แต้ม</th>
                    <th>จำนวน</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // นำเรนัลทั้งหมดของรายการสินค้า
                $totalAmount = 0;
                $totalPoints = 0;

                // วนลูปเพื่อแสดงรายละเอียดรายการสินค้า
                $result->data_seek(0);
                while ($row = $result->fetch_assoc()) {
                    $totalAmount += $row['price'] * $row['quantity'];
                    $totalPoints += $row['points'] * $row['quantity'];
                ?>
                <tr>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['points']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <!-- แสดงราคารวมและแต้มทั้งหมด -->
        <div class="mt-3">
            <p><strong>ราคารวมทั้งหมด: <?php echo $totalAmount; ?> บาท</strong></p>
            <p><strong>แต้มทั้งหมด: <?php echo $totalPoints; ?></strong></p>
        </div>
        <?php
            } else {
                echo "<p>ไม่พบข้อมูลการขาย</p>";
            }
            
            // ปิดการเชื่อมต่อกับฐานข้อมูล
            $stmt->close();
            $conn->close();
        } else {
            echo "<p>ไม่พบรหัสการขาย</p>";
        }
        ?>
    </div>

    <!-- เรียกใช้ Bootstrap และ jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- เรียกใช้ไฟล์ Navbar -->
    <script>
        fetch('../assets/navbar.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('navbar-container').innerHTML = data;
            });
    </script>
</body>
</html>

<?php include('../controller/session-status.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการสินค้า</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <style>
        body {
            font-family: "Kanit", sans-serif;
        }

        /* เริ่มต้นสีเทา */
        .btn.btn-secondary {
            color: #7b7b7b;
            background-color: transparent;
            border: 0px;
        }

        /* เมื่อ hover ให้ข้อความเหมือนยกขึ้น */
        .btn.btn-secondary:hover {
            color: #000;
            /* สีข้อความเมื่อ hover */
            transform: translateY(-2px);
            /* ข้อความเหมือนยกขึ้น */
        }

        .text-color-red {
            color: red;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <header>
        <div id="navbar-container"></div>
    </header>
    <div class="container mt-3">
        <h1 class="text-center">รายการสินค้าทั้งหมด</h1>
        <a href="prod-add.php" class="btn btn-secondary">
            <i class="fas fa-plus"></i> เพิ่มสินค้า
        </a>
        <hr style="border-color: #7b7b7b; border-width: 1px; height: 1px;">
        <div class="row">
            <div class="col-md-6">
                <form method="POST">
                    <div class="form-group">
                        <label for="search-pd">ค้นหาสินค้า</label>
                        <input type="text" name="search" class="form-control" placeholder="ค้นหาตามชื่อสินค้า">
                    </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="order_by">เรียงตาม</label>
                    <select name="order_by" class="form-control">
                        <option value="p.product_id">รหัสสินค้า</option>
                        <option value="p.product_name">ชื่อสินค้า</option>
                        <option value="p.price">ราคา</option>
                        <option value="p.points">แต้ม</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-block">ค้นหา</button>
                </div>
            </div>
            </form>
        </div>
        <table class="table  table-striped mt-4">
            <thead>
                <tr>
                    <th scope="col">รหัสสินค้า</th>
                    <th scope="col">ชื่อสินค้า</th>
                    <th scope="col">รูปภาพ</th>
                    <th scope="col">ราคา</th>
                    <th scope="col">แต้ม</th>
                    <th scope="col">การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // เพิ่มโค้ด PHP ส่วนนี้เพื่อดึงข้อมูลจากฐานข้อมูล
                include('../../config/database.php');

                if (isset($_POST['search'])) {
                    $search = mysqli_real_escape_string($conn, $_POST['search']);
                    $order = mysqli_real_escape_string($conn, $_POST['order_by']);

                    $sql = "SELECT p.product_id, p.product_name, p.product_image, p.price, p.points
            FROM Products as p
            WHERE p.product_name LIKE '%$search%'";

                    if ($order !== 'product_id') {
                        $sql .= " ORDER BY $order";
                    }
                } else {
                    $sql = "SELECT p.product_id, p.product_name, p.product_image, p.price, p.points
            FROM Products as p";
                }

                $result = mysqli_query($conn, $sql);


                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["product_id"] . "</td>";
                        echo "<td>" . $row["product_name"] . "</td>";
                        echo "<td><img src='" . $row["product_image"] . "' alt='รูปภาพสินค้า' style='max-width: 60px;' class='img-fluid'></td>";
                        echo "<td>" . $row["price"] . "</td>";
                        echo "<td>" . $row["points"] . "</td>";
                        echo "<td><a class='edit-button' href='prod-edit.php?id=" . $row["product_id"] . "'>แก้ไข</a> 
                        <a class='delete-button' href='#' data-product-id=" . $row["product_id"] . ">ลบ</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>ไม่พบข้อมูลสินค้า</td></tr>";
                }

                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        // โหลด Navbar และแสดงใน <div> ที่คุณสร้าง
        fetch('../assets/navbar.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('navbar-container').innerHTML = data;
            });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    const productId = this.getAttribute('data-product-id');

                    Swal.fire({
                        title: 'คุณแน่ใจหรือไม่?',
                        text: 'คุณต้องการลบสินค้านี้หรือไม่?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'ใช่, ลบ!',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // ส่งคำขอลบสินค้าโดยใช้ XMLHttpRequest
                            const xhr = new XMLHttpRequest();
                            xhr.open("DELETE", `../controller/prod-delete.php?id=${productId}`, true);
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4) {
                                    if (xhr.status === 200) {
                                        const response = JSON.parse(xhr.responseText);
                                        if (response.success) {
                                            Swal.fire('ลบสำเร็จ', 'สินค้าถูกลบออกแล้ว', 'success').then(() => {
                                                location.reload(); // รีโหลดหน้าหลังจากลบสินค้า
                                            });
                                        } else {
                                            Swal.fire('เกิดข้อผิดพลาด', 'มีข้อผิดพลาดในการลบสินค้า', 'error');
                                        }
                                    }
                                }
                            };
                            xhr.send();
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการสินค้าทั้งหมด</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: "Kanit", sans-serif;
        }
    </style>
</head>

<body>
    <div class="container">
    <div class="text-center mt-3">
            <a href="dashboard.php" class="btn btn-secondary">กลับสู่หน้าแดชบอร์ด</a>
        </div>
        <h1 class="text-center mt-4">รายการสินค้าทั้งหมด</h1>
        <table class="table table-bordered table-striped mt-4">
            <thead class="thead-dark text-center">
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
                <!-- Loop through product data and display it in the table -->
                <?php
                include('../../config/database.php');

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
                    $product_id = $_POST['product_id'];
                    // SQL ลบสินค้า
                    $sql = "DELETE FROM Products WHERE product_id='$product_id'";
                    $response = array();

                    if (mysqli_query($conn, $sql)) {
                        $response['success'] = true;
                    } else {
                        $response['success'] = false;
                        $response['error'] = mysqli_error($conn);
                    }

                    echo json_encode($response);
                    exit;
                }

                $sql = "SELECT * FROM Products";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td scope='row' class='text-right mr-auto text-color-red'>" . $row["product_id"] . "</td>";
                        echo "<td>" . $row["product_name"] . "</td>";
                        echo "<td><img src='" . $row["product_image"] . "' alt='รูปภาพสินค้า' style='max-width: 100px;' class='img-fluid'></td>";
                        echo "<td>" . $row["price"] . "</td>";
                        echo "<td>" . $row["points"] . "</td>";

                        echo "<td>                            
                            <button class='btn btn-success' onclick='editProduct(" . $row["product_id"] . ")'>แก้ไข</button>
                            <button class='btn btn-danger' onclick='deleteProduct(" . $row["product_id"] . ")'>ลบ</button>

                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>ไม่พบข้อมูลสินค้า</td></tr>";
                }

                mysqli_close($conn);
                ?>
            </tbody>
        </table>
        
    </div>
    <!-- Add Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function deleteProduct(productId) {
            Swal.fire({
                title: 'ยืนยันการลบสินค้า?',
                text: "คุณต้องการลบสินค้านี้หรือไม่?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ลบสินค้า',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, proceed with deletion
                    Swal.fire({
                        title: 'กำลังลบ...',
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Use AJAX to submit the form to delete the product
                    fetch(location.href, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: 'delete_product=true&product_id=' + productId,
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.close();
                            if (data.success) {
                                Swal.fire('สำเร็จ!', 'ลบสินค้าสำเร็จ', 'success').then(() => {
                                    // Reload the page after successful deletion
                                    location.reload();
                                });
                            } else {
                                Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการลบสินค้า: ' + data.error, 'error');
                            }
                        })
                        .catch(error => {
                            Swal.close();
                            Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการลบสินค้า', 'error');
                        });
                }
            });
        }
    </script>
</body>

</html>
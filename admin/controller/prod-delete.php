<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลบสินค้า</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .success-message {
            text-align: center;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php
    include('../../config/database.php');
    if (isset($_GET['id'])) {
        $product_id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
            // SQL ลบสินค้า
            $sql = "DELETE FROM Products WHERE product_id='$product_id'";
            if (mysqli_query($conn, $sql)) {
                echo "<div class='success-message'>ลบสินค้าสำเร็จ</div>";
            } else {
                echo "<div class='error-message'>เกิดข้อผิดพลาดในการลบสินค้า: " . mysqli_error($conn) . "</div>";
            }
            mysqli_close($conn);
        } else {
    ?>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
            <script>
                Swal.fire({
                    title: 'ยืนยันการลบสินค้า?',
                    text: "คุณต้องการลบสินค้านี้หรือไม่?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'ใช่, ลบสินค้า',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User confirmed, show the form to proceed with deletion
                        document.getElementById('delete-form').style.display = 'block';
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        // User clicked the cancel button, navigate back to the original page
                        window.location.href = 'ad_product_showall.php';
                    }
                });
            </script>

            <form id="delete-form" method="POST">
                <input type="submit" name="confirm_delete" value="ยืนยันการลบ">
            </form>
    <?php
        }
    }
    ?>
</body>

</html>

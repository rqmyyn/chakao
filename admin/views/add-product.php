<?php
//ส่งฟอร์มบันทึก
include('../controller/p-add-product.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.18.0/font/bootstrap-icons.css" rel="stylesheet">
    <title>เพิ่มรายการสินค้า</title>
</head>

<body style="font-family: 'Kanit', sans-serif;">
    <div class="container mt-5">
        <h1 class="text-center">เพิ่มรายการสินค้า <i class="bi-cart"></i></h1>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="product_name">ชื่อสินค้า:</label>
                <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>
            <div class="form-group">
                <label for="product_image" class="col-form-label">รูปภาพสินค้า:</label>
                <input type="file" id="product_image" name="product_image" accept="image/*" style="display:none;" required class="form-control streched-link">

                <input type="button" value="อัปโหลดจากไฟล์" onclick="document.getElementById('product_image').click();" class="form-control streched-link">
            </div>
            
            <div class="form-group">
                <label for="display_image" class="col-form-label">รูปภาพที่เลือก:</label>
                <img id="display_image" src="#" alt="รูปภาพสินค้า" style="max-width: 100%; display: none;">
            </div>
            <div class="form-group">
                <label for="price">ราคา:</label>
                <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" required>
                <small class="form-text text-muted">ระบุราคา</small>
            </div>

            <div class="form-group">
                <label for="points">แต้มที่ได้รับ:</label>
                <input type="number" class="form-control" id="points" name="points" min="0" required>
            </div>

            <button type="submit" class="btn btn-primary">เพิ่มสินค้า</button>
        </form>
        <div class="text-center mt-3">
            <a href="dashboard.php" class="btn btn-outline-secondary border-0 ml-1">
                <i class="fa fa-arrow-left" style="margin-right: 5px;"></i>กลับสู่หน้าแดชบอร์ด
            </a>

        </div>
    </div>
    <script>
        // เรียกใช้ฟังก์ชัน displaySelectedImage เมื่อมีการเลือกรูปภาพ
        document.getElementById('product_image').addEventListener('change', displaySelectedImage);

        function displaySelectedImage(event) {
            const fileInput = event.target;
            const displayImage = document.getElementById('display_image');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    displayImage.src = e.target.result;
                    // แสดงรูปภาพที่ถูกเลือก
                    displayImage.style.display = 'block';
                };

                // อ่านรูปภาพที่ถูกเลือก
                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>

</body>

</html>
<?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                include('../../config/database.php');
                if (isset($_FILES["product_image"]) && $_FILES["product_image"]["error"] == 0) {
                    $image_tmp = $_FILES["product_image"]["tmp_name"];
                    $image_name = $_FILES["product_image"]["name"];
                    $image_data = file_get_contents($image_tmp);

                    // บันทึกไฟล์ภาพลงในเซิร์ฟเวอร์
                    $upload_directory = "../../uploads/prod-img/"; // โฟลเดอร์ที่จะบันทึกไฟล์
                    $new_image_name = $upload_directory . uniqid() . "_" . $image_name;
                    move_uploaded_file($image_tmp, $new_image_name);
                }



                $product_name = $_POST['product_name'];
                $price = $_POST['price'];
                $points = $_POST['points'];


                // ตรวจสอบสินค้านี้มีอยู่แล้วหรือไม่
                $sql_check = "SELECT * FROM Products WHERE product_name='$product_name'";
                $result_check = mysqli_query($conn, $sql_check);

                if (mysqli_num_rows($result_check) > 0) {
                    //show popup duplicate product
                    include('../../public/assets/popup/prod-dup.html');
                } else {
                    // SQL เพิ่มรายการสินค้า
                    $sql_add = "INSERT INTO Products (product_name, price, points, product_image) VALUES (?, ?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $sql_add);
                    mysqli_stmt_bind_param($stmt, "sdds", $product_name, $price, $points, $new_image_name);

                    if (mysqli_stmt_execute($stmt)) {
                        include('../../public/assets/popup/prod-add.html');
                    } else {
                        echo "การเพิ่มรายการสินค้าล้มเหลว: " . mysqli_error($conn);
                    }
                }

                mysqli_close($conn);
            }
            ?>
<?php
include('../controller/user-login.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--Link google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <!-- เพิ่ม Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
    <link rel="icon" href="../../public/img/chakao.ico" type="image/x-icon" />
    <title>CHAKAO</title>
    <style>
        body {
            font-family: "Kanit", sans-serif;
            display: grid;
            place-items: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .logo {
            margin-top: 50px;
            width: 150px;
            /* ปรับขนาดโลโก้ตามที่คุณต้องการ */
            height: auto;
            /* ทำให้รูปภาพปรับขนาดอัตโนมัติ */
        }

        .card {
            border-radius: 15px;

        }

        .headtext {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-weight: bold;

        }

        .bt-newmem {
            margin-top: 10px;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="logo-container">
                    <img class="logo" id="img-logo" src="../../public/img/logo.webp" alt="logo" />
                </div>
                <div class="headtext">
                    <h3>ยินดีต้อนรับ! สมาชิก</h3>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">ล็อกอิน</h5>
                        <form method="post">
                            <div class="form-group">
                                <label for="tel">เบอร์โทร :</label>
                                <input type="text" id="tel" name="tel" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label for="password">รหัสผ่าน :</label>
                                <input type="password" id="password" name="password" class="form-control" required />
                                <div class="row justify-content-left" style="margin-top: 15px; margin-left: 1px;">
                                    <a href="admin_login.php">ลืมรหัสผ่าน</a>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                เข้าสู่ระบบ
                            </button>
                            <div>

                            </div>


                        </form>
                        <div class="row justify-content-center" style="margin-top: 15px">
                            <span>ยังไม่ได้สมัครสมาชิก?
                                <a href="register.php">สมัครเลย</a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center" style="margin-top: 15px">
                    <span>
                        <a href="../../admin/views/admin-login.php">Admin Only</a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- เพิ่ม Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>
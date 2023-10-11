<?php
// ตรวจสอบว่ามีการส่งข้อมูล POST มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // เชื่อมต่อกับฐานข้อมูล
    include('../../config/database.php');

    // รับข้อมูลจากแบบฟอร์ม
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $datebirth = $_POST["datebirth"];
    $address = $_POST["address"];
    $sub_district = $_POST["sub-district"];
    $district = $_POST["district"];
    $city = $_POST["city"];
    $zipcode = $_POST["zipcode"];
    $member_tel = $_POST["member_tel"];
    $password = $_POST["password"];
    #$regdate = $_POST["regdate"];

    $check_duplicate_query = "SELECT * FROM member WHERE member_tel = '$member_tel'"; //sql เช็คเบอร์โทรซ้ำ
    $result = $conn->query($check_duplicate_query);
    if ($result->num_rows > 0) {
        include('../../public/assets/popup/user-duplicate.html');
    } else {
        // เพิ่มข้อมูลลงในฐานข้อมูล
        $sql_customer = "INSERT INTO customer (first_name, last_name, datebirth, address, sub_district, district, city, zipcode)
    VALUES ('$first_name', '$last_name', '$datebirth', '$address', '$sub_district', '$district', '$city', '$zipcode')";

        if ($conn->query($sql_customer) === TRUE) {
            $customer_id = $conn->insert_id; // รับค่า customer_id ที่รันอัตโนมัติ

            // บันทึกข้อมูลบัญชีผู้ใช้ลงในตาราง "สมาชิก" โดยอ้างอิง customer_id
            $sql_member = "INSERT INTO member (customer_id, password, member_tel)
    VALUES ('$customer_id', '$password', '$member_tel')";

            if ($conn->query($sql_member) === TRUE) {
                include('../../public/assets/popup/user-regis.html');
                sleep(3);
                header('location: ../views/login.php');
            exit;
            } else {
                echo "เกิดข้อผิดพลาดในการสร้างบัญชีผู้ใช้: " . $conn->error;
            }
        } else {
            echo "เกิดข้อผิดพลาดในการบันทึกข้อมูลลูกค้า: " . $conn->error;
        }

        // ปิดการเชื่อมต่อกับฐานข้อมูล
        $conn->close();
    }
}

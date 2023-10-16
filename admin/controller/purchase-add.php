<?php
// เชื่อมต่อกับฐานข้อมูล (ใช้ include หรือ require เพื่อเชื่อมต่อกับฐานข้อมูล)
include('../../config/database.php');

// รับข้อมูลการขายจากหน้าฟอร์ม
$data = json_decode(file_get_contents("php://input"));

// ตรวจสอบและเตรียมข้อมูลสำหรับการบันทึก
$customerTel = $data->customerTel;
$salesDate = $data->salesDate;
$items = $data->items;

// ตรวจสอบรหัสลูกค้าจากตาราง member โดยใช้ $customerTel
$checkCustomerSql = "SELECT * FROM member WHERE member_tel = ?";
$checkCustomerStmt = $conn->prepare($checkCustomerSql);
$checkCustomerStmt->bind_param("s", $customerTel);
$checkCustomerStmt->execute();
$checkCustomerResult = $checkCustomerStmt->get_result();

if ($checkCustomerResult->num_rows > 0) {
    $customerRow = $checkCustomerResult->fetch_assoc();
    $customerId = $customerRow['customer_id'];

    // บันทึกข้อมูลการขายลงในตาราง sales
    $sqlSales = "INSERT INTO sales (customer_id, sales_date, total_quantity, total_price, total_points) VALUES (?, ?, ?, ?, ?)";
    $stmtSales = $conn->prepare($sqlSales);

    // กำหนดค่าข้อมูลการขาย
    $customer_id = $customerId;
    $sales_date = $salesDate;
    $total_quantity = 0;
    $total_price = 0;
    $total_points = 0;

    // คำนวณรวมยอดสินค้า
    foreach ($items as $item) {
        $total_quantity += $item->quantity;
        $total_price += $item->price * $item->quantity;
        $total_points += $item->points * $item->quantity;
    }

    $stmtSales->bind_param("issdd", $customer_id, $sales_date, $total_quantity, $total_price, $total_points);
    $stmtSales->execute();

    // ดึงรหัสการขาย (sales_id) ที่สร้างขึ้นใหม่
    $salesId = $stmtSales->insert_id;

    // ปิดคำสั่ง SQL
    $stmtSales->close();

    // วนลูปเพื่อบันทึกรายละเอียดการขายลงในตาราง sales_details
    foreach ($items as $item) {
        $product_id = $item->product_id;
        $itemName = $item->itemName;
        $price = $item->price;
        $points = $item->points;
        $quantity = $item->quantity;

        // บันทึกรายละเอียดการขายลงในตาราง sales_details
        $sqlDetails = "INSERT INTO sales_details (sales_id, product_id, product_name, price, points, quantity) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtDetails = $conn->prepare($sqlDetails);
        $stmtDetails->bind_param("iisdii", $salesId, $product_id, $itemName, $price, $points, $quantity);
        $stmtDetails->execute();
        $stmtDetails->close();
    }
    
    $totalPointsEarned = $total_points; // จำนวนแต้มที่ได้จากการขาย
    $currentPoints = $customerRow['points']; // จำนวนแต้มปัจจุบันของลูกค้า
    $newPoints = $currentPoints + $totalPointsEarned; // จำนวนแต้มใหม่

    // อัปเดตจำนวนแต้มในตาราง member
    $updatePointsSql = "UPDATE member SET points = ? WHERE customer_id = ?";
    $stmtUpdatePoints = $conn->prepare($updatePointsSql);
    $stmtUpdatePoints->bind_param("ii", $newPoints, $customerId);
    $stmtUpdatePoints->execute();
    $stmtUpdatePoints->close();
    // ส่งข้อความหลังจากบันทึกเสร็จสิ้น
    echo "บันทึกการขายเรียบร้อยแล้ว";
} else {
    // หากไม่พบรหัสลูกค้าในตาราง customer
    echo "ไม่พบรหัสลูกค้าที่ตรงกับเบอร์โทรที่ระบุ";
}

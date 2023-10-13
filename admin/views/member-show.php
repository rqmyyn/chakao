<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <title>รายชื่อลูกค้า</title>
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background-color: #f2f2f2;
            margin-left: 50px;
            margin-right: 50px;
            padding: 0;

            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
        }

        th {
            background-color: #2d6b1d;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a.delete-button {
            background-color: #d9534f;
            color: #fff;
            padding: 5px 20px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease-in-out;
        }

        a.delete-button:hover {
            background-color: #c9302c;
        }

        a.edit-button {
            background-color: #1c4a99;
            color: #fff;
            padding: 5px 20px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease-in-out;
        }

        a.edit-button:hover {
            background-color: #205013;
        }

        @media (max-width: 600px) {
            table {
                font-size: 14px;
            }

            th,
            td {
                padding: 8px;
            }
        }

        .info {
            padding: 10px;
            text-align: left;
        }
    </style>

</head>

<body>
    <?php
    include('../../config/database.php');
    // SQL ดึงข้อมูลลูกค้าและแต้มจากตาราง purchase
    $sql = "SELECT c.customer_id, c.first_name, c.last_name, m.member_tel, m.points 
        FROM Customer c, member m
        WHERE c.customer_id = m.customer_id
        ORDER BY customer_id";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>";
        echo '<tr><td colspan="7">รายชื่อลูกค้าและแต้มที่ได้</td></tr>
    <tr><th>รหัสลูกค้า</th><th>ชื่อ</th><th>นามสกุล</th><th>เบอร์โทร</th><th>แต้มที่ได้</th><th colspan="2">ดำเนินการ</th></tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr >";
            echo "<td class='info'>" . $row["customer_id"] . "</td>";
            echo "<td class='info'>" . $row["first_name"] . "</td>";
            echo "<td class 'info'>" . $row["last_name"] . "</td>";
            echo "<td class='info'>" . $row["member_tel"] . "</td>";
            echo "<td class='info'>" . $row["points"] . "</td>";
            echo "<td><button class='delete-button' href='ad_customer_process_delete.php?customer_id=" . $row["customer_id"] . "'>ลบ</button></td>";
            echo "<td><button class='edit-button' href='ad_customer_edit_form.php?customer_id=" . $row["customer_id"] . "'>แก้ไข</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "ไม่พบข้อมูลลูกค้า";
    }

    mysqli_close($conn);
    ?>


    <div style="text-align: center; margin-top: 20px;">
        <a href="dashboard.php">กลับสู่หน้าแดชบอร์ด</a>
    </div>
</body>

</html>
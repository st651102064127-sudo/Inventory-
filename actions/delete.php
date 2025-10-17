<?php
// ตรวจสอบว่า method เป็น POST หรือไม่
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Method not allowed. Use POST."]);
    exit();
}

// ตรวจสอบว่ามีข้อมูล ID ที่จำเป็นหรือไม่
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    echo json_encode(["success" => false, "message" => "ID ไม่ถูกต้องหรือไม่พบข้อมูล ID ที่ต้องการลบ"]);
    exit();
}

// รับ ID ที่ต้องการลบ
$id = (int)$_POST['id'];

// เตรียมคำสั่ง SQL สำหรับการลบข้อมูล
$sql = "DELETE FROM tools WHERE id = ?";

// ใช้ Prepared Statements เพื่อป้องกัน SQL Injection
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    // กรณี prepare statement ล้มเหลว
    echo json_encode(["success" => false, "message" => "SQL Prepare failed: " . $conn->error]);
    exit();
}

// Bind parameter (i: integer)
$stmt->bind_param("i", $id);

// ประมวลผลคำสั่ง
if ($stmt->execute()) {
    // ตรวจสอบว่ามีแถวถูกลบจริงหรือไม่
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true, "message" => "ลบข้อมูล ID: $id สำเร็จ"]);
    } else {
        // ไม่พบแถวที่ตรงกับ ID
        echo json_encode(["success" => false, "message" => "ไม่พบข้อมูล ID: $id ในระบบ"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "ไม่สามารถลบข้อมูลได้: " . $stmt->error]);
}

// ปิด statement
$stmt->close();
?>
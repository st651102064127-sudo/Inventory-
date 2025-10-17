<?php
// ตรวจสอบว่า method เป็น POST หรือไม่
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Method not allowed. Use POST."]);
    exit();
}

// ฟังก์ชันช่วยแปลงค่าว่างเปล่า ("") เป็น NULL
function empty_to_null($value) {
    return ($value === '' || $value === null) ? null : $value;
}

// ตรวจสอบว่ามีข้อมูล ID ที่จำเป็นหรือไม่
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    echo json_encode(["success" => false, "message" => "ID ไม่ถูกต้องหรือไม่พบข้อมูล ID ที่ต้องการแก้ไข"]);
    exit();
}

// รับข้อมูลที่ส่งมาจากฟอร์มแก้ไขและแปลงค่าว่างเป็น NULL
$id = (int)$_POST['id'];
$new_code = empty_to_null($_POST['new_code'] ?? null);
$tool_code = empty_to_null($_POST['tool_code'] ?? null);
$tool_name = empty_to_null($_POST['tool_name'] ?? null);
$old_group = empty_to_null($_POST['old_group'] ?? null);
$project_code = empty_to_null($_POST['project_code'] ?? null);
$project_name = empty_to_null($_POST['project_name'] ?? null);

// ตรวจสอบความสมบูรณ์ของข้อมูลที่จำเป็น (ยกเว้น null)
if (empty($new_code) || empty($tool_code) || empty($tool_name)) {
    echo json_encode(["success" => false, "message" => "กรุณากรอกข้อมูล รหัสใหม่, รหัสเครื่องมือ และชื่อเครื่องมือ ให้ครบถ้วน"]);
    exit();
}

// เตรียมคำสั่ง SQL สำหรับการอัปเดตข้อมูล
$sql = "UPDATE tools SET 
            new_code = ?, 
            tool_code = ?, 
            tool_name = ?, 
            old_group = ?, 
            project_code = ?, 
            project_name = ?
        WHERE id = ?";

// ใช้ Prepared Statements เพื่อป้องกัน SQL Injection
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(["success" => false, "message" => "SQL Prepare failed: " . $conn->error]);
    exit();
}

// Bind parameters (s: string, i: integer)
$stmt->bind_param("ssssssi", 
    $new_code, 
    $tool_code, 
    $tool_name, 
    $old_group, 
    $project_code, 
    $project_name, 
    $id
);

// ประมวลผลคำสั่ง
if ($stmt->execute()) {
    // *** ส่วนที่แก้ไข ***
    // affected_rows > 0: ข้อมูลมีการเปลี่ยนแปลง
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true, "message" => "แก้ไขข้อมูล ID: $id สำเร็จ"]);
    } else {
        // affected_rows == 0: ไม่มีการเปลี่ยนแปลงข้อมูล หรือไม่พบ ID
        
        // 1. ตรวจสอบว่ามี ID นี้อยู่จริงหรือไม่
        $check_sql = "SELECT id FROM tools WHERE id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $id);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows === 0) {
            // กรณี: ไม่พบ ID ในฐานข้อมูล
            echo json_encode(["success" => false, "message" => "ไม่พบข้อมูล ID: $id ที่ต้องการแก้ไข"]);
        } else {
            // กรณี: พบ ID แต่ข้อมูลไม่มีการเปลี่ยนแปลง
            echo json_encode(["success" => true, "message" => "ไม่มีการเปลี่ยนแปลงข้อมูล ID: $id", "no_change" => true]);
        }
        $check_stmt->close();
    }
    // *** สิ้นสุดส่วนที่แก้ไข ***
} else {
    echo json_encode(["success" => false, "message" => "ไม่สามารถแก้ไขข้อมูลได้: " . $stmt->error]);
}

// ปิด statement
$stmt->close();
?>
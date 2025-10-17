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

// รับข้อมูลที่ส่งมาจากฟอร์มและแปลงค่าว่างเป็น NULL
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

// เตรียมคำสั่ง SQL สำหรับการเพิ่มข้อมูล (ใช้ placeholder '?' เหมือนเดิม)
$sql = "INSERT INTO tools (new_code, tool_code, tool_name, old_group, project_code, project_name) 
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(["success" => false, "message" => "SQL Prepare failed: " . $conn->error]);
    exit();
}

// *** ข้อควรระวัง: สำหรับค่า NULL ต้องใช้ 's' (string) ใน bind_param อยู่ดี ***
// mysqli จะยอมรับค่า NULL เมื่อ bind เป็น string
$stmt->bind_param("ssssss", 
    $new_code, 
    $tool_code, 
    $tool_name, 
    $old_group, 
    $project_code, 
    $project_name
);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "บันทึกข้อมูลสำเร็จ", "id" => $conn->insert_id]);
} else {
    echo json_encode(["success" => false, "message" => "ไม่สามารถบันทึกข้อมูลได้: " . $stmt->error]);
}

$stmt->close();
?>
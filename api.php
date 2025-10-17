<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'con_db.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'read':
        require 'actions/read.php';
        break;
    case 'create':
        require 'actions/create.php';
        break;
    case 'update':
        require 'actions/update.php';
        break;
    case 'delete':
        require 'actions/delete.php';
        break;
    default:
        echo json_encode(["success" => false, "message" => "Invalid action."]);
        break;
}

// ✅ ปิดการเชื่อมต่อหลังจากทุก action ทำงานเสร็จ
$conn->close();
?>

<?php
require_once __DIR__ . '/../../includes/api_helpers.php';
require_once __DIR__ . '/../../../config/db.php';

api_require_method('POST');

$data           = json_decode(file_get_contents('php://input'), true);
$first_name     = $data['first_name'] ?? null;
$last_name      = $data['last_name'] ?? null;
$contact_number = preg_replace('/\D/', '', $data['contact_number'] ?? '');
$id_number      = $data['id_number'] ?? null;
$middle_name    = $data['middle_name'] ?? null;
$barangay       = $data['barangay'] ?? null;
$city           = $data['city'] ?? null;
$province       = $data['province'] ?? null;
$email          = $data['email'] ?? null;

if (!$first_name || !$last_name || !$contact_number) {
    http_response_code(400);
    echo json_encode(['error' => 'First name, last name, and contact number are required']);
    exit;
}

try {
    $conn->begin_transaction();

    $stmt = $conn->prepare(
        "INSERT INTO visitors (id_number, first_name, middle_name, last_name, barangay, city, province, contact_number, email)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("sssssssss", $id_number, $first_name, $middle_name, $last_name, $barangay, $city, $province, $contact_number, $email);
    $stmt->execute();
    $visitor_id = $conn->insert_id;

    $log_stmt = $conn->prepare("INSERT INTO visit_logs (visitor_id) VALUES (?)");
    $log_stmt->bind_param("i", $visitor_id);
    $log_stmt->execute();

    $conn->commit();

    echo json_encode(['visitor_id' => $visitor_id, 'action' => 'signed_in']);
} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode(['error' => 'Registration failed']);
}

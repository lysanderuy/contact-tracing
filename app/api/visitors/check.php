<?php
require_once __DIR__ . '/../../includes/api_helpers.php';
require_once __DIR__ . '/../../../config/db.php';

api_require_method('POST');

$data           = json_decode(file_get_contents('php://input'), true);
$id_number      = $data['id_number'] ?? null;
$contact_number = $data['contact_number'] ?? null;

if (!$id_number && !$contact_number) {
    http_response_code(400);
    echo json_encode(['error' => 'ID number or contact number required']);
    exit;
}

try {
    if ($id_number) {
        $stmt = $conn->prepare("SELECT id, first_name, last_name, contact_number FROM visitors WHERE id_number = ?");
        $stmt->bind_param("s", $id_number);
    } else {
        $normalized = preg_replace('/\D/', '', $contact_number);
        $stmt = $conn->prepare("SELECT id, first_name, last_name, contact_number FROM visitors WHERE contact_number = ?");
        $stmt->bind_param("s", $normalized);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['found' => false]);
        exit;
    }

    $visitor    = $result->fetch_assoc();
    $visitor_id = $visitor['id'];

    $log_stmt = $conn->prepare("SELECT sign_out FROM visit_logs WHERE visitor_id = ? ORDER BY sign_in DESC LIMIT 1");
    $log_stmt->bind_param("i", $visitor_id);
    $log_stmt->execute();
    $log_result = $log_stmt->get_result();

    $status = 'signed_out';
    if ($log_result->num_rows > 0 && $log_result->fetch_assoc()['sign_out'] === null) {
        $status = 'signed_in';
    }

    echo json_encode([
        'found'          => true,
        'visitor_id'     => $visitor_id,
        'first_name'     => $visitor['first_name'],
        'last_name'      => $visitor['last_name'],
        'contact_number' => $visitor['contact_number'],
        'status'         => $status,
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}

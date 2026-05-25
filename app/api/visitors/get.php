<?php
require_once __DIR__ . '/../../includes/api_helpers.php';
require_once __DIR__ . '/../../../config/db.php';

api_require_method('GET');

$visitor_id = (int)($_GET['id'] ?? 0);
if (!$visitor_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid visitor ID']);
    exit;
}

try {
    // Return only name + masked contact for unauthenticated verify page
    $stmt = $conn->prepare(
        "SELECT id, id_number, first_name, last_name,
                CONCAT(LEFT(contact_number, 4), '***') AS contact_number
         FROM visitors WHERE id = ?"
    );
    $stmt->bind_param("i", $visitor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Not found']);
        exit;
    }

    $visitor = $result->fetch_assoc();

    $log_stmt = $conn->prepare("SELECT sign_out FROM visit_logs WHERE visitor_id = ? ORDER BY sign_in DESC LIMIT 1");
    $log_stmt->bind_param("i", $visitor_id);
    $log_stmt->execute();
    $log_result = $log_stmt->get_result();

    $visitor['status'] = ($log_result->num_rows > 0 && $log_result->fetch_assoc()['sign_out'] === null)
        ? 'signed_in'
        : 'signed_out';

    echo json_encode($visitor);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}

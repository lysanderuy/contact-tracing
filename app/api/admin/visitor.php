<?php
require_once __DIR__ . '/../../includes/api_helpers.php';
require_once __DIR__ . '/../../../config/db.php';

api_require_method('GET');
require_admin();

$visitor_id = (int)($_GET['id'] ?? 0);
if (!$visitor_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid visitor ID']);
    exit;
}

try {
    $stmt = $conn->prepare(
        "SELECT id, id_number, first_name, middle_name, last_name,
                contact_number, email, barangay, city, province
         FROM visitors WHERE id = ?"
    );
    $stmt->bind_param("i", $visitor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Visitor not found']);
        exit;
    }

    $visitor = $result->fetch_assoc();

    $history_stmt = $conn->prepare(
        "SELECT id, sign_in, sign_out, location
         FROM visit_logs WHERE visitor_id = ?
         ORDER BY sign_in DESC"
    );
    $history_stmt->bind_param("i", $visitor_id);
    $history_stmt->execute();
    $history_result = $history_stmt->get_result();

    $logs = [];
    $currently_signed_in = false;
    $first_visit = null;
    while ($log = $history_result->fetch_assoc()) {
        if ($log['sign_out'] === null) {
            $currently_signed_in = true;
        }
        $logs[] = $log;
        // Track earliest sign_in as first_visit
        if ($first_visit === null || strtotime($log['sign_in']) < strtotime($first_visit)) {
            $first_visit = $log['sign_in'];
        }
    }

    echo json_encode([
        'visitor'             => $visitor,
        'logs'                => $logs,
        'first_visit'         => $first_visit,
        'currently_signed_in' => $currently_signed_in,
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}

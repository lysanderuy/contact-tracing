<?php
require_once __DIR__ . '/../../includes/api_helpers.php';
require_once __DIR__ . '/../../../config/db.php';

api_require_method('POST');

$data       = json_decode(file_get_contents('php://input'), true);
$visitor_id = $data['visitor_id'] ?? null;
$action     = $data['action'] ?? null;

if (!$visitor_id || !in_array($action, ['sign_in', 'sign_out'], true)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
    exit;
}


try {
    if ($action === 'sign_in') {
        $stmt = $conn->prepare("INSERT INTO visit_logs (visitor_id) VALUES (?)");
        $stmt->bind_param("i", $visitor_id);
        $stmt->execute();

        $ts_stmt = $conn->prepare("SELECT sign_in FROM visit_logs WHERE visitor_id = ? ORDER BY sign_in DESC LIMIT 1");
        $ts_stmt->bind_param("i", $visitor_id);
        $ts_stmt->execute();
        $timestamp = $ts_stmt->get_result()->fetch_assoc()['sign_in'];
    } else {
        $stmt = $conn->prepare(
            "UPDATE visit_logs SET sign_out = CURRENT_TIMESTAMP
             WHERE visitor_id = ? AND sign_out IS NULL
             ORDER BY sign_in DESC LIMIT 1"
        );
        $stmt->bind_param("i", $visitor_id);
        $stmt->execute();

        $ts_stmt = $conn->prepare("SELECT sign_out FROM visit_logs WHERE visitor_id = ? ORDER BY sign_in DESC LIMIT 1");
        $ts_stmt->bind_param("i", $visitor_id);
        $ts_stmt->execute();
        $timestamp = $ts_stmt->get_result()->fetch_assoc()['sign_out'];
    }

    echo json_encode(['success' => true, 'action' => $action, 'timestamp' => $timestamp]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Action failed']);
}

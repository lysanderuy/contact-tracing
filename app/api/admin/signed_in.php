<?php
require_once __DIR__ . '/../../includes/api_helpers.php';
require_once __DIR__ . '/../../../config/db.php';

api_require_method('GET');
require_admin();

try {
    $stmt = $conn->prepare(
        "SELECT v.id AS visitor_id, v.first_name, v.last_name, v.id_number, v.contact_number, vl.sign_in
         FROM visitors v
         JOIN visit_logs vl ON v.id = vl.visitor_id
         WHERE vl.sign_out IS NULL
         ORDER BY vl.sign_in DESC"
    );
    $stmt->execute();
    $result = $stmt->get_result();

    $visitors = [];
    while ($row = $result->fetch_assoc()) {
        $visitors[] = $row;
    }

    echo json_encode($visitors);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}

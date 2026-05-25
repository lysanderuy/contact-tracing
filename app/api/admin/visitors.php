<?php
require_once __DIR__ . '/../../includes/api_helpers.php';
require_once __DIR__ . '/../../../config/db.php';

api_require_method('GET');
require_admin();

$search      = $_GET['search'] ?? '';
$filter_type = $_GET['filter'] ?? 'all';
$date_from   = $_GET['date_from'] ?? '';
$date_to     = $_GET['date_to'] ?? '';

$where_clauses = ['1=1'];
$params = [];
$types  = '';

if ($search) {
    $where_clauses[] = "(v.first_name LIKE ? OR v.last_name LIKE ? OR v.id_number LIKE ? OR v.contact_number LIKE ? OR v.barangay LIKE ? OR v.city LIKE ?)";
    $p = "%$search%";
    $params = array_merge($params, [$p, $p, $p, $p, $p, $p]);
    $types .= 'ssssss';
}

if ($filter_type === 'signed_in') {
    $where_clauses[] = "vl.sign_out IS NULL";
}

if ($filter_type === 'today') {
    $where_clauses[] = "DATE(vl.sign_in) = ?";
    $params[] = date('Y-m-d');
    $types .= 's';
} elseif ($filter_type === 'date_range' && $date_from && $date_to) {
    $where_clauses[] = "DATE(vl.sign_in) BETWEEN ? AND ?";
    $params = array_merge($params, [$date_from, $date_to]);
    $types .= 'ss';
}

$where_sql = implode(' AND ', $where_clauses);

try {
    $query = "SELECT v.id AS visitor_id, v.first_name, v.last_name, v.id_number,
                     v.contact_number, v.barangay, v.city, vl.sign_in, vl.sign_out
              FROM visitors v
              JOIN visit_logs vl ON v.id = vl.visitor_id
              WHERE $where_sql
              ORDER BY vl.sign_in DESC
              LIMIT 100";

    $stmt = $conn->prepare($query);
    if ($types) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $logs = [];
    while ($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }

    echo json_encode($logs);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}

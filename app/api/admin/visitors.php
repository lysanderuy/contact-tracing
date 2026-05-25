<?php
require_once __DIR__ . '/../../includes/api_helpers.php';
require_once __DIR__ . '/../../../config/db.php';

api_require_method('GET');
require_admin();

const PER_PAGE = 10;

$search      = $_GET['search'] ?? '';
$filter_type = $_GET['filter'] ?? 'all';
$date_from   = $_GET['date_from'] ?? '';
$date_to     = $_GET['date_to'] ?? '';
$page        = max(1, (int) ($_GET['page'] ?? 1));
$per_page    = PER_PAGE;
$offset      = ($page - 1) * $per_page;

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
    $count_query = "SELECT COUNT(*) AS total
                    FROM visitors v
                    JOIN visit_logs vl ON v.id = vl.visitor_id
                    WHERE $where_sql";

    $count_stmt = $conn->prepare($count_query);
    if ($types) {
        $count_stmt->bind_param($types, ...$params);
    }
    $count_stmt->execute();
    $total = $count_stmt->get_result()->fetch_assoc()['total'];
    $total_pages = (int) ceil($total / $per_page);

    $query = "SELECT v.id AS visitor_id, v.first_name, v.last_name, v.id_number,
                     v.contact_number, v.barangay, v.city, vl.sign_in, vl.sign_out
              FROM visitors v
              JOIN visit_logs vl ON v.id = vl.visitor_id
              WHERE $where_sql
              ORDER BY vl.sign_in DESC
              LIMIT $per_page OFFSET $offset";

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

    echo json_encode([
        'data' => $logs,
        'page' => $page,
        'per_page' => $per_page,
        'total' => $total,
        'total_pages' => $total_pages,
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}

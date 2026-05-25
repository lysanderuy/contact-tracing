<?php
require_once __DIR__ . '/../../includes/api_helpers.php';
require_once __DIR__ . '/../../../config/db.php';

api_require_method('POST');

$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';
$csrf_token = $data['csrf_token'] ?? '';

if (!hash_equals($_SESSION['csrf_token'] ?? '', $csrf_token)) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

try {
    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $admin['id'];
            echo json_encode(['success' => true]);
            exit;
        }
    }

    http_response_code(401);
    echo json_encode(['error' => 'Invalid username or password']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Login failed']);
}

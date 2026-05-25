<?php
session_start();

// API routing
$api = $_GET['api'] ?? null;
if ($api !== null) {
    $allowed_api = [
        'visitors/check',
        'visitors/get',
        'visitors/register',
        'visitors/sign',
        'auth/login',
        'admin/visitors',
        'admin/signed_in',
        'admin/visitor',
    ];

    if (!in_array($api, $allowed_api, true)) {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Not found']);
        exit;
    }

    include __DIR__ . '/../app/api/' . $api . '.php';
    exit;
}

// Page routing
$page = $_GET['page'] ?? 'home';

$allowed_pages = [
    'home',
    'guest_entry',
    'register',
    'verify',
    'confirmation',
    'admin_login',
    'admin_dashboard',
    'visitor_detail',
    'logout',
];

if (!in_array($page, $allowed_pages, true)) {
    http_response_code(404);
    echo "404 Not Found";
    exit;
}

if ($page === 'logout') {
    include __DIR__ . '/../app/api/auth/logout.php';
    exit;
}

include __DIR__ . '/../app/pages/' . $page . '.php';

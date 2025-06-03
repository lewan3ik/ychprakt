<?php
require_once __DIR__ . '/../classes/leassonContext.php';

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
error_reporting(0); // Отключаем вывод ошибок в ответ
if($method === 'GET' &&($_GET['action']??'')==='get'){
    try {
$allles = leassonContext::select();



$leassonsArray = array_map(function($elem) {
    return [
        'ID' => $elem->ID,
        'Date' => $elem->date
    ];
}, $allles);
echo json_encode($leassonsArray, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch students', 'details' => $e->getMessage()]);
}
}
?>
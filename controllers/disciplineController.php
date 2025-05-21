<?php
ini_set('display_errors', 0);
include_once __DIR__ . "/../classes/disciplineContext.php";

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if($method === 'GET' &&($_GET['action']??'')==='get'){
    try {
        error_log("Attempting to fetch groups...");
        $groups = disciplineContext::select();

        $groupArray = array_map(function($elem) {
            return [
                'ID' => $elem->ID,
                'Name' => $elem->Name
            ];
        }, $groups);

        echo json_encode($groupArray, JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch students', 'details' => $e->getMessage()]);
    }
}
?>
<?php
error_reporting(0);
ini_set('display_errors', 0);
include_once __DIR__ . "/../classes/groupContext.php";

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if($method === 'GET' &&($_GET['action']??'')==='get'){
    try {
        error_log("Attempting to fetch groups...");
        $groups = groupContext::select();

        $groupArray = array_map(function($elem) {
            return [
                'ID' => $elem->ID,
                'Name' => $elem->Name
            ];
        }, $groups);

        echo json_encode($groupArray, JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch students', 'details' => $e->getMessage()]);
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'addGroup') {
    try {
        $input = json_decode(file_get_contents("php://input"), true);
        $newGroup = new groupContext(['ID'=>null,'Name'=> $input['name']]);
        $newGroup->add();
        $resp = [
            "success" => true,
            "message" => "Группа успешно добавлена",
            "data" => $newGroup->Name
        ];
        echo json_encode($resp);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'Ошибка при добавлении группы',
            'details' => $e->getMessage()
        ]);
    }
    exit();
}
?>

<?php
ini_set('display_errors', 0);
include_once __DIR__ . "/../classes/teacherContext.php";

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if($method === 'GET' &&($_GET['action']??'')==='get'){
    try {
        error_log("Attempting to fetch groups...");
        $groups = teacherContext::select();

        $groupArray = array_map(function($elem) {
            return [
                'ID' => $elem->ID,
                'FullName' => $elem->FullName,
                'Login'=>$elem->Login,
                'Password'=>$elem->Password
            ];
        }, $groups);

        echo json_encode($groupArray, JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch students', 'details' => $e->getMessage()]);
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    $input = json_decode(file_get_contents("php://input"), true);
    if($_GET['action'] === 'add'){
        try {
        $newGroup = new teacherContext(['ID'=>null,'FullName'=> $input['name'],
    'Login'=>$input['login'],'Password' =>password_hash($input['password'], PASSWORD_DEFAULT)]);
        $newGroup->add();
        $resp = [
            "success" => true,
            "message" => "Группа успешно добавлена",
            "data" => $newGroup->Password
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
    if($_GET['action'] === 'update'){
        try {
        $newGroup = new teacherContext(['ID'=>$input['id'],'FullName'=> $input['name'],
    'Login'=>$input['login'],'Password' =>password_hash($input['password'], PASSWORD_DEFAULT)]);
        $newGroup->update();
        $resp = [
            "success" => true,
            "message" => "Группа успешно добавлена",
            "data" => $newGroup->ID
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
    if($_GET['action'] ==='del'){
        try {
            $id = $input['id'];
            $res = teacherContext::delete($id);
        $resp = [
            "success" => true,
            "message" => "Группа успешно добавлена",
            "data" => $id,
            "res" => $res
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
}
?>

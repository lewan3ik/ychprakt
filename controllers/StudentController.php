<?php
ini_set('display_errors', 0);
include_once __DIR__ . "/../classes/studentContext.php";
include_once __DIR__ . "/../classes/groupContext.php";

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET' && ($_GET['action'] ?? '') === 'get') {
    try {

                $groups = groupContext::select();

        $groupArray = array_map(function($elem) {
            return [
                'ID' => $elem->ID,
                'Name' => $elem->Name
            ];
        }, $groups);
        $students = studentContext::select();
        $studentsArray = array_map(function($student) use($groupArray) {
            $groupName = $groupArray[$student->GroupID-1]['Name'];
            return [
                'ID' => $student->ID,
                'FullName' => $student->FullName,
                'GroupID' => $groupName,
                'ExpulsionDate' => $student->ExpulsionDate?? '-'
            ];
        }, $students);

        echo json_encode($studentsArray, JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch students', 'details' => $e->getMessage()]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    $input = json_decode(file_get_contents("php://input"), true);
    if($_GET['action'] === 'addStudent'){
        try {

        $newStudent = new studentContext(['ID' => null,'FullName'=> $input['name'],
        'login'=>'','password'=>'','ExpulsionDate'=>$input['date']??null,'GroupID'=>$input['group']]);
        $newStudent -> add();
        $resp = [
            "success" => true,
            "message" => "Группа успешно добавлена",
            "data" => $newStudent -> FullName
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
    if($_GET['action'] ==='updateStudent'){
        try {
        
        $newStudent = new studentContext(['ID' => $input['id'],'FullName'=> $input['name'],
        'login'=>'login','password'=>'12345','ExpulsionDate'=>$input['date']?? null,'GroupID'=>$input['group']]);
        $res = $newStudent ->update();
        $resp = [
            "success" => true,
            "message" => "Группа успешно добавлена",
            "data" => $newStudent -> GroupID,
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
    if($_GET['action'] ==='delStudent'){
        try {
            $id = $input['id'];
            studentContext::delete($id);
        $resp = [
            "success" => true,
            "message" => "Группа успешно добавлена",
            "data" => $id
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

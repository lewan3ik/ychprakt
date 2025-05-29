<?php
ini_set('display_errors', 0);
require_once __DIR__ . '/../classes/consultationContext.php';
require_once __DIR__ . '/../classes/groupContext.php';
require_once __DIR__ . "/../classes/teacherContext.php";
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if($method === 'GET' &&($_GET['action']??'')==='get'){
    try {
    $cons = consultationContext::select();
    $groups = groupContext::select();
    $teachers = teacherContext::select();

    $teachersArray = array_map(function($elem) {
        return [
            'ID' => $elem->ID,
            'FullName' => $elem->FullName,
        ];
    }, $teachers);

    $groupArray = array_map(function($elem) {
        return [
            'ID' => $elem->ID,
            'Name' => $elem->Name
        ];
    }, $groups);

    $consArray = array_map(function($elem) use($groupArray,$teachersArray) {
        $groupName = $groupArray[$elem->GroupID]['Name'];
        $teacherName = $teachersArray[$elem->TeacherID]['FullName'];
        return [
            'ID' => $elem->ID,
            'Date' => $elem->Date,
            'GroupID'=>$elem->GroupID,
            'TeacherID'=>$elem->TeacherID
        ];
    }, $cons);
    echo json_encode($consArray, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch students', 'details' => $e->getMessage()]);
}
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    $input = json_decode(file_get_contents("php://input"), true);
    if($_GET['action'] === 'add'){
        try {
        $newGroup = new consultationContext(['ID'=>null,'Date'=> $input['date'],
    'TeacherID'=>$input['teacherId'],'GroupID' =>$input['studentId']]);
        $newGroup->add();
        $resp = [
            "success" => true,
            "message" => "Группа успешно добавлена",
            "data" => $newGroup->TeacherID
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
        $newGroup = new consultationContext(['ID'=>$input['id'],'Date'=> $input['date'],
    'TeacherID'=>$input['teacherId'],'GroupID' =>$input['studentId']]);
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
            $res = consultationContext::delete($id);
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
<?php
require_once __DIR__ . '/../classes/disciplineContext.php';
require_once __DIR__ . '/../classes/groupContext.php';
require_once __DIR__ . '/../classes/teacherContext.php';
require_once __DIR__ . '/../classes/loadContext.php';

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if($method === 'GET' &&($_GET['action']??'')==='get'){
    try {
    $loads = loadContext::select();

    $studentsArray = array_map(function($student) {
        return [
            'ID' => $student->ID,
            'TeacherID' => $student->TeacherID,
            'DisciplineID' => $student->DisciplineID,
            'GroupID' => $student -> GroupID,
            'Hours' => $student->Hours
        ];
    }, $loads);

    echo json_encode($studentsArray, JSON_UNESCAPED_UNICODE);
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
        $newGroup = new loadContext(['ID'=>null,'DisciplineID'=> $input['teacherId'],
    'TeacherID'=>$input['disciplineId'],'GroupID' =>$input['groupId'],'Hours'=>$input['hours']]);
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
        $newGroup = new loadContext(['ID'=>$input['id'],'DisciplineID'=> $input['teacherId'],
    'TeacherID'=>$input['disciplineId'],'GroupID' =>$input['groupId'],'Hours'=>$input['hours']]);
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
            $res = loadContext::delete($id);
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
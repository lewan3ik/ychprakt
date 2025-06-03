<?php
require_once __DIR__ . '/../classes/studentContext.php';
require_once __DIR__ . '/../classes/leassonContext.php';
require_once __DIR__ . '/../classes/skipContext.php';

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
error_reporting(0); // Отключаем вывод ошибок в ответ
if($method === 'GET' &&($_GET['action']??'')==='get'){
    try {
        $allSkips = skipContext::select();


$studentsArray = array_map(function($student) {
    return [
        'ID' => $student->ID,
        'StudentID' => $student->StudentID,
        'LessonID' => $student->LessonID,
        'Minutes' => $student->Minutes,
        'ExplanationFile' => $student->ExplanationFile ?? '-'
    ];
}, $allSkips);
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
        $newGroup = new skipContext(['ID'=>null,'StudentID'=> $input['studentId'],
    'LessonID'=>$input['lessonId'],'Minutes' =>$input['minutes'],'ExplanationFile'=>$input['explanation']]);
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
        $newGroup = new skipContext(['ID'=>$input['id'],'StudentID'=> $input['studentId'],
    'LessonID'=>$input['lessonId'],'Minutes' =>$input['minutes'],'ExplanationFile'=>$input['explanation']]);
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
            $res = skipContext::delete($id);
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
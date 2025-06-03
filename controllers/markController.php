<?php
ini_set('display_errors', 0);
require_once __DIR__ . '/../classes/studentContext.php';
require_once __DIR__ . '/../classes/leassonContext.php';
require_once __DIR__ . '/../classes/markContext.php';

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    $input = json_decode(file_get_contents("php://input"), true);
    if($_GET['action'] === 'getMarks'){
        try {
            $studId = $input['groupId'];

       $students = studentContext::select();
$allMarks = markContext::select();

// Создаем ассоциативный массив студентов для быстрого поиска по ID
$studentsMap = [];
foreach ($students as $student) {
    $studentsMap[$student->ID] = $student;
}

// Фильтруем оценки только для студентов из группы 1
$filteredMarks = array_filter($allMarks, function($mark) use ($studentsMap,$studId) {
    // Проверяем, что студент существует и принадлежит группе 1
    return isset($studentsMap[$mark->StudentID]) && $studentsMap[$mark->StudentID]->GroupID == $studId;
});

// Формируем итоговый массив с нужной структурой
$result = array_map(function($mark) use ($studentsMap) {
    $student = $studentsMap[$mark->StudentID];
    
    return [
        'ID' => $mark->ID,
        'StudentID' => $mark->StudentID,
        'LessonID' => $mark->LessonID,
        'Grade' => $mark->Grade,
        'Date' => $mark->Date,
        'StudentName' => $student->FullName
    ];
}, $filteredMarks);

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }catch (Exception $e) {
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    $input = json_decode(file_get_contents("php://input"), true);
    if($_GET['action'] === 'addStudent'){
        try {

        $newStudent = new markContext(['ID' => null,'FullName'=> $input['name'],
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
    if($_GET['action'] ==='update'){
        try {
        
        $newStudent = new markContext(['ID' => $input['markId'],'Grade'=> $input['grade']]);
        $res = $newStudent ->update();
        $resp = [
            "success" => true,
            "message" => "Группа успешно добавлена",
            "data" => $newStudent -> Grade,
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
    if ($_GET['action'] === 'del') {
    try {

        if (!isset($input['markId']) || empty($input['markId'])) {
            throw new Exception('Не указан ID оценки для удаления');
        }
        
        $id = $input['markId'];
        $resutl = markContext::delete($id);
        
        $resp = [
            "success" => $result,
            "message" => "Оценка успешно удалена", 
            "data" => $id
        ];
        
        echo json_encode($resp);
        
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'Ошибка при удалении оценки', 
            'details' => $e->getMessage()
        ]);
    }
    exit();
}
}
?>

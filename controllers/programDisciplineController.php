<?php
require_once __DIR__ . '/../classes/programDisciplineContext.php';
require_once __DIR__ . '/../classes/disciplineContext.php';
ini_set('display_errors', 0);
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if($method === 'GET' &&($_GET['action']??'')==='get'){
    try {
$allPrograms = programDisciplineContext::select();
$disciplines = disciplineContext::select();
$disArray = array_map(function($elem) {
        return [
            'ID' => $elem->ID,
            'Name' => $elem->Name
        ];
    }, $disciplines);
    $programmArray = array_map(function($student) use ($disArray) {
        $disName = $disArray[$student->DisciplineID]['Name'];
        return [
            'ID' => $student->ID,
            'Topic' => $student->Topic,
            'ClassType' => $student->ClassType,
            'Hours' => $student->Hours,
            'DisciplineID' => $disName
        ];
    }, $allPrograms);

    echo json_encode($programmArray, JSON_UNESCAPED_UNICODE);
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
        $newGroup = new programDisciplineContext(['ID'=>null,'Topic'=> $input['topic'],
    'ClassType'=>$input['classType'],'Hours' =>$input['hours'],'DisciplineID'=>$input['disciplineId']]);
        $newGroup->add();
        $resp = [
            "success" => true,
            "message" => "Группа успешно добавлена",
            "data" => $newGroup->DisciplineID
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
        $newGroup = new programDisciplineContext(['ID'=>$input['id'],'Topic'=> $input['topic'],
    'ClassType'=>$input['classType'],'Hours' =>$input['hours'],'DisciplineID'=>$input['disciplineId']]);
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
            $res = programDisciplineContext::delete($id);
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
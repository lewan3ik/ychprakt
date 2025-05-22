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
?>
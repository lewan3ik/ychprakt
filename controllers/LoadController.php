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
    $disciplines = disciplineContext::select();
    $teachers = teacherContext::select();
    $groups = groupContext::select();

    $groupArray = array_map(function($elem) {
        return [
            'ID' => $elem->ID,
            'Name' => $elem->Name
        ];
    }, $groups);

    $disciplinesArray = array_map(function($elem) {
        return [
            'ID' => $elem->ID,
            'Name' => $elem->Name
        ];
    }, $disciplines);

    $teachersArray = array_map(function($elem) {
        return [
            'ID' => $elem->ID,
            'Name' => $elem->FullName
        ];
    }, $teachers);

    $studentsArray = array_map(function($student) use ($groupArray,$teachersArray,$disciplinesArray) {
        $groupName = $groupArray[$student->GroupID]['Name'];
        $disName = $disciplinesArray[$student->DisciplineID]['Name'];
        $teacherName = $teachersArray[$student->TeacherID]['Name'];
        return [
            'ID' => $student->ID,
            'TeacherID' => $teacherName,
            'DisciplineID' => $disName,
            'GroupID' => $groupName,
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
?>
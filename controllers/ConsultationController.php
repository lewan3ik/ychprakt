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
            'GroupID'=>$groupName,
            'TeacherID'=>$teacherName
        ];
    }, $cons);
    echo json_encode($consArray, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch students', 'details' => $e->getMessage()]);
}
}
?>
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
$allles = leassonContext::select();
$students = studentContext::select();

// Подготовка данных для отображения
$studentArray = array_map(function($elem) {
    return [
        'ID' => $elem->ID,
        'Name' => $elem->FullName
    ];
}, $students);

$leassonsArray = array_map(function($elem) {
    return [
        'ID' => $elem->ID,
        'Date' => $elem->date
    ];
}, $allles);
$studentsArray = array_map(function($student) use ($studentArray,$leassonsArray) {
    $lesDate = $leassonsArray[$student->LessonID]['Date'];
    $studName = $studentArray[$student->StudentID]['Name'];

    return [
        'ID' => $student->ID,
        'StudentID' => $studName,
        'LessonID' => $lesDate,
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
?>
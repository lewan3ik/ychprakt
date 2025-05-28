<?php
ini_set('display_errors', 0);
require_once __DIR__ . '/classes/studentContext.php';
require_once __DIR__ . '/classes/leassonContext.php';
require_once __DIR__ . '/classes/markContext.php';

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if($method === 'GET' &&($_GET['action']??'')==='get'){
    try {
        $allles = leassonContext::select();
$students = studentContext::select();
$allMarks = markContext::select();

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
        'LesssonID' => $lesDate,
        'Grade' => $student->Grade
    ];
}, $allMarks);

        echo json_encode($groupArray, JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch students', 'details' => $e->getMessage()]);
    }
}



if($method === 'POST' && $_POST['action'] === 'getMarks'){
    
}
?>

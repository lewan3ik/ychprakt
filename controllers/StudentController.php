<?php
require_once __DIR__ . '/../classes/studentContext.php';
require_once __DIR__ . '/../classes/groupContext.php';
require_once __DIR__ . '/../classes/markContext.php';

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if($method === 'GET' &&($_GET['action']??'')==='get'){
    try {
    $students = studentContext::select();
    $groups = groupContext::select();

    $groupArray = array_map(function($elem) {
        return [
            'ID' => $elem->ID,
            'Name' => $elem->Name
        ];
    }, $groups);

    $studentsArray = array_map(function($student) use ($groupArray) {
        $groupName = $groupArray[$student->GroupID]['Name'];
        return [
            'ID' => $student->ID,
            'FullName' => $student->FullName,
            'login' => $student->login,
            'password' => $student->password,
            'ExpulsionDate' => $student->ExpulsionDate ? $student->ExpulsionDate : '-',
            'GroupID' => $groupName
        ];
    }, $students);

    echo json_encode($studentsArray, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch students', 'details' => $e->getMessage()]);
}
}

if($method === 'POST'){
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        if($input['action'] == 'getStudentMarks'){
            $student = studentContext::getById(1);
            $groups = markContext::select();

        $groupArray = array_filter($groups,function($elem) use ($student) {
            
            if($student->ID == $elem->StudentID){
                return [
            
            'ID' => $elem->ID,
            'StudentID' => $elem->StudentID,
            'LessonID'=>$elem->LessonID,
            'Grade' => $elem->Grade
        ];
        }});
        $result =[
            'student' => $student,
            'grades'=> $groupArray,
        ];
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    exit;
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch students', 'details' => $e->getMessage()]);
    }
}

?>

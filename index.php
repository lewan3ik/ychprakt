<?php
include_once __DIR__ . "/classes/studentContext.php";

// Функция для вывода результатов теста
function printTestResult($testName, $result) {
    echo $testName . ": " . ($result ? "ПРОЙДЕН" : "НЕ ПРОЙДЕН") . "\n";
}


// Тестирование обновления студента
function testUpdateStudent() {
    $studentId = 1; // Предположим, что студент с ID=1 уже существует
    $student = studentContext::getById($studentId);
    if ($student) {
        $student->FullName = "Обновленное Имя";
        $student->login = "updated_login";
        $student->password = "updated_password";
        $student->ExpulsionDate = "2021-01-01";
        $student->GroupID = 5;
        return $student->update();
    }
    return false;
}

// Тестирование удаления студента
function testDeleteStudent() {
    $studentId = 1; // Предположим, что студент с ID=1 уже существует
    $student = new studentContext([
        'ID' => $studentId,
        'FullName' => "",
        'login' => '',
        'password' => '',
        'ExpulsionDate' => '',
        'GroupID' => 0
    ]);
    return $student->delete($studentId);
}

// Тестирование выборки студентов
function testSelectStudents() {
    $students = studentContext::select();
    return !empty($students);
}

// Запуск тестов
printTestResult("Тест обновления студента", testUpdateStudent());
printTestResult("Тест удаления студента", testDeleteStudent());
printTestResult("Тест выборки студентов", testSelectStudents());
?>

<?php
require_once __DIR__ . '/classes/studentContext.php';
require_once __DIR__ . '/classes/leassonContext.php';
require_once __DIR__ . '/classes/skipContext.php';

// Загрузка справочных данных
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
        'Date' => $elem->Date
    ];
}, $allles);

echo "<pre>";
print_r($studentArray);
echo "</pre>";

$studentsArray = array_map(function($student) use ($students,$allles) {
    $lesDate = $leassonsArray[$student->LessonID]['Date'];
    $studName = $studentArray[$student->StudentID]['Name'];

    echo($studentArray[2]);

    return [
        'ID' => $student->ID,
        'StudentID' => $studName,
        'LesssonID' => $lesDate,
        'Minutes' => $student->Minutes,
        'ExplanationFile' => $student->ExplanationFile
    ];
}, $allSkips);

// Тестирование skipContext
echo "<h2>Тестирование работы с пропусками</h2>";

// 1. Выборка всех пропусков

echo "<h3>Все пропуски (".count($studentsArray)." записей):</h3>";
echo "<pre>";
print_r($studentsArray);
echo "</pre>";
<?php
require_once __DIR__ . '/classes/studentContext.php';
require_once __DIR__ . '/classes/leassonContext.php';
require_once __DIR__ . '/classes/markContext.php';

// Получаем данные из контекстов
$students = studentContext::select();
$allMarks = markContext::select();

// Создаем ассоциативный массив студентов для быстрого поиска по ID
$studentsMap = [];
foreach ($students as $student) {
    $studentsMap[$student->ID] = $student;
}

// Фильтруем оценки только для студентов из группы 1
$filteredMarks = array_filter($allMarks, function($mark) use ($studentsMap) {
    // Проверяем, что студент существует и принадлежит группе 1
    return isset($studentsMap[$mark->StudentID]) && $studentsMap[$mark->StudentID]->GroupID == 1;
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

// Выводим результат
echo '<pre>';
print_r($result);
echo '</pre>';
?>
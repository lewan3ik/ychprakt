<?php
// index.php
require __DIR__ . "/classes/teacherContext.php";

// Пример данных для добавления учителя
$teacherData = [
    'ID' => 8, // ID будет установлен автоматически, если это автоинкрементное поле
    'FullName' => 'Алексеев Андрей Петрович',
    'Login' => 'alekseev_ap',
    'Password' => 'password123'
];


$teacher = new teacherContext($teacherData);

if ($teacher->delete($teacher->ID)) {
    echo "Учитель успешно удален.\n";
} else {
    echo "Ошибка при удалении учителя.\n";
}
?>

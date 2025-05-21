<?php
// index.php
require __DIR__ . "/classes/disciplineContext.php";

// Тестирование добавления новой дисциплины
echo "1. Тестирование добавления дисциплины:\n";
$newDisciplineData = [
    'ID' => null, // Автоинкрементное поле
    'Name' => 'Тестовая дисциплина'
];

$discipline = new disciplineContext($newDisciplineData);
// if ($discipline->add()) {
//     echo "Дисциплина успешно добавлена. ID: " . $discipline->id . "\n";
    
//     // Сохраняем ID для последующих операций
//     $testDisciplineId = $discipline->id;
    
    // Тестирование выборки дисциплин
    echo "\n2. Тестирование выборки дисциплин:\n";
    $disciplines = disciplineContext::select();
    foreach ($disciplines as $d) {
        echo "ID: {$d->ID}, Название: {$d->Name}\n";
    }
    

//     echo "\n3. Тестирование обновления дисциплины (ID: $testDisciplineId):\n";
//     $discipline->name = 'Обновленная тестовая дисциплина';
//     if ($discipline->update()) {
//         echo "Дисциплина успешно обновлена.\n";

//         $updated = current(array_filter(disciplineContext::select(), 
//             fn($d) => $d->id == $testDisciplineId));
//         echo "Проверка: " . $updated->name . "\n";
//     } else {
//         echo "Ошибка при обновлении дисциплины.\n";
//     }
    

//     echo "\n4. Тестирование удаления дисциплины (ID: $testDisciplineId):\n";
//     if ($discipline->delete($testDisciplineId)) {
//         echo "Дисциплина успешно удалена.\n";
        

//         $deleted = current(array_filter(disciplineContext::select(), 
//             fn($d) => $d->id == $testDisciplineId));
//         echo "Проверка: " . ($deleted ? "Ошибка - дисциплина не удалена" : "Успех - дисциплина не найдена") . "\n";
//     } else {
//         echo "Ошибка при удалении дисциплины.\n";
//     }
// } else {
//     echo "Ошибка при добавлении дисциплины.\n";
// }

echo "\nТестирование завершено.\n";
?>
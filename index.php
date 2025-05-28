<?php
include_once __DIR__ . "/classes/studentContext.php";
// Загрузка справочных данны

// Подготовка данных для отображения
$newStudent = new studentContext(['ID' => null,'FullName'=> "Сергей Генадьевич",
        'login'=>'','password'=>'','ExpulsionDate'=>'2020-01-02','GroupID'=>4]);
       $newStudent -> add();
?>

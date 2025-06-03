<h2>Задание 2</h2>
<?php
    $name = "Алексей";
    $surname = "Гилев";
    $gruppa = "ИСВ-22-1";
    
    function printInfo(string $name, string $surname, string $gruppa): void {
        echo "Имя: $name <br> Фамилия: $surname <br> Группа: $gruppa <br>";
    }

    printInfo(name: $name, surname: $surname, gruppa: $gruppa);
?>
<?php
class DatabaseHelper {
private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Авторизация
    public function getTeacherByLogin($login) {
        $stmt = $this->pdo->prepare("SELECT * FROM Преподаватель WHERE Логин = ? LIMIT 1");
        $stmt->execute([$login]);
        return $stmt->fetch();
    }
    public function getGroups() {
    $stmt = $this->pdo->prepare("
        SELECT ID, Название FROM Группа
        ORDER BY Название
    ");
    $stmt->execute();
    return $stmt->fetchAll();
    // Get all teachers
    function getAllTeachers() {
    $stmt = $this->pdo->prepare("
        SELECT * FROM Преподаватель 
        ORDER BY Фамилия, Имя, Отчество
    ");
    $stmt->execute();
    return $stmt->fetchAll();
}
}

    // Группы преподавателя
    public function getGroupsByTeacher($teacherId) {
        $stmt = $this->pdo->prepare("
            SELECT g.ID, g.Название FROM Нагрузка n
            JOIN Группа g ON n.ГруппаID = g.ID
            WHERE n.ПреподавательID = ?
            GROUP BY g.ID
            ORDER BY g.Название
        ");
        $stmt->execute([$teacherId]);
        return $stmt->fetchAll();
    }
    public function getStudentsByGroup($groupId) {
    $stmt = $this->pdo->prepare("
        SELECT s.ID, s.Фамилия, s.Имя, s.Отчество, g.Название 
        FROM Студент s
        JOIN Группа g ON s.ГруппаId = g.ID
        WHERE s.ГруппаId = ?
        ORDER BY s.Фамилия, s.Имя, s.Отчество
    ");
    $stmt->execute([$groupId]);
    return $stmt->fetchAll();
}

    // Дисциплины для группы
    public function getDisciplinesByGroup($teacherId, $groupId) {
        $stmt = $this->pdo->prepare("
            SELECT d.ID, d.Наименование FROM Нагрузка n
            JOIN Дисциплина d ON n.ДисциплинаID = d.ID
            WHERE n.ПреподавательID = ? AND n.ГруппаID = ?
            ORDER BY d.Наименование
        ");
        $stmt->execute([$teacherId, $groupId]);
        return $stmt->fetchAll();
    }

    // Студенты группы


    // Оценки студента (исправленный метод)
    public function getGrades($studentId, $disciplineId) {
        $stmt = $this->pdo->prepare("
            SELECT g.Оценка, g.Дата 
            FROM Оценка g
            JOIN Занятие z ON g.ЗанятиеID = z.ID
            JOIN Нагрузка n ON z.НагрузкаID = n.ID
            WHERE g.СтудентID = ? AND n.ДисциплинаID = ?
            ORDER BY g.Дата
        ");
        $stmt->execute([$studentId, $disciplineId]);
        return $stmt->fetchAll();
    }

    // Консультации
    public function getConsultations($teacherId = null) {
        $sql = "
            SELECT c.*, g.Название as Группа 
            FROM Консультация c
            JOIN Группа g ON c.ГруппаID = g.ID
        ";
        
        if ($teacherId) {
            $sql .= " WHERE c.ПреподавательID = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$teacherId]);
        } else {
            $stmt = $this->pdo->query($sql);
        }
        
        return $stmt->fetchAll();
    }

    // Добавление оценки
    public function addGrade($studentId, $disciplineId, $grade, $date) {
        // Сначала находим нагрузку по дисциплине
        $stmt = $this->pdo->prepare("
            SELECT ID FROM Нагрузка 
            WHERE ДисциплинаID = ?
            LIMIT 1
        ");
        $stmt->execute([$disciplineId]);
        $workload = $stmt->fetch();

        if (!$workload) {
            return false;
        }

        // Создаем новое занятие
        $stmt = $this->pdo->prepare("
            INSERT INTO Занятие (Дата, НагрузкаID, ПрограммаID)
            VALUES (?, ?, 1)
        ");
        $stmt->execute([$date, $workload['ID']]);
        $lessonId = $this->pdo->lastInsertId();

        // Добавляем оценку
        $stmt = $this->pdo->prepare("
            INSERT INTO Оценка (СтудентID, ЗанятиеID, Оценка, Дата)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$studentId, $lessonId, $grade, $date]);
    }

    // Добавление консультации
    public function addConsultation($teacherId, $groupId, $date, $description) {
        $stmt = $this->pdo->prepare("
            INSERT INTO Консультация (Дата, ГруппаID, ПреподавательID)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$date, $groupId, $teacherId]);
    }
}
?>
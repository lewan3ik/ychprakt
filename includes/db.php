<?php
class Database {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    

    // ==================== АУТЕНТИФИКАЦИЯ ====================
    public function getTeacherByLogin($login) {
        $stmt = $this->pdo->prepare("SELECT * FROM Преподаватель WHERE Логин = ? LIMIT 1");
        $stmt->execute([$login]); 
        return $stmt->fetch();
    }

    // ==================== ГРУППЫ ====================
    public function getGroupsByTeacher($teacherId) {
        $stmt = $this->pdo->prepare("
            SELECT g.ID, g.Название 
            FROM Нагрузка n
            JOIN Группа g ON n.ГруппаID = g.ID
            WHERE n.ПреподавательID = ?
            GROUP BY g.ID
            ORDER BY g.Название
        ");
        $stmt->execute([$teacherId]);
        return $stmt->fetchAll();
    }

    public function getAllGroups() {
        $stmt = $this->pdo->query("SELECT * FROM Группа ORDER BY Название");
        return $stmt->fetchAll();
    }

    // ==================== ДИСЦИПЛИНЫ ====================
    public function getDisciplinesByGroup($teacherId, $groupId) {
        $stmt = $this->pdo->prepare("
            SELECT d.ID, d.Наименование 
            FROM Нагрузка n
            JOIN Дисциплина d ON n.ДисциплинаID = d.ID
            WHERE n.ПреподавательID = ? AND n.ГруппаID = ?
            ORDER BY d.Наименование
        ");
        $stmt->execute([$teacherId, $groupId]);
        return $stmt->fetchAll();
    }

    public function getAllDisciplines() {
        $stmt = $this->pdo->query("SELECT * FROM Дисциплина ORDER BY Наименование");
        return $stmt->fetchAll();
    }

    // ==================== СТУДЕНТЫ ====================
    public function getStudentsByGroup($groupId) {
        $stmt = $this->pdo->prepare("
            SELECT ID, Фамилия, Имя, Отчество 
            FROM Студент
            WHERE ГруппаID = ? AND ДатаОтчисления IS NULL
            ORDER BY Фамилия, Имя
        ");
        $stmt->execute([$groupId]);
        return $stmt->fetchAll();
    }

    // ==================== ОЦЕНКИ ====================
    public function getGrades($studentId, $disciplineId) {
        $stmt = $this->pdo->prepare("
            SELECT g.Оценка, g.Дата, z.Дата as ДатаЗанятия
            FROM Оценка g
            JOIN Занятие z ON g.ЗанятиеID = z.ID
            JOIN Нагрузка n ON z.НагрузкаID = n.ID
            WHERE g.СтудентID = ? AND n.ДисциплинаID = ?
            ORDER BY z.Дата
        ");
        $stmt->execute([$studentId, $disciplineId]);
        return $stmt->fetchAll();
    }

    public function addGrade($studentId, $disciplineId, $grade, $date) {
        // Находим нагрузку для дисциплины
        $stmt = $this->pdo->prepare("
            SELECT ID FROM Нагрузка 
            WHERE ДисциплинаID = ?
            LIMIT 1
        ");
        $stmt->execute([$disciplineId]);
        $workload = $stmt->fetch();

        if (!$workload) return false;

        // Создаем занятие
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

    // ==================== КОНСУЛЬТАЦИИ ====================
    public function getConsultations($teacherId = null) {
        $sql = "
            SELECT c.ID, c.Дата, g.Название as Группа, c.Описание
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

    public function addConsultation($teacherId, $groupId, $date, $description = null) {
        $stmt = $this->pdo->prepare("
            INSERT INTO Консультация (Дата, ГруппаID, ПреподавательID, Описание)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$date, $groupId, $teacherId, $description]);
    }

    // ==================== ПОСЕЩАЕМОСТЬ ====================
    public function getAttendance($groupId) {
        $stmt = $this->pdo->prepare("
            SELECT p.ID, s.Фамилия, s.Имя, p.Минуты, p.ФайлОбъяснительной, z.Дата as ДатаЗанятия
            FROM Пропуск p
            JOIN Студент s ON p.СтудентID = s.ID
            JOIN Занятие z ON p.ЗанятиеID = z.ID
            WHERE s.ГруппаID = ?
            ORDER BY z.Дата DESC
        ");
        $stmt->execute([$groupId]);
        return $stmt->fetchAll();
    }

    // ==================== НАГРУЗКА ====================
    public function getTeacherWorkload($teacherId) {
        $stmt = $this->pdo->prepare("
            SELECT d.Наименование as Дисциплина, g.Название as Группа,
                   n.ЧасыЛекций, n.ЧасыПрактик, n.ЧасыКонсультаций,
                   n.ЧасыКурсового, n.ЧасыЭкзамена
            FROM Нагрузка n
            JOIN Дисциплина d ON n.ДисциплинаID = d.ID
            JOIN Группа g ON n.ГруппаID = g.ID
            WHERE n.ПреподавательID = ?
            ORDER BY g.Название, d.Наименование
        ");
        $stmt->execute([$teacherId]);
        return $stmt->fetchAll();
    }

    // ==================== ОТЧЕТЫ ====================
    public function getPerformanceReport($groupId, $disciplineId = null) {
        $sql = "
            SELECT s.ID, s.Фамилия, s.Имя, 
                   AVG(g.Оценка) as СреднийБалл,
                   COUNT(CASE WHEN g.Оценка = 5 THEN 1 END) as Пятерки,
                   COUNT(CASE WHEN g.Оценка = 4 THEN 1 END) as Четверки,
                   COUNT(CASE WHEN g.Оценка = 3 THEN 1 END) as Тройки,
                   COUNT(CASE WHEN g.Оценка = 2 THEN 1 END) as Двойки
            FROM Студент s
            LEFT JOIN Оценка g ON s.ID = g.СтудентID
            LEFT JOIN Занятие z ON g.ЗанятиеID = z.ID
            LEFT JOIN Нагрузка n ON z.НагрузкаID = n.ID
            WHERE s.ГруппаID = ?
        ";

        $params = [$groupId];
        
        if ($disciplineId) {
            $sql .= " AND n.ДисциплинаID = ?";
            $params[] = $disciplineId;
        }

        $sql .= " GROUP BY s.ID ORDER BY s.Фамилия, s.Имя";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
?>
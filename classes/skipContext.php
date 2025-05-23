<?php

require_once __DIR__.'/../models/skip.php';
require_once __DIR__.'/../connection/connection.php';

class skipContext extends skip {
    public function __construct(array $data) {
        parent::__construct(
            $data['ID'],
            $data['StudentID'],
            $data['LessonID'],
            $data['Minutes'],
            $data['ExplanationFile']
        );
    }

    public static function select(): array {
        $allSkips = [];
        $sql = "SELECT * FROM `Absence`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allSkips[] = new skipContext($row);
        }
        Connection::closeConnection($connection);
        return $allSkips;
    }
    
    public function add(): bool {
        $sql = "INSERT INTO `Absence`(`StudentID`, `LessonID`, `Minutes`, `ExplanationFile`) VALUES (?, ?, ?, ?)";
        $connection = Connection::openConnection();
        
        if (!$stmt = $connection->prepare($sql)) {
            echo "Ошибка подготовки запроса: " . $connection->error;
            return false;
        }
        
        // Исправлено: правильные параметры и типы (i - integer, s - string)
        if (!$stmt->bind_param('iiss', 
            $this->StudentID,
            $this->LessonID,
            $this->Minutes,
            $this->ExplanationFile)) {
            echo "Ошибка привязки параметров: " . $stmt->error;
            return false;
        }
        
        if (!$stmt->execute()) {
            echo "Ошибка выполнения: " . $stmt->error;
            $stmt->close();
            Connection::closeConnection($connection);
            return false;
        }
        
        $stmt->close();
        Connection::closeConnection($connection);
        return true;
    }

    public function update(): bool {
        $sql = "UPDATE `Absence` SET `StudentID` = ?, `LessonID` = ?, `Minutes` = ?, `ExplanationFile` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        
        // Исправлено: добавлен ID в конец параметров
        $stmt->bind_param('iissi',
            $this->StudentID,
            $this->LessonID,
            $this->Minutes,
            $this->ExplanationFile,
            $this->ID
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function delete($delId): bool {
        $sql = "DELETE FROM `Absence` WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        
        // Исправлено: используем параметр метода $delId вместо $this->$delId
        $stmt->bind_param('i', $delId);
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }
}
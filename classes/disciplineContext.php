<?php

require_once __DIR__.'/../models/discipline.php';
require_once __DIR__.'/../connection/connection.php';

class disciplineContext extends discipline {
    public function __construct(array $data) {
        parent::__construct(
            $data['ID'],
            $data['Name']
        );
    }

    public static function select(): array {
        $allDisciplines = [];
        $sql = "SELECT * FROM `Discipline`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allDisciplines[] = new disciplineContext($row);
        }
        Connection::closeConnection($connection);
        return $allDisciplines;
    }

    public function add(): bool {
        $sql = "INSERT INTO `Discipline`(`Name`) VALUES (?)"; // Исправлено: вставляем в Discipline, а не в Group
        $connection = Connection::openConnection();
        
        if (!$stmt = $connection->prepare($sql)) {
            echo "Ошибка подготовки запроса: " . $connection->error;
            return false;
        }
        
        if (!$stmt->bind_param('s', $this->Name)) {
            echo "Ошибка привязки параметра: " . $stmt->error;
            return false;
        }
        
        if (!$stmt->execute()) {
            echo "Ошибка выполнения: " . $stmt->error;
            $stmt->close();
            Connection::closeConnection($connection);
            return false;
        }
        
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        Connection::closeConnection($connection);
        return $success;
    }

    public function update(): bool { // Изменено: возвращает bool вместо void
        $sql = "UPDATE `Discipline` SET `Name` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        
        if (!$stmt->bind_param('si', $this->Name, $this->ID)) {
            echo "Ошибка привязки параметров: " . $stmt->error;
            return false;
        }
        
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function delete($delId): bool { // Изменено: возвращает bool вместо void
        $sql = "DELETE FROM `Discipline` WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        
        // Исправлено: используем параметр метода $delId вместо $this->$delId
        if (!$stmt->bind_param('i', $delId)) {
            echo "Ошибка привязки параметра: " . $stmt->error;
            return false;
        }
        
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }
}
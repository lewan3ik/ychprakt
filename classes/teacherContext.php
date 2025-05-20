<?php

require_once __DIR__.'/../models/teacher.php';
require_once __DIR__.'/../connection/connection.php';

class teacherContext extends teacher {
    public function __construct(array $data) {
        parent::__construct(
            $data['ID'],
            $data['FullName'],
            $data['Login'],
            $data['Password']
        );
    }

    public static function select(): array {
        $allTeachers = [];
        $sql = "SELECT * FROM `Teacher`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allTeachers[] = new teacherContext($row);
        }
        Connection::closeConnection($connection);
        return $allTeachers;
    }
    
    public function add(): bool {
        $sql = "INSERT INTO `Teacher`(`FullName`, `Login`, `Password`) VALUES (?, ?, ?)";
        $connection = Connection::openConnection();
        
        if (!$stmt = $connection->prepare($sql)) {
            echo "Ошибка подготовки запроса: " . $connection->error;
            return false;
        }
        
        // Хешируем пароль перед сохранением
        $hashedPassword = password_hash($this->Password, PASSWORD_DEFAULT);
        
        if (!$stmt->bind_param('sss', 
            $this->FullName,
            $this->Login,
            $hashedPassword)) {
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
        $sql = "UPDATE `Teacher` SET `FullName` = ?, `Login` = ?, `Password` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        
        // Хешируем пароль перед обновлением
        $hashedPassword = password_hash($this->Password, PASSWORD_DEFAULT);
        
        $stmt->bind_param('sssi',
            $this->FullName,
            $this->Login,
            $hashedPassword,
            $this->ID
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function delete($delId): bool {
        $sql = "DELETE FROM `Teacher` WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        
        // Исправлено: используем параметр метода $delId
        $stmt->bind_param('i', $delId);
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }
}
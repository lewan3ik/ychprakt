<?php

require_once __DIR__.'/../models/load.php';
require_once __DIR__.'/../connection/connection.php';

class loadContext extends load {
    public function __construct(array $data) {
        parent::__construct(
            $data['ID'],
            $data['TeacherID'],
            $data['DisciplineID'],
            $data['GroupID'],
            $data['Hours']
        );
    }

    public static function select(): array {
        $allLoads = [];
        $sql = "SELECT * FROM `Load`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allLoads[] = new loadContext($row);
        }
        Connection::closeConnection($connection);
        return $allLoads;
    }
    
    public function add(): bool {
        $sql = "INSERT INTO `Load`(`DisciplineID`, `GroupID`, `TeacherID`, `Hours`) VALUES (?, ?, ?, ?)";
        $connection = Connection::openConnection();
        
        if (!$stmt = $connection->prepare($sql)) {
            echo "Ошибка подготовки запроса: " . $connection->error;
            return false;
        }
        
        // Исправлено: правильные параметры и типы
        if (!$stmt->bind_param('iiii', 
            $this->DisciplineID, 
            $this->GroupID, 
            $this->TeacherID, 
            $this->Hours)) {
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
        $sql = "UPDATE `Load` SET `DisciplineID` = ?, `GroupID` = ?, `TeacherID` = ?, `Hours` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('iiiii',
            $this->DisciplineID,
            $this->GroupID,
            $this->TeacherID,
            $this->Hours,
            $this->ID
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function delete($delId): bool {
        $sql = "DELETE FROM `Load` WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $delId);  // Исправлено: используем параметр метода, а не свойство
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }
}
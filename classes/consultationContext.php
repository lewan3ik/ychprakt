<?php

require_once __DIR__.'/../models/consultation.php';
require_once __DIR__.'/../connection/connection.php';

class consultationContext extends consultation {
    public function __construct(array $data) {
        parent::__construct(
            $data['ID'],
            $data['Date'],
            $data['GroupID'],
            $data['TeacherID']
        );
    }

    public static function select(): array {
        $allConsultations = [];
        $sql = "SELECT * FROM `Consultation`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allConsultations[] = new consultationContext($row);
        }
        Connection::closeConnection($connection);
        return $allConsultations;
    }

    public function add(): bool {
        $sql = "INSERT INTO `Consultation`(`Date`, `GroupID`, `TeacherID`) VALUES (?, ?, ?)";
        $connection = Connection::openConnection();
        
        if (!$stmt = $connection->prepare($sql)) {
            echo "Ошибка подготовки запроса: " . $connection->error;
            return false;
        }
        
        // Используем свойства объекта напрямую
        if (!$stmt->bind_param('sii', 
            $this->Date, 
            $this->GroupID, 
            $this->TeacherID)) {
            echo "Ошибка привязки параметров: " . $stmt->error;
            return false;
        }
        
        if (!$stmt->execute()) {
            echo "Ошибка выполнения запроса: " . $stmt->error;
            $stmt->close();
            Connection::closeConnection($connection);
            return false;
        }
        
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        Connection::closeConnection($connection);
        
        return $success;
    }

    public function update(): bool {
        $sql = "UPDATE `Consultation` SET `Date` = ?, `GroupID` = ?, `TeacherID` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        
        // Исправлено: регистр в именах свойств должен соответствовать конструктору
        if (!$stmt->bind_param('siii',
            $this->Date,
            $this->GroupID,
            $this->TeacherID,
            $this->ID
        )) {
            echo "Ошибка привязки параметров: " . $stmt->error;
            return false;
        }
        
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public static function delete($delId): bool {
        $sql = "DELETE FROM `Consultation` WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        
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
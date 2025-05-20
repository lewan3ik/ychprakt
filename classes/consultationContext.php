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

    public function add() {
    $sql = "INSERT INTO `Consultation`(`Date`, `GroupID`, `TeacherID`) VALUES (?, ?, ?)";
    $connection = Connection::openConnection();
    
    if (!$stmt = $connection->prepare($sql)) {
        echo "Prepare failed: " . $connection->error;
        return false;
    }
    
    // Правильные имена переменных (обратите внимание на регистр)
    $date = $this->date;
    $groupId = $this->groupId;  // должно совпадать с именем свойства
    $teacherId = $this->teacherId;  // должно совпадать с именем свойства
    
    // Исправлен тип для даты на 's' (string)
    if (!$stmt->bind_param('sii', $date, $groupId, $teacherId)) {
        echo "Bind failed: " . $stmt->error;
        return false;
    }
    
    if (!$stmt->execute()) {
        echo "Execute failed: " . $stmt->error;
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
        $sql = "UPDATE `Consultation` SET `Date` = ?, `GroupID` = ?, `TeacherID` = ? WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('siii',
            $this->date,
            $this->groupId,
            $this->teacherId,
            $this->id
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public static function delete($delId): bool {
        $sql = "DELETE FROM `Consultation` WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $delId);
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }
}
?>

<?php

require_once __DIR__.'/../models/leasson.php';
require_once __DIR__.'/../connection/connection.php';

class leassonContext extends leasson {
    public function __construct(array $data) {
        parent::__construct(
            $data['ID'],
            $data['Date'],
            $data['WordloadID'],
            $data['CurriculumID']
        );  
    }

    public static function select(): array {
        $allLeassons = [];
        $sql = "SELECT * FROM `Lesson`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allLeassons[] = new leassonContext($row);
        }
        Connection::closeConnection($connection);
        return $allLeassons;
    }
    
    public function add() {
        $sql = "INSERT INTO `Lesson`(`Date`, `WordloadID`, `CurriculumID`) VALUES (?, ?, ?)";
        $connection = Connection::openConnection();
        
        if (!$stmt = $connection->prepare($sql)) {
            echo "Prepare failed: " . $connection->error;
            return false;
        }
        
        // Исправлен тип для даты на 's' (string)
        if (!$stmt->bind_param('sii', $this->Date,WordloadID,CurriculumID)) {
            echo "Bind failed: " . $stmt->error;
            return false;
        }
        
        if (!$stmt->execute()) {
            echo "Execute failed: " . $stmt->error;
            $stmt->close();
            Connection::closeConnection($connection);
            return false;
        }
    }

    public function update(): bool {
        $sql = "UPDATE `Lesson` SET `Date` = ?, `WordloadID` = ?, `CurriculumID` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('siii',
            $this->Date,
            $this->WordloadID,
            $this->CurriculumID,
            $this->ID
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function delete($delId): bool {
        $sql = "DELETE FROM `Lesson` WHERE `ID` = ?";
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

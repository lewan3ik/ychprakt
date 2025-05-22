<?php

require_once __DIR__.'/../models/programDiscipline.php';
require_once __DIR__.'/../connection/connection.php';

class programDisciplineContext extends progarmDiscipline {
    public function __construct(array $data) {
        parent::__construct(
            $data['ID'],
            $data['Topic'],
            $data['ClassType'],
            $data['Hours'],
            $data['DisciplineID']
        );
    }

    public static function select(): array {
        $allProgramDisciplines = [];
        $sql = "SELECT * FROM `DisciplineProgram`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allProgramDisciplines[] = new programDisciplineContext($row);
        }
        Connection::closeConnection($connection);
        return $allProgramDisciplines;
    }
    
    public function add(): bool {
        $sql = "INSERT INTO `DisciplineProgram`(`Topic`, `ClassType`, `Hours`, `DisciplineID`) VALUES (?, ?, ?, ?)";
        $connection = Connection::openConnection();
        
        if (!$stmt = $connection->prepare($sql)) {
            echo "Ошибка подготовки запроса: " . $connection->error;
            return false;
        }
        
        if (!$stmt->bind_param('ssii', 
            $this->Topic,
            $this->ClassType,
            $this->Hours,
            $this->DisciplineID)) {
            echo "Ошибка привязки параметров: " . $stmt->error;
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

    public function update(): bool {
        $sql = "UPDATE `DisciplineProgram` SET `Topic` = ?, `ClassType` = ?, `Hours` = ?, `DisciplineID` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        
        if (!$stmt->bind_param('ssiii',
            $this->Topic,
            $this->ClassType,
            $this->Hours,
            $this->DisciplineID,
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

    public function delete($delId): bool {
        $sql = "DELETE FROM `DisciplineProgram` WHERE `ID` = ?";
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
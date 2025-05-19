<?php

require_once __DIR__.'/../models/programDiscipline.php';
require_once __DIR__.'/../connection/connection.php';

class programDisciplineContext extends programDiscipline {
    public function __construct(array $data) {
        parent::__construct(
            id: $data['id'],
            theme: $data['theme'],
            tipy: $data['tipy'],
            hours: $data['hours'],
            disciplineId: $data['disciplineId']
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

    public function add(): void {
        $sql = "INSERT INTO `DisciplineProgram`(`Topic`, `ClassType`, `Hours`, `DisciplineID`) VALUES (?, ?, ?, ?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('ssii',
            $this->theme,
            $this->tipy,
            $this->hours,
            $this->disciplineId
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function update(): void {
        $sql = "UPDATE `DisciplineProgram` SET `Topic` = ?, `ClassType` = ?, `Hours` = ?, `DisciplineID` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('ssiii',
            $this->theme,
            $this->tipy,
            $this->hours,
            $this->disciplineId,
            $this->id
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function delete($delId): void {
        $sql = "DELETE FROM `DisciplineProgram` WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $this->$delId);
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }
}
?>

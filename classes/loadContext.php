<?php

require_once __DIR__.'/../models/load.php';
require_once __DIR__.'/../connection/connection.php';

class loadContext extends load {
    public function __construct(array $data) {
        parent::__construct(
            id: $data['id'],
            disciplineId: $data['disciplineId'],
            groupId: $data['groupId'],
            teacherId: $data['teacherId'],
            Hours: $data['Hours']
        );
    }

    public static function select(): array {
        $allLoads = [];
        $sql = "SELECT * FROM `Workload`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allLoads[] = new loadContext($row);
        }
        Connection::closeConnection($connection);
        return $allLoads;
    }

    public function add(): void {
        $sql = "INSERT INTO `Workload`(`DisciplineID`, `GroupID`, `TeacherID`, `Hours`) VALUES (?, ?, ?, ?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('iiii',
            $this->disciplineId,
            $this->groupId,
            $this->teacherId,
            $this->Hours
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function update(): void {
        $sql = "UPDATE `Workload` SET `DisciplineID` = ?, `GroupID` = ?, `TeacherID` = ?, `Hours` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('iiiii',
            $this->disciplineId,
            $this->groupId,
            $this->teacherId,
            $this->Hours,
            $this->id
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function delete($delId): void {
        $sql = "DELETE FROM `Workload` WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $this->$delID);
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }
}
?>

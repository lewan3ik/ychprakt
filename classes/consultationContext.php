<?php

require_once __DIR__.'/../models/consultation.php';
require_once __DIR__.'/../connection/connection.php';

class consultationContext extends consultation {
    public function __construct(array $data) {
        parent::__construct(
            id: $data['id'],
            date: $data['date'],
            groupId: $data['groupId'],
            teacherId: $data['teacherId']
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

    public function add(): void {
        $sql = "INSERT INTO `Consultation`(`Date`, `GroupID`, `TeacherID`) VALUES (?, ?, ?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('sii',
            $this->date,
            $this->groupId,
            $this->teacherId
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function update(): void {
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

    public static function delete($delId): void {
        $sql = "DELETE FROM `Consultation` WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $this->delId);
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }
}
?>

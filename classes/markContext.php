<?php

require_once __DIR__.'/../models/mark.php';
require_once __DIR__.'/../connection/connection.php';

class markContext extends mark {
    public function __construct(array $data) {
        parent::__construct(
            id: $data['id'],
            studentId: $data['studentId'],
            leassonId: $data['leassonId'],
            mark: $data['mark']
        );
    }

    public static function select(): array {
        $allMarks = [];
        $sql = "SELECT * FROM `Grade`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allMarks[] = new markContext($row);
        }
        Connection::closeConnection($connection);
        return $allMarks;
    }

    public function add(): void {
        $sql = "INSERT INTO `Grade`(`StudentID`, `LessonID`, `Grade`) VALUES (?, ?, ?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('iis',
            $this->studentId,
            $this->leassonId,
            $this->mark
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function update(): void {
        $sql = "UPDATE `Grade` SET `StudentID` = ?, `LessonID` = ?, `Grade` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('iisi',
            $this->studentId,
            $this->leassonId,
            $this->mark,
            $this->id
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function delete($delId): void {
        $sql = "DELETE FROM `Grade` WHERE `ID` = ?";
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

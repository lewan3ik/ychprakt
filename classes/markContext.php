<?php

require_once __DIR__.'/../models/mark.php';
require_once __DIR__.'/../connection/connection.php';

class markContext extends mark {
    public function __construct(array $data) {
        parent::__construct(
            $data['ID'],
            $data['StudentID'],
            $data['LessonID'],
            $data['Grade']
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

    public function add(): bool {
        $sql = "INSERT INTO `Grade`(`StudentID`, `LessonID`, `Grade`) VALUES (?, ?, ?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('iis',
            $this->studentId,
            $this->lessonId,
            $this->mark
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function update(): bool {
        $sql = "UPDATE `Grade` SET `StudentID` = ?, `LessonID` = ?, `Grade` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('iisi',
            $this->studentId,
            $this->lessonId,
            $this->mark,
            $this->id
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function delete($delId): bool {
        $sql = "DELETE FROM `Grade` WHERE `ID` = ?";
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

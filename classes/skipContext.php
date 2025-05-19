<?php

require_once __DIR__.'/../models/skip.php';
require_once __DIR__.'/../connection/connection.php';

class skipContext extends skip {
    public function __construct(array $data) {
        parent::__construct(
            id: $data['id'],
            studentId: $data['studentId'],
            leassonId: $data['leassonId'],
            minuts: $data['minuts'],
            file: $data['file']
        );
    }

    public static function select(): array {
        $allSkips = [];
        $sql = "SELECT * FROM `Absence`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allSkips[] = new skipContext($row);
        }
        Connection::closeConnection($connection);
        return $allSkips;
    }

    public function add(): void {
        $sql = "INSERT INTO `Absence`(`StudentID`, `LessonID`, `Minutes`, `ExplanationFile`) VALUES (?, ?, ?, ?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('iiss',
            $this->studentId,
            $this->leassonId,
            $this->minuts,
            $this->file
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function update(): void {
        $sql = "UPDATE `Absence` SET `StudentID` = ?, `LessonID` = ?, `Minutes` = ?, `ExplanationFile` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('iissi',
            $this->studentId,
            $this->leassonId,
            $this->minuts,
            $this->file,
            $this->id
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function delete($delId): void {
        $sql = "DELETE FROM `Absence` WHERE `ID` = ?";
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

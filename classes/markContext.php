<?php

require_once __DIR__.'/../models/mark.php';
require_once __DIR__.'/../connection/connection.php';

class markContext extends mark {
    public function __construct(array $data) {
        parent::__construct(
            $data['ID'] ?? null,
            $data['StudentID'] ?? null,
            $data['LessonID'] ?? null,
            $data['Grade'] ?? null,
            $data['Date'] ?? null
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

        if (!$stmt = $connection->prepare($sql)) {
            echo "Prepare failed: " . $connection->error;
            return false;
        }

        if (!$stmt->bind_param('iii',
            $this->StudentID,
            $this->LessonID,
            $this->Grade)) {
            echo "Bind failed: " . $stmt->error;
            return false;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: " . $stmt->error;
            $stmt->close();
            Connection::closeConnection($connection);
            return false;
        }

        $stmt->close();
        Connection::closeConnection($connection);
        return true;
    }

    public function update(): bool {
        $sql = "UPDATE `Grade` SET `Grade` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('ii',
            $this->Grade,
            $this->ID
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public static function delete($delId): bool {
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

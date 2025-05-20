<?php

require_once __DIR__.'/../models/students.php';
require_once __DIR__.'/../connection/connection.php';

class studentContext extends students {
    public function __construct(array $data) {
        parent::__construct(
            id: $data['ID'],
            lastName: $data['FulName'],
            firstName: $data['login'],
            subName: $data['password'],
            dateKick: $data['ExpulsionDate'],
            groupId: $data['GroupID']
        );
    }

    public static function select(): array {
        $allStudents = [];
        $sql = "SELECT * FROM `Student`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allStudents[] = new studentContext($row);
        }
        Connection::closeConnection($connection);
        return $allStudents;
    }

    public function add() {
        $sql = "INSERT INTO `Student`(`FulName`, `login`, `password`, `ExpulsionDate`, `GroupID`) VALUES (?, ?, ?, ?, ?)";
        $connection = Connection::openConnection();

        if (!$stmt = $connection->prepare($sql)) {
            echo "Prepare failed: " . $connection->error;
            return false;
        }
        if (!$stmt->bind_param('ssssi',
            $fullName,
            $this->firstName,
            password_hash($this->subName, PASSWORD_DEFAULT),
            $this->dateKick,
            $this->groupId)) {
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
        $sql = "UPDATE `Student` SET `FulName` = ?, `login` = ?, `password` = ?, `ExpulsionDate` = ?, `GroupID` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('ssssii',
            $FulName,
            password_hash( PASSWORD_DEFAULT),
            $this->ExpulsionDate,
            $this->GroupID,
            $this->ID,
            this ->login
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function delete($delId): bool {
        $sql = "DELETE FROM `Student` WHERE `ID` = ?";
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

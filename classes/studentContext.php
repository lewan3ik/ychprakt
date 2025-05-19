<?php

require_once __DIR__.'/../models/students.php';
require_once __DIR__.'/../connection/connection.php';

class studentContext extends students {
    public function __construct(array $data) {
        parent::__construct(
            id: $data['id'],
            lastName: $data['lastName'],
            firstName: $data['firstName'],
            subName: $data['subName'],
            dateKick: $data['dateKick'],
            groupId: $data['groupId'],
            login: $data['login'],
            password: $data['password']
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

    public function add(): void {
        $sql = "INSERT INTO `Student`(`FulName`, `login`, `password`, `ExpulsionDate`, `GroupID`) VALUES (?, ?, ?, ?, ?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $fullName = $this->lastName . ' ' . $this->firstName . ' ' . $this->subName;
        $stmt->bind_param('ssssi',
            $fullName,
            $this->login,
            password_hash($this->password, PASSWORD_DEFAULT),
            $this->dateKick,
            $this->groupId
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function update(): void {
        $sql = "UPDATE `Student` SET `FulName` = ?, `login` = ?, `password` = ?, `ExpulsionDate` = ?, `GroupID` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $fullName = $this->lastName . ' ' . $this->firstName . ' ' . $this->subName;
        $stmt->bind_param('ssssii',
            $fullName,
            $this->login,
            password_hash($this->password, PASSWORD_DEFAULT),
            $this->dateKick,
            $this->groupId,
            $this->id
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function delete($delId): void {
        $sql = "DELETE FROM `Student` WHERE `ID` = ?";
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

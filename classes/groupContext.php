<?php

require_once __DIR__.'/../models/group.php';
require_once __DIR__.'/../connection/connection.php';

class groupContext extends group {
    public function __construct(array $data) {
        parent::__construct(
            id: $data['id'],
            name: $data['name']
        );
    }

    public static function select(): array {
        $allGroups = [];
        $sql = "SELECT * FROM `Group`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allGroups[] = new groupContext($row);
        }
        Connection::closeConnection($connection);
        return $allGroups;
    }

    public function add(): void {
        $sql = "INSERT INTO `Group`(`Name`) VALUES (?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('s', $this->name);
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function update(): void {
        $sql = "UPDATE `Group` SET `Name` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('si', $this->name, $this->id);
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function delete($delId): void {
        $sql = "DELETE FROM `Group` WHERE `ID` = ?";
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

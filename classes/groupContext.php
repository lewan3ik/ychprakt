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
        $sql = "SELECT * FROM `Группы`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allGroups[] = new groupContext($row);
        }
        Connection::closeConnection($connection);
        return $allGroups;
    }

    public function add(): void {
        $sql = "INSERT INTO `Группы`(`Название`) VALUES (?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('s', $this->name);
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function update(): void {
        $sql = "UPDATE `Группы` SET `Название` = ? WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('si', $this->name, $this->id);
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function delete(): void {
        $sql = "DELETE FROM `Группы` WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }
}
?>

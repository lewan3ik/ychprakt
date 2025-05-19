<?php

require_once __DIR__.'/../models/discipline.php';
require_once __DIR__.'/../connection/connection.php';

class disciplineContext extends discipline {
    public function __construct(array $data) {
        parent::__construct(
            id: $data['id'],
            name: $data['name']
        );
    }

    public static function select(): array {
        $allDisciplines = [];
        $sql = "SELECT * FROM `Дисциплины`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allDisciplines[] = new disciplineContext($row);
        }
        Connection::closeConnection($connection);
        return $allDisciplines;
    }

    public function add(): void {
        $sql = "INSERT INTO `Дисциплины`(`Название`) VALUES (?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('s', $this->name);
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function update(): void {
        $sql = "UPDATE `Дисциплины` SET `Название` = ? WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('si', $this->name, $this->id);
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function delete(): void {
        $sql = "DELETE FROM `Дисциплины` WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }
}
?>

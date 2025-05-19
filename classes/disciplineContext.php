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
        $sql = "SELECT * FROM `Discipline`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allDisciplines[] = new disciplineContext($row);
        }
        Connection::closeConnection($connection);
        return $allDisciplines;
    }

    public function add(): void {
        $sql = "INSERT INTO `Discipline`(`Name`) VALUES (?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('s', $this->name);
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function update(): void {
        $sql = "UPDATE `Discipline` SET `Name` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('si', $this->name, $this->id);
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function delete($delId): void {
        $sql = "DELETE FROM `Discipline` WHERE `ID` = ?";
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

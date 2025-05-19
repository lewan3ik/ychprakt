<?php

require_once __DIR__.'/../models/programDiscipline.php';
require_once __DIR__.'/../connection/connection.php';

class programDisciplineContext extends programDiscipline {
    public function __construct(array $data) {
        parent::__construct(
            id: $data['id'],
            theme: $data['theme'],
            tipy: $data['tipy'],
            hours: $data['hours'],
            disciplineId: $data['disciplineId']
        );
    }

    public static function select(): array {
        $allProgramDisciplines = [];
        $sql = "SELECT * FROM `ПрограммаДисциплины`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allProgramDisciplines[] = new programDisciplineContext($row);
        }
        Connection::closeConnection($connection);
        return $allProgramDisciplines;
    }

    public function add(): void {
        $sql = "INSERT INTO `ПрограммаДисциплины`(`Тема`, `Тип`, `Часы`, `ДисциплинаId`) VALUES (?, ?, ?, ?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('ssii',
            $this->theme,
            $this->tipy,
            $this->hours,
            $this->disciplineId
        );
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function update(): void {
        $sql = "UPDATE `ПрограммаДисциплины` SET `Тема` = ?, `Тип` = ?, `Часы` = ?, `ДисциплинаId` = ? WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('ssiii',
            $this->theme,
            $this->tipy,
            $this->hours,
            $this->disciplineId,
            $this->id
        );
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function delete(): void {
        $sql = "DELETE FROM `ПрограммаДисциплины` WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }
}
?>

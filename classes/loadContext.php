<?php

require_once __DIR__.'/../models/load.php';
require_once __DIR__.'/../connection/connection.php';

class loadContext extends load {
    public function __construct(array $data) {
        parent::__construct(
            id: $data['id'],
            disciplineId: $data['disciplineId'],
            groupId: $data['groupId'],
            teacherId: $data['teacherId'],
            Hours: $data['Hours']
        );
    }

    public static function select(): array {
        $allLoads = [];
        $sql = "SELECT * FROM `Нагрузки`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allLoads[] = new loadContext($row);
        }
        Connection::closeConnection($connection);
        return $allLoads;
    }

    public function add(): void {
        $sql = "INSERT INTO `Нагрузки`(`ДисциплинаId`, `ГруппаId`, `ПреподавательId`, `Часы`) VALUES (?, ?, ?, ?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('iiii',
            $this->disciplineId,
            $this->groupId,
            $this->teacherId,
            $this->Hours
        );
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function update(): void {
        $sql = "UPDATE `Нагрузки` SET `ДисциплинаId` = ?, `ГруппаId` = ?, `ПреподавательId` = ?, `Часы` = ? WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('iiiii',
            $this->disciplineId,
            $this->groupId,
            $this->teacherId,
            $this->Hours,
            $this->id
        );
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function delete(): void {
        $sql = "DELETE FROM `Нагрузки` WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }
}
?>

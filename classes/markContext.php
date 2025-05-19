<?php

require_once __DIR__.'/../models/mark.php';
require_once __DIR__.'/../connection/connection.php';

class markContext extends mark {
    public function __construct(array $data) {
        parent::__construct(
            id: $data['id'],
            studentId: $data['studentId'],
            leassonId: $data['leassonId'],
            mark: $data['mark']
        );
    }

    public static function select(): array {
        $allMarks = [];
        $sql = "SELECT * FROM `Оценки`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allMarks[] = new markContext($row);
        }
        Connection::closeConnection($connection);
        return $allMarks;
    }

    public function add(): void {
        $sql = "INSERT INTO `Оценки`(`СтудентId`, `УрокId`, `Оценка`) VALUES (?, ?, ?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('iis',
            $this->studentId,
            $this->leassonId,
            $this->mark
        );
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function update(): void {
        $sql = "UPDATE `Оценки` SET `СтудентId` = ?, `УрокId` = ?, `Оценка` = ? WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('iisi',
            $this->studentId,
            $this->leassonId,
            $this->mark,
            $this->id
        );
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function delete(): void {
        $sql = "DELETE FROM `Оценки` WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }
}
?>

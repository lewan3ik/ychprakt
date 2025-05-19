<?php

require_once __DIR__.'/../models/skip.php';
require_once __DIR__.'/../connection/connection.php';

class skipContext extends skip {
    public function __construct(array $data) {
        parent::__construct(
            id: $data['id'],
            studentId: $data['studentId'],
            leassonId: $data['leassonId'],
            minuts: $data['minuts'],
            file: $data['file']
        );
    }

    public static function select(): array {
        $allSkips = [];
        $sql = "SELECT * FROM `Пропуски`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allSkips[] = new skipContext($row);
        }
        Connection::closeConnection($connection);
        return $allSkips;
    }

    public function add(): void {
        $sql = "INSERT INTO `Пропуски`(`СтудентId`, `УрокId`, `Минуты`, `Файл`) VALUES (?, ?, ?, ?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('iiss',
            $this->studentId,
            $this->leassonId,
            $this->minuts,
            $this->file
        );
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function update(): void {
        $sql = "UPDATE `Пропуски` SET `СтудентId` = ?, `УрокId` = ?, `Минуты` = ?, `Файл` = ? WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('iissi',
            $this->studentId,
            $this->leassonId,
            $this->minuts,
            $this->file,
            $this->id
        );
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function delete(): void {
        $sql = "DELETE FROM `Пропуски` WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }
}
?>

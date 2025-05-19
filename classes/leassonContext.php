<?php

require_once __DIR__.'/../models/leasson.php';
require_once __DIR__.'/../connection/connection.php';

class leassonContext extends leasson {
    public function __construct(array $data) {
        parent::__construct(
            id: $data['id'],
            date: $data['date'],
            loadId: $data['loadId'],
            programmId: $data['programmId']
        );
    }

    public static function select(): array {
        $allLeassons = [];
        $sql = "SELECT * FROM `Занятие`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allLeassons[] = new leassonContext($row);
        }
        Connection::closeConnection($connection);
        return $allLeassons;
    }

    public function add(): void {
        $sql = "INSERT INTO `Занятие`(`Дата`, `НагрузкаId`, `ПрограммаId`) VALUES (?, ?, ?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('sii',
            $this->date,
            $this->loadId,
            $this->programmId
        );
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function update(): void {
        $sql = "UPDATE `Занятие` SET `Дата` = ?, `НагрузкаId` = ?, `ПрограммаId` = ? WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('siii',
            $this->date,
            $this->loadId,
            $this->programmId,
            $this->id
        );
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function delete(): void {
        $sql = "DELETE FROM `Занятие` WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }
}
?>

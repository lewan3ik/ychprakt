<?php

require_once __DIR__.'/../models/consultation.php';
require_once __DIR__.'/../connection/connection.php';

class consultationContext extends consultation {
    public function __construct(array $data) {
        parent::__construct(
            id: $data['id'],
            date: $data['date'],
            groupId: $data['groupId'],
            teacherId: $data['teacherId']
        );
    }

    public static function select(): array {
        $allConsultations = [];
        $sql = "SELECT * FROM `Консультации`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allConsultations[] = new consultationContext($row);
        }
        Connection::closeConnection($connection);
        return $allConsultations;
    }

    public function add(): void {
        $sql = "INSERT INTO `Консультации`(`Дата`, `ГруппаId`, `ПреподавательId`) VALUES (?, ?, ?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('sii',
            $this->date,
            $this->groupId,
            $this->teacherId
        );
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function update(): void {
        $sql = "UPDATE `Консультации` SET `Дата` = ?, `ГруппаId` = ?, `ПреподавательId` = ? WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('siii',
            $this->date,
            $this->groupId,
            $this->teacherId,
            $this->id
        );
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function delete(): void {
        $sql = "DELETE FROM `Консультации` WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }
}
?>

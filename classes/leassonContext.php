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
        $sql = "SELECT * FROM `Lesson`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allLeassons[] = new leassonContext($row);
        }
        Connection::closeConnection($connection);
        return $allLeassons;
    }

    public function add(): void {
        $sql = "INSERT INTO `Lesson`(`Date`, `WordloadID`, `CurriculumID`) VALUES (?, ?, ?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('sii',
            $this->date,
            $this->loadId,
            $this->programmId
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function update(): void {
        $sql = "UPDATE `Lesson` SET `Date` = ?, `WordloadID` = ?, `CurriculumID` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('siii',
            $this->date,
            $this->loadId,
            $this->programmId,
            $this->id
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function delete($delId): void {
        $sql = "DELETE FROM `Lesson` WHERE `ID` = ?";
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

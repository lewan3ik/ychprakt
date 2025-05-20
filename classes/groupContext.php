<?php

require_once __DIR__.'/../models/group.php';
require_once __DIR__.'/../connection/connection.php';

class groupContext extends group {
   public function __construct(array $data) {
    // Debugging statement to check the data
    parent::__construct(
        $data['ID'],
        $data['Name']
    );
}

    public static function select(): array {
        $allGroups = [];
        $sql = "SELECT * FROM `Group`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allGroups[] = new groupContext($row);
        }
        Connection::closeConnection($connection);
        return $allGroups;
    }
    public function add() {
    $sql = "INSERT INTO `Group`(`Name`) VALUES (?)";
    $connection = Connection::openConnection();
    
    if (!$stmt = $connection->prepare($sql)) {
        echo "Prepare failed: " . $connection->error;
        return false;
    }
    
    // Исправлен тип для даты на 's' (string)
    if (!$stmt->bind_param('s', $this->Name)) {
        echo "Bind failed: " . $stmt->error;
        return false;
    }
    
    if (!$stmt->execute()) {
        echo "Execute failed: " . $stmt->error;
        $stmt->close();
        Connection::closeConnection($connection);
        return false;
    }
}

    public function update(): bool {
        $sql = "UPDATE `Group` SET `Name` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('si', $this->Name, $this->ID);
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function delete($delId): bool {
        $sql = "DELETE FROM `Group` WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $delId);
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }
}
?>

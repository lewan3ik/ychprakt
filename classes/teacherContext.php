<?php


require_once __DIR__.'/../models/teacher.php';
require_once __DIR__.'/../connection/connection.php';

class teacherContext extends teacher {
    public function __construct(array $data) {
        parent::__construct(
            id: $data['id'],
            FIO: $data['FIO'],
            login: $data['login'],
            password: $data['password']
        );
    }

    public static function select(): array {
        $allteachers = [];
        $sql = "SELECT * FROM `Teacher`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allteachers[] = new teacherContext($row);
        }
        Connection::closeConnection($connection);
        return $allteachers;
    }

    public function add(): void {
        $sql = "INSERT INTO `Teacher`(`FullName`, `Login`, `Password`) VALUES (?, ?, ?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('sss', $this->FIO, $this->login, password_hash($this->password, PASSWORD_DEFAULT));
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function update(): void {
        $sql = "UPDATE `Teacher` SET `FullName` = ?, `Login` = ?, `Password` = ? WHERE `ID` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('sssi', 
            $this->FIO, 
            $this->login, 
            password_hash($this->password, PASSWORD_DEFAULT),
            $this->id
        );
        $result = $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
        return $result;
    }

    public function delete($delId): void {
        $sql = "DELETE FROM `Teacher` WHERE `ID` = ?";
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
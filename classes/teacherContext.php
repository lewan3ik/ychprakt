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
        $sql = "SELECT * FROM `Преподаватель`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allteachers[] = new teacherContext($row);
        }
        Connection::closeConnection($connection);
        return $allteachers;
    }

    public function add(): void {
        $sql = "INSERT INTO `Преподаватель`(`ФИО`, `Логин`, `Пароль`) VALUES (?, ?, ?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('sss', $this->FIO, $this->login, password_hash($this->password, PASSWORD_DEFAULT));
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function update(): void {
        $sql = "UPDATE `Преподаватель` SET `ФИО` = ?, `Логин` = ?, `Пароль` = ? WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('sssi', 
            $this->FIO, 
            $this->login, 
            password_hash($this->password, PASSWORD_DEFAULT),
            $this->id
        );
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function delete(): void {
        $sql = "DELETE FROM `Преподаватель` WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }
}
?>
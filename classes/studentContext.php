<?php

require_once __DIR__.'/../models/students.php';
require_once __DIR__.'/../connection/connection.php';

class studentContext extends students {
    public function __construct(array $data) {
        parent::__construct(
            id: $data['id'],
            lastName: $data['lastName'],
            firstName: $data['firstName'],
            subName: $data['subName'],
            dateKick: $data['dateKick'],
            groupId: $data['groupId'],
            login: $data['login'],
            password: $data['password']
        );
    }

    public static function select(): array {
        $allStudents = [];
        $sql = "SELECT * FROM `Студенты`;";
        $connection = Connection::openConnection();
        $result = Connection::query($sql, $connection);
        while ($row = $result->fetch_assoc()) {
            $allStudents[] = new studentContext($row);
        }
        Connection::closeConnection($connection);
        return $allStudents;
    }

    public function add(): void {
        $sql = "INSERT INTO `Студенты`(`ФИО`, `Логин`, `Пароль`, `ДатаОтчисления`, `ГруппаId`) VALUES (?, ?, ?, ?, ?)";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $fullName = $this->lastName . ' ' . $this->firstName . ' ' . $this->subName;
        $stmt->bind_param('ssssi',
            $fullName,
            $this->login,
            password_hash($this->password, PASSWORD_DEFAULT),
            $this->dateKick,
            $this->groupId
        );
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function update(): void {
        $sql = "UPDATE `Студенты` SET `ФИО` = ?, `Логин` = ?, `Пароль` = ?, `ДатаОтчисления` = ?, `ГруппаId` = ? WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $fullName = $this->lastName . ' ' . $this->firstName . ' ' . $this->subName;
        $stmt->bind_param('ssssii',
            $fullName,
            $this->login,
            password_hash($this->password, PASSWORD_DEFAULT),
            $this->dateKick,
            $this->groupId,
            $this->id
        );
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }

    public function delete(): void {
        $sql = "DELETE FROM `Студенты` WHERE `id` = ?";
        $connection = Connection::openConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        $stmt->close();
        Connection::closeConnection($connection);
    }
}
?>

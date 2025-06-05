<?php
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '12345');
define('DB_NAME', 'UniversityDB');

class Connection {
    public static function openConnection(): mysqli {
        $connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        if($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        return $connection;
    }

    public static function query($sql, $connection) {
    $result = $connection->query($sql);

    if(!$result) {
        die("Query failed: " . $connection->error);
    }

    return $result;
}

    public static function closeConnection($connection): void {
        $connection->close();
    }
}
?>
<?php
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'UniversityDB');

public static function openConnection():mysqli{
    $connection =  new mysqli(hostname: self::$server,username:self::$username,password:self::$password,database:self::$database);

    if($connection -> connect_error){
        die("connection failed: " . $connection->connect_error);
    }
    return $connection;
}

public static function query($sql,$connection):mixed{
    $result = $connection -> query($sql);

    if(!$result){
        die("Query filed: ".$connection ->error);
    }

    return $result;
}

public static function closeConnection($connection):void{
    $connection->close();
}
?>

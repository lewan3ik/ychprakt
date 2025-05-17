<?php
session_start();

// Установка значений по умолчанию
$_SESSION['user_id'] = $_SESSION['user_id'] ?? null;
$_SESSION['user_name'] = $_SESSION['user_name'] ?? '';
$_SESSION['user_role'] = $_SESSION['user_role'] ?? 'teacher';

// Константы
define('APP_NAME', 'Журнал оценок');
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/edu-system');

// Подключение к базе данных
try {
    $db = new PDO('mysql:host=127.0.0.1;port=3307;dbname=UniversityDB;charset=utf8mb4', 'root', '', [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_DIRECT_QUERY => false
]);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

// Функции
function redirect($url) {
    header("Location: $url");
    exit;
}


function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        redirect('login.php');
    }
}

require_once 'db_helper.php';
$dbHelper = new DatabaseHelper($db);
?>
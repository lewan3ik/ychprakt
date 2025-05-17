<?php
require_once 'config.php';
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    
    try {
        $stmt = $db->prepare("SELECT * FROM Преподаватель WHERE Логин = ? LIMIT 1");
        $stmt->execute([$login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['Пароль'])) {
            // Устанавливаем все необходимые переменные сессии
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['user_name'] = $user['ФИО'];
            $_SESSION['user_role'] = $user['Роль'] ?? 'teacher'; // Значение по умолчанию
            
            // Перенаправление в зависимости от роли
            if ($_SESSION['user_role'] == 'admin') {
                redirect('admin/dashboard.php');
            } else {
                redirect('teacher/journal.php');
            }
        } else {
            $_SESSION['error'] = "Неверный логин или пароль";
            redirect('login.php');
        }
    } catch(PDOException $e) {
        $_SESSION['error'] = "Ошибка авторизации: " . $e->getMessage();
        redirect('login.php');
    }
}
?>
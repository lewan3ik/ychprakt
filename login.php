<?php
require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    $teacher = $dbHelper->getTeacherByLogin($login);
    
    if ($teacher && password_verify($password, $teacher['Пароль'])) {
        $_SESSION['user_id'] = $teacher['ID'];
        $_SESSION['login'] = $teacher['Логин'];
        $_SESSION['user_name'] = $teacher['ФИО'];
        $_SESSION['user_role'] = $teacher['Роль'] ?? 'teacher';
        
        redirect($_SESSION['user_role'] === 'admin' ? 'admin/dashboard.php' : 'teacher/journal.php');
    } else {
        $error = "Неверный логин или пароль";
    }
}

$pageTitle = 'Авторизация';
require_once 'includes/header.php';
?>

<div class="login-container">
    <div class="login-form">
        <h2>Вход в систему</h2>
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="login">Логин:</label>
                <input type="text" id="login" name="login" required class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required class="form-control">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Войти</button>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
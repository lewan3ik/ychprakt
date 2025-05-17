<?php
require_once 'includes/config.php';
$pageTitle = 'Главная';
require_once 'includes/header.php';

// Проверяем, авторизован ли пользователь
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? '';
$userRole = $_SESSION['user_role'] ?? '';
?>

<div class="welcome-section">
    <?php if($isLoggedIn): ?>
        <h2>Добро пожаловать, <?= htmlspecialchars($userName) ?>!</h2>
        <div class="quick-links">
            <?php if($userRole == 'admin'): ?>
                <a href="admin/dashboard.php" class="btn btn-primary">Панель администратора</a>
            <?php else: ?>
                <a href="teacher/journal.php" class="btn btn-primary">Журнал оценок</a>
                <a href="teacher/consultations.php" class="btn btn-primary">Консультации</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <h2>Добро пожаловать в информационную систему</h2>
        <p>Пожалуйста, авторизуйтесь для работы с системой</p>
        <a href="login.php" class="btn btn-primary">Войти в систему</a>
    <?php endif; ?>


</div>

<?php require_once 'includes/footer.php'; ?>

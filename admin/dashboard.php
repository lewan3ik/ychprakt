<?php
require_once '../includes/config.php';
checkAuth();
checkRole('admin');

$pageTitle = 'Панель управления';
require_once '../includes/header.php';

// Получаем статистику
$groupsCount = $db->query("SELECT COUNT(*) FROM Группа")->fetchColumn();
$studentsCount = $db->query("SELECT COUNT(*) FROM Студент")->fetchColumn();
$teachersCount = $db->query("SELECT COUNT(*) FROM Преподаватель")->fetchColumn();
?>

<div class="dashboard">
    <aside class="sidebar">
        <nav>
            <ul>
                <li><a href="dashboard.php" class="active">Главная</a></li>
                <li><a href="students.php">Студенты</a></li>
                <li><a href="groups.php">Группы</a></li>
                <li><a href="teachers.php">Преподаватели</a></li>
                <li><a href="disciplines.php">Дисциплины</a></li>
                <li><a href="grades.php">Оценки</a></li>
                <li><a href="attendance.php">Посещаемость</a></li>
                <li><a href="consultations.php">Консультации</a></li>
                <li><a href="reports.php">Отчеты</a></li>
            </ul>
        </nav>
    </aside>
    
    <main class="content">
        <h2>Панель управления</h2>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Группы</h3>
                <p><?= $groupsCount ?></p>
            </div>
            <div class="stat-card">
                <h3>Студенты</h3>
                <p><?= $studentsCount ?></p>
            </div>
            <div class="stat-card">
                <h3>Преподаватели</h3>
                <p><?= $teachersCount ?></p>
            </div>
        </div>
        
        <div class="recent-activity">
            <h3>Последние действия</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Действие</th>
                        <th>Пользователь</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= date('d.m.Y') ?></td>
                        <td>Вход в систему</td>
                        <td><?= $_SESSION['user_name'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php require_once '../includes/footer.php'; ?>
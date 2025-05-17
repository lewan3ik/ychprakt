<?php
// Проверяем авторизацию
if (!isset($_SESSION['user_id'])) {
    return;
}

$currentRole = $_SESSION['user_role'] ?? 'teacher';
$currentPage = basename($_SERVER['PHP_SELF']);
$baseUrl = BASE_URL;
?>

<div class="sidebar bg-light border-end" style="width: 250px;">
    <div class="sidebar-header p-3 border-bottom">
        <h4 class="mb-0">Меню системы</h4>
    </div>
    <nav class="sidebar-nav p-3">
        <ul class="nav flex-column">
            <?php if($currentRole == 'admin'): ?>
                <!-- Меню администратора -->
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $currentPage == 'dashboard.php' ? 'active' : '' ?>" 
                       href="<?= $baseUrl ?>/admin/dashboard.php">
                        <i class="fas fa-tachometer-alt me-2"></i> Панель управления
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $currentPage == 'students.php' ? 'active' : '' ?>" 
                       href="<?= $baseUrl ?>/admin/students.php">
                        <i class="fas fa-users me-2"></i> Студенты
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $currentPage == 'teachers.php' ? 'active' : '' ?>" 
                       href="<?= $baseUrl ?>/admin/teachers.php">
                        <i class="fas fa-chalkboard-teacher me-2"></i> Преподаватели
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $currentPage == 'groups.php' ? 'active' : '' ?>" 
                       href="<?= $baseUrl ?>/admin/groups.php">
                        <i class="fas fa-layer-group me-2"></i> Группы
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $currentPage == 'disciplines.php' ? 'active' : '' ?>" 
                       href="<?= $baseUrl ?>/admin/disciplines.php">
                        <i class="fas fa-book me-2"></i> Дисциплины
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $currentPage == 'grades.php' ? 'active' : '' ?>" 
                       href="<?= $baseUrl ?>/admin/grades.php">
                        <i class="fas fa-graduation-cap me-2"></i> Оценки
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $currentPage == 'attendance.php' ? 'active' : '' ?>" 
                       href="<?= $baseUrl ?>/admin/attendance.php">
                        <i class="fas fa-calendar-check me-2"></i> Посещаемость
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $currentPage == 'consultations.php' ? 'active' : '' ?>" 
                       href="<?= $baseUrl ?>/admin/consultations.php">
                        <i class="fas fa-comments me-2"></i> Консультации
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $currentPage == 'reports.php' ? 'active' : '' ?>" 
                       href="<?= $baseUrl ?>/admin/reports.php">
                        <i class="fas fa-chart-bar me-2"></i> Отчеты
                    </a>
                </li>
            <?php else: ?>
                <!-- Меню преподавателя -->
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $currentPage == 'journal.php' ? 'active' : '' ?>" 
                       href="<?= $baseUrl ?>/teacher/journal.php">
                        <i class="fas fa-book me-2"></i> Журнал оценок
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $currentPage == 'consultations.php' ? 'active' : '' ?>" 
                       href="<?= $baseUrl ?>/teacher/consultations.php">
                        <i class="fas fa-comments me-2"></i> Консультации
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $currentPage == 'workload.php' ? 'active' : '' ?>" 
                       href="<?= $baseUrl ?>/teacher/workload.php">
                        <i class="fas fa-tasks me-2"></i> Нагрузка
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $currentPage == 'attendance.php' ? 'active' : '' ?>" 
                       href="<?= $baseUrl ?>/teacher/attendance.php">
                        <i class="fas fa-calendar-check me-2"></i> Посещаемость
                    </a>
                </li>
            <?php endif; ?>
            
            <!-- Общие пункты меню -->
            <li class="nav-item mb-2">
                <a class="nav-link <?= $currentPage == 'profile.php' ? 'active' : '' ?>" 
                   href="<?= $baseUrl ?>/profile.php">
                    <i class="fas fa-user me-2"></i> Профиль
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link <?= $currentPage == 'settings.php' ? 'active' : '' ?>" 
                   href="<?= $baseUrl ?>/settings.php">
                    <i class="fas fa-cog me-2"></i> Настройки
                </a>
            </li>
            <li class="nav-item mt-4">
                <a class="nav-link text-danger" href="<?= $baseUrl ?>/logout.php">
                    <i class="fas fa-sign-out-alt me-2"></i> Выход
                </a>
            </li>
        </ul>
    </nav>
</div>

<style>
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    z-index: 100;
    overflow-y: auto;
}

.sidebar .nav-link {
    color: #495057;
    border-radius: 5px;
    padding: 8px 12px;
    transition: all 0.3s;
    font-size: 0.9rem;
}

.sidebar .nav-link:hover {
    background-color: #e9ecef;
    color: #0d6efd;
}

.sidebar .nav-link.active {
    background-color: #0d6efd;
    color: white;
}

.sidebar .nav-link i {
    width: 20px;
    text-align: center;
}

.main-content {
    margin-left: 250px;
    padding: 20px;
}

@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        position: relative;
    }
    .main-content {
        margin-left: 0;
    }
}
</style>
<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
checkAuth();

$pageTitle = 'Управление преподавателями';
require_once __DIR__ . '/../includes/header.php';

$dbHelper = new Database($db);
$teachers = $dbHelper->getAllTeachers();
?>

<div class="dashboard-container">
    <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="content-header">
            <h1><?= $pageTitle ?></h1>
            <a href="teacher_add.php" class="btn btn-primary">Добавить преподавателя</a>
        </div>
        
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ФИО</th>
                            <th>Логин</th>
                            <th>Роль</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($teachers as $teacher): ?>
                        <tr>
                            <td><?= $teacher['ID'] ?></td>
                            <td><?= htmlspecialchars($teacher['ФИО']) ?></td>
                            <td><?= htmlspecialchars($teacher['Логин']) ?></td>
                            <td><?= $teacher['Роль'] == 'admin' ? 'Администратор' : 'Преподаватель' ?></td>
                            <td>
                                <a href="teacher_edit.php?id=<?= $teacher['ID'] ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Редактировать
                                </a>
                                <?php if($teacher['ID'] != $_SESSION['user_id']): ?>
                                <a href="teacher_delete.php?id=<?= $teacher['ID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">
                                    <i class="fas fa-trash"></i> Удалить
                                </a>
                                <?php endif; ?>
                                <a href="teacher_workload.php?id=<?= $teacher['ID'] ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-chalkboard"></i> Нагрузка
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
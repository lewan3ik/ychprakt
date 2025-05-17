<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
checkAuth();
checkRole('admin');

$pageTitle = 'Управление группами';
require_once __DIR__ . '/../includes/header.php';

$dbHelper = new Database($db);
$groups = $dbHelper->getAllGroups();
?>

<div class="dashboard-container">
    <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="content-header">
            <h1><?= $pageTitle ?></h1>
            <a href="group_add.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Добавить группу
            </a>
        </div>
        
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Количество студентов</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($groups as $group): 
                            $studentsCount = $db->query("SELECT COUNT(*) FROM Студент WHERE ГруппаID = {$group['ID']}")->fetchColumn();
                        ?>
                        <tr>
                            <td><?= $group['ID'] ?></td>
                            <td><?= htmlspecialchars($group['Название']) ?></td>
                            <td><?= $studentsCount ?></td>
                            <td>
                                <a href="group_edit.php?id=<?= $group['ID'] ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="group_students.php?id=<?= $group['ID'] ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-users"></i>
                                </a>
                                <?php if($studentsCount == 0): ?>
                                <a href="group_delete.php?id=<?= $group['ID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <?php else: ?>
                                <button class="btn btn-sm btn-danger" disabled title="Нельзя удалить группу с студентами">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php endif; ?>
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
<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
checkAuth();
checkRole('admin');

$pageTitle = 'Управление дисциплинами';
require_once __DIR__ . '/../includes/header.php';

$dbHelper = new Database($db);
$disciplines = $dbHelper->getAllDisciplines();
?>

<div class="dashboard-container">
    <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="content-header">
            <h1><?= $pageTitle ?></h1>
            <a href="discipline_add.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Добавить дисциплину
            </a>
        </div>
        
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Количество групп</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($disciplines as $discipline): 
                            $groupsCount = $db->query("
                                SELECT COUNT(DISTINCT ГруппаID) 
                                FROM Нагрузка 
                                WHERE ДисциплинаID = {$discipline['ID']}
                            ")->fetchColumn();
                        ?>
                        <tr>
                            <td><?= $discipline['ID'] ?></td>
                            <td><?= htmlspecialchars($discipline['Наименование']) ?></td>
                            <td><?= $groupsCount ?></td>
                            <td>
                                <a href="discipline_edit.php?id=<?= $discipline['ID'] ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="discipline_program.php?id=<?= $discipline['ID'] ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-list"></i> Программа
                                </a>
                                <?php if($groupsCount == 0): ?>
                                <a href="discipline_delete.php?id=<?= $discipline['ID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <?php else: ?>
                                <button class="btn btn-sm btn-danger" disabled title="Нельзя удалить дисциплину с нагрузкой">
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
<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
checkAuth();
checkRole('admin');

$pageTitle = 'Управление посещаемостью';
require_once __DIR__ . '/../includes/header.php';

$dbHelper = new Database($db);
$groups = $dbHelper->getAllGroups();
$selectedGroup = $_GET['group_id'] ?? null;

// Получаем данные о посещаемости
$attendance = [];
if ($selectedGroup) {
    $attendance = $dbHelper->getAttendance($selectedGroup);
}
?>

<div class="dashboard-container">
    <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="content-header">
            <h1><?= $pageTitle ?></h1>
        </div>
        
        <div class="card mb-4">
            <div class="card-body">
                <form method="get" class="row g-3">
                    <div class="col-md-10">
                        <label for="group_id" class="form-label">Группа</label>
                        <select id="group_id" name="group_id" class="form-select" required>
                            <option value="">Выберите группу</option>
                            <?php foreach($groups as $group): ?>
                            <option value="<?= $group['ID'] ?>" <?= $selectedGroup == $group['ID'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($group['Название']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Показать
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <?php if($selectedGroup): ?>
        <div class="card">
            <div class="card-header">
                <h3>
                    Посещаемость группы: <?= htmlspecialchars($groups[array_search($selectedGroup, array_column($groups, 'ID'))]['Название']) ?>
                    <small class="text-muted">
                        Всего студентов: <?= count(array_unique(array_column($attendance, 'ID'))) ?>
                    </small>
                </h3>
            </div>
            <div class="card-body">
                <?php if(!empty($attendance)): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Студент</th>
                                <th>Дата</th>
                                <th>Дисциплина</th>
                                <th>Минут пропущено</th>
                                <th>Объяснительная</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($attendance as $record): ?>
                            <tr>
                                <td><?= htmlspecialchars($record['Фамилия'] . ' ' . $record['Имя'] . ' ' . $record['Отчество']) ?></td>
                                <td><?= date('d.m.Y', strtotime($record['Дата'])) ?></td>
                                <td><?= htmlspecialchars($record['Дисциплина']) ?></td>
                                <td><?= $record['Минуты'] ?></td>
                                <td>
                                    <?php if(!empty($record['ФайлОбъяснительной'])): ?>
                                    <a href="../uploads/<?= $record['ФайлОбъяснительной'] ?>" target="_blank" class="btn btn-sm btn-success">
                                        <i class="fas fa-file-pdf"></i> Просмотреть
                                    </a>
                                    <?php else: ?>
                                    <span class="text-muted">Отсутствует</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="attendance_edit.php?id=<?= $record['ID'] ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="attendance_delete.php?id=<?= $record['ID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="alert alert-info">Нет данных о посещаемости</div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
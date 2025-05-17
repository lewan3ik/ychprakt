<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
checkAuth();

$pageTitle = 'Журнал оценок';
require_once __DIR__ . '/../includes/header.php';

$dbHelper = new Database($db);
$isAdmin = ($_SESSION['user_role'] == 'admin');
$teacherId = $_SESSION['user_id'];

// Получаем группы
$groups = $isAdmin 
    ? $dbHelper->getAllGroups() 
    : $db->query("
        SELECT DISTINCT g.ID, g.Название 
        FROM Нагрузка n
        JOIN Группа g ON n.ГруппаID = g.ID
        WHERE n.ПреподавательID = $teacherId
        ORDER BY g.Название
    ")->fetchAll(PDO::FETCH_ASSOC);

$selectedGroup = $_GET['group_id'] ?? null;
$selectedDiscipline = $_GET['discipline_id'] ?? null;

// Получаем дисциплины для выбранной группы
$disciplines = [];
if ($selectedGroup) {
    $disciplines = $isAdmin 
        ? $db->query("
            SELECT DISTINCT d.ID, d.Наименование 
            FROM Нагрузка n
            JOIN Дисциплина d ON n.ДисциплинаID = d.ID
            WHERE n.ГруппаID = $selectedGroup
            ORDER BY d.Наименование
        ")->fetchAll(PDO::FETCH_ASSOC)
        : $db->query("
            SELECT DISTINCT d.ID, d.Наименование 
            FROM Нагрузка n
            JOIN Дисциплина d ON n.ДисциплинаID = d.ID
            WHERE n.ГруппаID = $selectedGroup AND n.ПреподавательID = $teacherId
            ORDER BY d.Наименование
        ")->fetchAll(PDO::FETCH_ASSOC);
}

// Получаем оценки
$grades = [];
if ($selectedGroup && $selectedDiscipline) {
    $filters = [
        'group_id' => $selectedGroup,
        'discipline_id' => $selectedDiscipline
    ];
    
    if (!$isAdmin) {
        $filters['teacher_id'] = $teacherId;
    }
    
    $grades = $dbHelper->getGrades($filters);
}
?>

<div class="dashboard-container">
    <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="content-header">
            <h1><?= $pageTitle ?></h1>
            <?php if($selectedGroup && $selectedDiscipline): ?>
            <a href="grade_add.php?group_id=<?= $selectedGroup ?>&discipline_id=<?= $selectedDiscipline ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Добавить оценку
            </a>
            <?php endif; ?>
        </div>
        
        <div class="card mb-4">
            <div class="card-body">
                <form method="get" class="row g-3">
                    <div class="col-md-5">
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
                    <div class="col-md-5">
                        <label for="discipline_id" class="form-label">Дисциплина</label>
                        <select id="discipline_id" name="discipline_id" class="form-select" <?= !$selectedGroup ? 'disabled' : '' ?> required>
                            <option value="">Выберите дисциплину</option>
                            <?php if($selectedGroup): ?>
                                <?php foreach($disciplines as $discipline): ?>
                                <option value="<?= $discipline['ID'] ?>" <?= $selectedDiscipline == $discipline['ID'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($discipline['Наименование']) ?>
                                </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
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
        
        <?php if($selectedGroup && $selectedDiscipline): ?>
        <div class="card">
            <div class="card-header">
                <h3>
                    Оценки по дисциплине: <?= htmlspecialchars($disciplines[array_search($selectedDiscipline, array_column($disciplines, 'ID'))]['Наименование']) ?>
                    <small class="text-muted">
                        Группа: <?= htmlspecialchars($groups[array_search($selectedGroup, array_column($groups, 'ID'))]['Название']) ?>
                    </small>
                </h3>
            </div>
            <div class="card-body">
                <?php if(!empty($grades)): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Студент</th>
                                <th>Оценка</th>
                                <th>Дата</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($grades as $grade): ?>
                            <tr>
                                <td><?= htmlspecialchars($grade['Фамилия'] . ' ' . $grade['Имя'] . ' ' . $grade['Отчество']) ?></td>
                                <td>
                                    <span class="badge bg-<?= 
                                        $grade['Оценка'] == 5 ? 'success' : 
                                        ($grade['Оценка'] == 4 ? 'info' : 
                                        ($grade['Оценка'] == 3 ? 'warning' : 'danger')) 
                                    ?>">
                                        <?= $grade['Оценка'] ?>
                                    </span>
                                </td>
                                <td><?= date('d.m.Y', strtotime($grade['Дата'])) ?></td>
                                <td>
                                    <a href="grade_edit.php?id=<?= $grade['ID'] ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="grade_delete.php?id=<?= $grade['ID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="alert alert-info">Нет оценок для отображения</div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Динамическая загрузка дисциплин при выборе группы
document.getElementById('group_id').addEventListener('change', function() {
    const groupId = this.value;
    const disciplineSelect = document.getElementById('discipline_id');
    
    if (groupId) {
        fetch(`get_disciplines.php?group_id=${groupId}<?= !$isAdmin ? '&teacher_id='.$teacherId : '' ?>`)
            .then(response => response.json())
            .then(data => {
                disciplineSelect.innerHTML = '<option value="">Выберите дисциплину</option>';
                data.forEach(discipline => {
                    const option = document.createElement('option');
                    option.value = discipline.ID;
                    option.textContent = discipline.Наименование;
                    disciplineSelect.appendChild(option);
                });
                disciplineSelect.disabled = false;
            });
    } else {
        disciplineSelect.innerHTML = '<option value="">Выберите дисциплину</option>';
        disciplineSelect.disabled = true;
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
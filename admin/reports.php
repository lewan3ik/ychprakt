<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
checkAuth();

$pageTitle = 'Отчеты';
require_once __DIR__ . '/../includes/header.php';

$dbHelper = new Database($db);
$groups = $dbHelper->getAllGroups();
$selectedGroup = $_GET['group_id'] ?? null;
$reportType = $_GET['report_type'] ?? 'debtors';

// Получаем данные для отчета
$reportData = [];
$reportTitle = '';

if ($selectedGroup) {
    switch ($reportType) {
        case 'debtors':
            $reportTitle = 'Студенты-должники';
            $reportData = $db->query("
                SELECT s.ID, s.Фамилия, s.Имя, s.Отчество, 
                       d.Наименование as Дисциплина, 
                       COUNT(g.ID) as КоличествоДолгов,
                       GROUP_CONCAT(DISTINCT g.Оценка ORDER BY g.Дата DESC SEPARATOR ', ') as Оценки
                FROM Студент s
                JOIN Оценка g ON s.ID = g.СтудентID
                JOIN Занятие l ON g.ЗанятиеID = l.ID
                JOIN Дисциплина d ON l.ДисциплинаID = d.ID
                WHERE s.ГруппаID = $selectedGroup AND g.Оценка < 3
                GROUP BY s.ID, d.ID
                HAVING КоличествоДолгов > 0
                ORDER BY s.Фамилия, s.Имя
            ")->fetchAll(PDO::FETCH_ASSOC);
            break;
            
        case 'attendance':
            $reportTitle = 'Посещаемость студентов';
            $reportData = $db->query("
                SELECT s.ID, s.Фамилия, s.Имя, s.Отчество,
                       COUNT(a.ID) as КоличествоПропусков,
                       SUM(a.Минуты) as ВсегоМинут,
                       GROUP_CONCAT(DISTINCT d.Наименование SEPARATOR ', ') as Дисциплины
                FROM Студент s
                LEFT JOIN Пропуск a ON s.ID = a.СтудентID
                LEFT JOIN Занятие l ON a.ЗанятиеID = l.ID
                LEFT JOIN Дисциплина d ON l.ДисциплинаID = d.ID
                WHERE s.ГруппаID = $selectedGroup
                GROUP BY s.ID
                ORDER BY КоличествоПропусков DESC
            ")->fetchAll(PDO::FETCH_ASSOC);
            break;
            
        case 'performance':
            $reportTitle = 'Успеваемость группы';
            $reportData = $db->query("
                SELECT d.Наименование as Дисциплина,
                       AVG(g.Оценка) as СреднийБалл,
                       COUNT(CASE WHEN g.Оценка = 5 THEN 1 END) as Пятерки,
                       COUNT(CASE WHEN g.Оценка = 4 THEN 1 END) as Четверки,
                       COUNT(CASE WHEN g.Оценка = 3 THEN 1 END) as Тройки,
                       COUNT(CASE WHEN g.Оценка = 2 THEN 1 END) as Двойки
                FROM Оценка g
                JOIN Студент s ON g.СтудентID = s.ID
                JOIN Занятие l ON g.ЗанятиеID = l.ID
                JOIN Дисциплина d ON l.ДисциплинаID = d.ID
                WHERE s.ГруппаID = $selectedGroup
                GROUP BY d.ID
                ORDER BY СреднийБалл DESC
            ")->fetchAll(PDO::FETCH_ASSOC);
            break;
    }
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
                        <label for="report_type" class="form-label">Тип отчета</label>
                        <select id="report_type" name="report_type" class="form-select">
                            <option value="debtors" <?= $reportType == 'debtors' ? 'selected' : '' ?>>Студенты-должники</option>
                            <option value="attendance" <?= $reportType == 'attendance' ? 'selected' : '' ?>>Посещаемость</option>
                            <option value="performance" <?= $reportType == 'performance' ? 'selected' : '' ?>>Успеваемость</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Сформировать
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <?php if($selectedGroup && !empty($reportData)): ?>
        <div class="card">
            <div class="card-header">
                <h3><?= $reportTitle ?> - <?= htmlspecialchars($groups[array_search($selectedGroup, array_column($groups, 'ID'))]['Название']) ?></h3>
                <a href="report_export.php?group_id=<?= $selectedGroup ?>&report_type=<?= $reportType ?>" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Экспорт в Excel
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <?php if($reportType == 'debtors'): ?>
                                    <th>Студент</th>
                                    <th>Дисциплина</th>
                                    <th>Количество долгов</th>
                                    <th>Последние оценки</th>
                                <?php elseif($reportType == 'attendance'): ?>
                                    <th>Студент</th>
                                    <th>Количество пропусков</th>
                                    <th>Всего минут</th>
                                    <th>Дисциплины</th>
                                <?php else: ?>
                                    <th>Дисциплина</th>
                                    <th>Средний балл</th>
                                    <th>5</th>
                                    <th>4</th>
                                    <th>3</th>
                                    <th>2</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($reportData as $row): ?>
                            <tr>
                                <?php if($reportType == 'debtors'): ?>
                                    <td><?= htmlspecialchars($row['Фамилия'] . ' ' . $row['Имя'] . ' ' . $row['Отчество']) ?></td>
                                    <td><?= htmlspecialchars($row['Дисциплина']) ?></td>
                                    <td><?= $row['КоличествоДолгов'] ?></td>
                                    <td><?= $row['Оценки'] ?></td>
                                <?php elseif($reportType == 'attendance'): ?>
                                    <td><?= htmlspecialchars($row['Фамилия'] . ' ' . $row['Имя'] . ' ' . $row['Отчество']) ?></td>
                                    <td><?= $row['КоличествоПропусков'] ?></td>
                                    <td><?= $row['ВсегоМинут'] ?? 0 ?></td>
                                    <td><?= $row['Дисциплины'] ?? '-' ?></td>
                                <?php else: ?>
                                    <td><?= htmlspecialchars($row['Дисциплина']) ?></td>
                                    <td><?= round($row['СреднийБалл'], 2) ?></td>
                                    <td><?= $row['Пятерки'] ?></td>
                                    <td><?= $row['Четверки'] ?></td>
                                    <td><?= $row['Тройки'] ?></td>
                                    <td><?= $row['Двойки'] ?></td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php elseif($selectedGroup): ?>
        <div class="alert alert-info">Нет данных для отображения</div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
<?php
require_once '../includes/config.php';
require_once '../includes/db_helper.php';
checkAuth();

$pageTitle = 'Управление студентами';
require_once '../includes/header.php';

$groups = $dbHelper->getGroups();
$selectedGroup = $_GET['group'] ?? null;
$students = $selectedGroup ? $dbHelper->getStudentsByGroup($selectedGroup) : [];
?>

<div class="dashboard">
    <aside class="sidebar">
        <!-- Навигация как в dashboard.php -->
    </aside>
    
    <main class="content">
        <div class="page-header">
            <h2>Управление студентами</h2>
            <a href="student_add.php" class="btn btn-primary">Добавить студента</a>
        </div>
        
        <form method="get" class="filter-form">
            <div class="form-group">
                <label for="group">Группа:</label>
                <select id="group" name="group" class="form-control">
                    <option value="">Все группы</option>
                    <?php foreach($groups as $group): ?>
                        <option value="<?= $group['ID'] ?>" <?= $selectedGroup == $group['ID'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($group['Название']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Применить</button>
        </form>
        
        <?php if($students): ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Группа</th>
                    <th>Дата отчисления</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($students as $student): 
                    $groupName = '';
                    foreach($groups as $group) {
                        if ($group['ID'] == $student['ГруппаID']) {
                            $groupName = $group['Название'];
                            break;
                        }
                    }
                ?>
                <tr>
                    <td><?= htmlspecialchars($student['Фамилия'] . ' ' . $student['Имя'] . ' ' . $student['Отчество']) ?></td>
                    <td><?= htmlspecialchars($groupName) ?></td>
                    <td><?= $student['ДатаОтчисления'] ? date('d.m.Y', strtotime($student['ДатаОтчисления'])) : '-' ?></td>
                    <td>
                        <a href="student_edit.php?id=<?= $student['ID'] ?>" class="btn btn-sm btn-edit">Редактировать</a>
                        <a href="student_delete.php?id=<?= $student['ID'] ?>" class="btn btn-sm btn-delete" onclick="return confirm('Вы уверены?')">Удалить</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p>Нет данных для отображения</p>
        <?php endif; ?>
    </main>
</div>

<?php require_once '../includes/footer.php'; ?>
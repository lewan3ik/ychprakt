<?php
require_once '../includes/config.php';
checkAuth();

$pageTitle = 'Журнал оценок';
require_once '../includes/header.php';

$teacherId = $_SESSION['user_id'];
$groups = $dbHelper->getGroupsByTeacher($teacherId);
$selectedGroup = $_GET['group_id'] ?? null;
$selectedDiscipline = $_GET['discipline_id'] ?? null;

// Получение данных
$disciplines = [];
$students = [];
if ($selectedGroup) {
    $disciplines = $dbHelper->getDisciplinesByGroup($teacherId, $selectedGroup);
    echo $disciplines[0];
    if ($selectedDiscipline) {
        $students = $dbHelper->getStudentsByGroup($selectedGroup);
    }
}

// Обработка добавления оценки
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_grade'])) {
    $dbHelper->addGrade(
        $_POST['student_id'],
        $_POST['discipline_id'],
        $_POST['grade'],
        $_POST['date']
    );
    header("Location: journal.php?group_id=$selectedGroup&discipline_id=$selectedDiscipline");
    exit;
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <?php include '../includes/sidebar.php'; ?>
        </div>
        <div class="col-md-9">
            <h2><?= $pageTitle ?></h2>
            
            <!-- Форма выбора -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-5">
                            <select name="group_id" class="form-select" required>
                                <option value="">Выберите группу</option>
                                <?php foreach($groups as $group): ?>
                                    <option value="<?= $group['ID'] ?>" <?= $selectedGroup == $group['ID'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($group['Название']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <select name="discipline_id" class="form-select" <?= !$selectedGroup ? 'disabled' : '' ?>>
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
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Показать</button>
                        </div>
                    </form>
                </div>
            </div>

            <?php if($selectedGroup && $selectedDiscipline): ?>
            <!-- Таблица с оценками -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        <?= htmlspecialchars(
                            array_column($disciplines, 'Наименование', 'ID')[$selectedDiscipline]
                        ) ?>
                        <small class="text-muted">
                            Группа: <?= htmlspecialchars(
                                array_column($groups, 'Название', 'ID')[$selectedGroup]
                            ) ?>
                        </small>
                    </h4>
                    
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Студент</th>
                                <th>Оценки</th>
                                <th>Средний балл</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($students as $student): 
                                $grades = $dbHelper->getGrades($student['ID'], $selectedDiscipline);
                                $avg = count($grades) > 0 ? 
                                    array_sum(array_column($grades, 'Оценка')) / count($grades) : 0;
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($student['Фамилия'] . ' ' . $student['Имя']) ?></td>
                                <td>
                                    <?php foreach($grades as $grade): ?>
                                        <span class="badge bg-<?= $grade['Оценка'] >= 4 ? 'success' : 'warning' ?> me-1">
                                            <?= $grade['Оценка'] ?> (<?= date('d.m', strtotime($grade['Дата'])) ?>)
                                        </span>
                                    <?php endforeach; ?>
                                </td>
                                <td><?= round($avg, 2) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" 
                                        data-bs-target="#addGradeModal"
                                        data-student-id="<?= $student['ID'] ?>"
                                        data-student-name="<?= htmlspecialchars($student['Фамилия'] . ' ' . $student['Имя']) ?>">
                                        Добавить оценку
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Модальное окно добавления оценки -->
<div class="modal fade" id="addGradeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="discipline_id" value="<?= $selectedDiscipline ?>">
                <input type="hidden" name="student_id" id="modalStudentId">
                <input type="hidden" name="add_grade" value="1">
                
                <div class="modal-header">
                    <h5 class="modal-title">Добавить оценку</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Студент</label>
                        <input type="text" class="form-control" id="modalStudentName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Оценка</label>
                        <select name="grade" class="form-select" required>
                            <option value="5">5 (Отлично)</option>
                            <option value="4">4 (Хорошо)</option>
                            <option value="3">3 (Удовлетворительно)</option>
                            <option value="2">2 (Неудовлетворительно)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Дата</label>
                        <input type="date" name="date" class="form-control" required 
                               value="<?= date('Y-m-d') ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('addGradeModal').addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    document.getElementById('modalStudentId').value = button.getAttribute('data-student-id');
    document.getElementById('modalStudentName').value = button.getAttribute('data-student-name');
});
</script>

<?php require_once '../includes/footer.php'; ?>
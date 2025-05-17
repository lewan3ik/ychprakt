<?php
require_once __DIR__ . '/../includes/config.php';
checkAuth();

$pageTitle = 'Консультации';
require_once __DIR__ . '/../includes/header.php';

// Проверяем инициализацию $dbHelper
if (!isset($dbHelper)) {
    die("Ошибка: Database helper не инициализирован");
}

$isAdmin = ($_SESSION['user_role'] == 'admin');
$teacherId = $_SESSION['user_id'];

// Получаем консультации в зависимости от роли
$consultations = $isAdmin 
    ? $dbHelper->getConsultations() 
    : $dbHelper->getConsultations($teacherId);

// Получаем группы для формы
$groups = $dbHelper->getAllGroups();
?>

<div class="dashboard-container">
    <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>
    
    <div class="main-content">
        <!-- Остальной код остается без изменений -->
        <div class="content-header">
            <h1><?= $pageTitle ?></h1>
            <button id="addConsultationBtn" class="btn btn-primary">
                <i class="fas fa-plus"></i> Добавить консультацию
            </button>
        </div>
        
        <!-- Форма добавления консультации -->
        <div id="consultationForm" class="card mb-4" style="display: none;">
            <div class="card-header">
                <h3>Новая консультация</h3>
            </div>
            <div class="card-body">
                <form method="post" action="consultation_save.php">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label">Дата и время</label>
                            <input type="datetime-local" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="group" class="form-label">Группа</label>
                            <select class="form-select" id="group" name="group_id" required>
                                <option value="">Выберите группу</option>
                                <?php foreach($groups as $group): ?>
                                <option value="<?= $group['ID'] ?>"><?= htmlspecialchars($group['Название']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <?php if($isAdmin): ?>
                    <div class="mb-3">
                        <label for="teacher" class="form-label">Преподаватель</label>
                        <select class="form-select" id="teacher" name="teacher_id" required>
                            <option value="">Выберите преподавателя</option>
                            <?php foreach($dbHelper->getAllTeachers() as $teacher): ?>
                            <option value="<?= $teacher['ID'] ?>"><?= htmlspecialchars($teacher['ФИО']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php else: ?>
                    <input type="hidden" name="teacher_id" value="<?= $teacherId ?>">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="description" class="form-label">Описание</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <button type="button" id="cancelConsultationBtn" class="btn btn-secondary">Отмена</button>
                </form>
            </div>
        </div>
        
        <!-- Список консультаций -->
        <div class="card">
            <div class="card-header">
                <h3>Запланированные консультации</h3>
            </div>
            <div class="card-body">
                <?php if(!empty($consultations)): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Группа</th>
                                <?php if($isAdmin): ?><th>Преподаватель</th><?php endif; ?>
                                <th>Описание</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($consultations as $consultation): ?>
                            <tr>
                                <td><?= date('d.m.Y H:i', strtotime($consultation['Дата'])) ?></td>
                                <td><?= htmlspecialchars($consultation['Группа']) ?></td>
                                <?php if($isAdmin): ?>
                                <td><?= htmlspecialchars($consultation['Преподаватель']) ?></td>
                                <?php endif; ?>
                                <td><?= !empty($consultation['Описание']) ? htmlspecialchars($consultation['Описание']) : '-' ?></td>
                                <td>
                                    <a href="consultation_view.php?id=<?= $consultation['ID'] ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="consultation_edit.php?id=<?= $consultation['ID'] ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="consultation_delete.php?id=<?= $consultation['ID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="alert alert-info">Нет запланированных консультаций</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Показать/скрыть форму добавления
document.getElementById('addConsultationBtn').addEventListener('click', function() {
    document.getElementById('consultationForm').style.display = 'block';
    this.style.display = 'none';
});

document.getElementById('cancelConsultationBtn').addEventListener('click', function() {
    document.getElementById('consultationForm').style.display = 'none';
    document.getElementById('addConsultationBtn').style.display = 'block';
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
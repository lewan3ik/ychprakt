<?php
require_once '../includes/config.php';
checkAuth();

$pageTitle = 'Консультации';
require_once '../includes/header.php';

$teacherId = $_SESSION['user_id'];
$consultations = $dbHelper->getConsultations($teacherId);
$groups = $dbHelper->getGroupsByTeacher($teacherId);

// Обработка добавления консультации
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_consultation'])) {
    $dbHelper->addConsultation(
        $teacherId,
        $_POST['group_id'],
        $_POST['date'],
        $_POST['description']
    );
    header("Location: consultations.php");
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
            
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addConsultationModal">
                <i class="fas fa-plus"></i> Добавить консультацию
            </button>
            
            <div class="card">
                <div class="card-body">
                    <?php if(!empty($consultations)): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Группа</th>
                                <th>Описание</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($consultations as $consultation): ?>
                            <tr>
                                <td><?= date('d.m.Y H:i', strtotime($consultation['Дата'])) ?></td>
                                <td><?= htmlspecialchars($consultation['Группа']) ?></td>
                                <td><?= !empty($consultation['Описание']) ? htmlspecialchars($consultation['Описание']) : '-' ?></td>
                                <td>
                                    <button class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <div class="alert alert-info">Нет запланированных консультаций</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно добавления консультации -->
<div class="modal fade" id="addConsultationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="add_consultation" value="1">
                
                <div class="modal-header">
                    <h5 class="modal-title">Новая консультация</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Группа</label>
                        <select name="group_id" class="form-select" required>
                            <option value="">Выберите группу</option>
                            <?php foreach($groups as $group): ?>
                                <option value="<?= $group['ID'] ?>"><?= htmlspecialchars($group['Название']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Дата и время</label>
                        <input type="datetime-local" name="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Описание</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
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

<?php require_once '../includes/footer.php'; ?>
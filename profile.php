<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

checkAuth();

$pageTitle = 'Профиль пользователя';
require_once __DIR__ . '/includes/header.php';

$currentUser = [
    'ФИО' => $_SESSION['user_name'],
    'Логин' => $_SESSION['login'],
    'Роль' => $_SESSION['user_role']
];
?>

<div class="dashboard">
    
    <div class="content">
        <div class="page-header">
            <h1><?= $pageTitle ?></h1>
        </div>
        
        <div class="container">
            <div class="stat-card" style="max-width: 600px; margin: 0 auto; text-align: left;">
                <div style="display: flex; align-items: center; margin-bottom: 20px;">
                    <div style="width: 80px; height: 80px; background-color: var(--gray); border-radius: 50%; 
                                display: flex; align-items: center; justify-content: center; margin-right: 20px;">
                        <span style="color: white; font-size: 30px;">
                            <?= mb_substr($currentUser['ФИО'], 0, 1) ?>
                        </span>
                    </div>
                    <h2 style="color: var(--blue);"><?= htmlspecialchars($currentUser['ФИО']) ?></h2>
                </div>
                
                <table class="data-table" style="margin-bottom: 20px;">
                    <tbody>
                        <tr>
                            <td style="width: 30%; font-weight: bold;">Логин</td>
                            <td><?= htmlspecialchars($currentUser['Логин']) ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Роль</td>
                            <td>
                                <span style="display: inline-block; padding: 4px 8px; border-radius: 4px;
                                      background-color: <?= $currentUser['Роль'] == 'Администратор' ? 'var(--red)' : 'var(--blue)' ?>;
                                      color: white;">
                                    <?= htmlspecialchars($currentUser['Роль']) ?>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <div style="display: flex; gap: 10px;">
                    <a href="edit_profile.php" class="btn btn-primary">Редактировать профиль</a>
                    <a href="change_password.php" class="btn btn-edit">Сменить пароль</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
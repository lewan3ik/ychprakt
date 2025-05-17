<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?> - <?= $pageTitle ?? '' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="bg-primary text-white p-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="m-0"><?= APP_NAME ?></h1>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="d-flex align-items-center">
                        <span class="me-3">
                            <i class="fas fa-user me-1"></i>
                            <?= htmlspecialchars($_SESSION['user_name']) ?>
                            (<?= $_SESSION['user_role'] === 'admin' ? 'Администратор' : 'Преподаватель' ?>)
                        </span>
                        <a href="<?= BASE_URL ?>/logout.php" class="btn btn-outline-light">
                            <i class="fas fa-sign-out-alt me-1"></i> Выйти
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <main class="container my-4">
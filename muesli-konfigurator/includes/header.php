<?php require_once __DIR__ . '/../db.php'; ?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyMüsli Konfigurator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">🥣 CrazyMüsli</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="index.php">Start</a></li>
                <li class="nav-item"><a class="nav-link" href="configurator.php">Konfigurator</a></li>
                <?php if (isLoggedIn()): ?>
                    <li class="nav-item"><a class="nav-link" href="my_configs.php">Meine Mischungen</a></li>
                    <li class="nav-item"><span class="navbar-text text-white-50 small">Hallo, <?= e($_SESSION['user_name'] ?? 'User') ?></span></li>
                    <li class="nav-item"><a class="btn btn-light btn-sm" href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="register.php">Registrieren</a></li>
                    <li class="nav-item"><a class="btn btn-light btn-sm" href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<main class="py-4">

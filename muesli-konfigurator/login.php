<?php
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['first_name'];
        header('Location: configurator.php');
        exit;
    }

    $error = 'Login fehlgeschlagen. Bitte E-Mail und Passwort prüfen.';
}

include 'includes/header.php';
?>
<div class="container" style="max-width: 520px;">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h1 class="h3 mb-4">Login</h1>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= e($error) ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">E-Mail</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Passwort</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-success">Einloggen</button>
                <a href="register.php" class="btn btn-outline-secondary">Registrieren</a>
            </form>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>

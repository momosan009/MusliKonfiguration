<?php
require_once 'db.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $street = trim($_POST['street'] ?? '');
    $zipCode = trim($_POST['zip_code'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordRepeat = $_POST['password_repeat'] ?? '';

    if ($firstName === '' || $lastName === '' || $street === '' || $zipCode === '' || $city === '' || $email === '' || $password === '') {
        $errors[] = 'Bitte alle Pflichtfelder ausfüllen.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Bitte eine gültige E-Mail-Adresse eingeben.';
    }

    if (strlen($password) < 6) {
        $errors[] = 'Das Passwort muss mindestens 6 Zeichen lang sein.';
    }

    if ($password !== $passwordRepeat) {
        $errors[] = 'Die Passwörter stimmen nicht überein.';
    }

    if (!$errors) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $errors[] = 'Diese E-Mail-Adresse ist bereits registriert.';
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare('INSERT INTO users (first_name, last_name, street, zip_code, city, email, password_hash) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $insert->execute([$firstName, $lastName, $street, $zipCode, $city, $email, $passwordHash]);
            $success = 'Registrierung erfolgreich. Du kannst dich jetzt einloggen.';
        }
    }
}

include 'includes/header.php';
?>
<div class="container" style="max-width: 760px;">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h1 class="h3 mb-4">Registrierung</h1>

            <?php foreach ($errors as $error): ?>
                <div class="alert alert-danger"><?= e($error) ?></div>
            <?php endforeach; ?>

            <?php if ($success): ?>
                <div class="alert alert-success"><?= e($success) ?></div>
            <?php endif; ?>

            <form method="post" novalidate>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Vorname</label>
                        <input type="text" name="first_name" class="form-control" required value="<?= e($_POST['first_name'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nachname</label>
                        <input type="text" name="last_name" class="form-control" required value="<?= e($_POST['last_name'] ?? '') ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Straße / Hausnummer</label>
                        <input type="text" name="street" class="form-control" required value="<?= e($_POST['street'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">PLZ</label>
                        <input type="text" name="zip_code" class="form-control" required value="<?= e($_POST['zip_code'] ?? '') ?>">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Ort</label>
                        <input type="text" name="city" class="form-control" required value="<?= e($_POST['city'] ?? '') ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">E-Mail</label>
                        <input type="email" name="email" class="form-control" required value="<?= e($_POST['email'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Passwort</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Passwort wiederholen</label>
                        <input type="password" name="password_repeat" class="form-control" required>
                    </div>
                </div>
                <button class="btn btn-success mt-4">Konto erstellen</button>
                <a href="login.php" class="btn btn-outline-secondary mt-4">Zum Login</a>
            </form>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>

<?php
require_once 'db.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: configurator.php');
    exit;
}

$base = trim($_POST['base'] ?? '');
$ingredients = $_POST['ingredients'] ?? [];
$extras = $_POST['extras'] ?? [];
$labelText = trim($_POST['label_text'] ?? '');
$configName = trim($_POST['config_name'] ?? '');
$totalPrice = (float) ($_POST['total_price'] ?? 0);
$couponCode = trim($_POST['coupon_code'] ?? '');

if ($base === '') {
    $_SESSION['flash_error'] = 'Bitte zuerst eine Basis auswählen.';
    header('Location: configurator.php');
    exit;
}

if ($configName === '') {
    $configName = $labelText !== '' ? $labelText : 'Meine Mischung';
}

$stmt = $pdo->prepare('INSERT INTO configurations (user_id, config_name, base, ingredients, extras, label_text, total_price, coupon_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
$stmt->execute([
    $_SESSION['user_id'],
    $configName,
    $base,
    json_encode($ingredients, JSON_UNESCAPED_UNICODE),
    json_encode($extras, JSON_UNESCAPED_UNICODE),
    $labelText,
    $totalPrice,
    $couponCode,
]);

$_SESSION['flash_success'] = 'Deine Mischung wurde gespeichert.';
header('Location: my_configs.php');
exit;

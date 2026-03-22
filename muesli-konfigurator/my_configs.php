<?php
require_once 'db.php';
requireLogin();

$stmt = $pdo->prepare('SELECT * FROM configurations WHERE user_id = ? ORDER BY created_at DESC');
$stmt->execute([$_SESSION['user_id']]);
$configurations = $stmt->fetchAll();

include 'includes/header.php';
?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h1 class="h3 mb-0">Meine gespeicherten Mischungen</h1>
        <a href="configurator.php" class="btn btn-success">Neue Mischung erstellen</a>
    </div>

    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="alert alert-success"><?= e($_SESSION['flash_success']) ?></div>
        <?php unset($_SESSION['flash_success']); ?>
    <?php endif; ?>

    <?php if ($configurations): ?>
        <div class="row g-4">
            <?php foreach ($configurations as $config): ?>
                <div class="col-lg-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h2 class="h5"><?= e($config['config_name']) ?></h2>
                            <p class="text-muted small mb-3">Gespeichert am <?= e($config['created_at']) ?></p>
                            <p><strong>Basis:</strong> <?= e($config['base']) ?></p>
                            <p><strong>Zutaten:</strong> <?= e(implode(', ', json_decode($config['ingredients'], true) ?? [])) ?></p>
                            <p><strong>Extras:</strong> <?= e(implode(', ', json_decode($config['extras'], true) ?? [])) ?: 'Keine' ?></p>
                            <p><strong>Etikett:</strong> <?= e($config['label_text'] ?: 'Kein eigener Name') ?></p>
                            <p><strong>Gutscheincode:</strong> <?= e($config['coupon_code'] ?: 'Keiner') ?></p>
                            <div class="price-box">Preis: <?= number_format((float) $config['total_price'], 2, ',', '.') ?> €</div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Du hast noch keine gespeicherten Mischungen.</div>
    <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>

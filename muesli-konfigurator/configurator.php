<?php include 'includes/header.php'; ?>
<div class="container">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <h1 class="h3 mb-0">Müsli konfigurieren</h1>
                        <span class="badge text-bg-success">3 Schritte + Extras</span>
                    </div>

                    <div class="progress mb-4" role="progressbar" aria-label="Fortschritt">
                        <div id="progressBar" class="progress-bar bg-success" style="width: 33%">Schritt 1 von 3</div>
                    </div>

                    <div class="mb-4">
                        <label for="presetSelect" class="form-label fw-semibold">Vorkonfigurierte Mischung laden</label>
                        <select id="presetSelect" class="form-select">
                            <option value="">Bitte auswählen...</option>
                            <option value='{"name":"Sport Mix","base":"Protein-Mix","ingredients":["Banane","Chiasamen","Mandeln","Protein-Knusper","Leinsamen"],"extras":["Protein-Boost"],"label":"Sport Power"}'>Sport Mix</option>
                            <option value='{"name":"Frucht Mix","base":"Haferflocken","ingredients":["Erdbeeren","Apfel","Banane","Cranberries","Kokosraspeln"],"extras":["Bio-Upgrade"],"label":"Fruchtalarm"}'>Frucht Mix</option>
                            <option value='{"name":"Schoko Mix","base":"Schoko-Crunch","ingredients":["Schokodrops","Weiße Schokolade","Haselnüsse","Vanille-Crunch","Kokosraspeln"],"extras":["Extra große Packung"],"label":"Schokotraum"}'>Schoko Mix</option>
                        </select>
                    </div>

                    <form id="configForm" action="save_config.php" method="post">
                        <div class="step active" data-step="1">
                            <h2 class="h4">Schritt 1: Basis wählen</h2>
                            <p class="text-muted">Wähle genau eine Müslibasis.</p>
                            <div class="row g-3">
                                <?php
                                $bases = [
                                    ['Haferflocken', 2.00],
                                    ['Dinkelflakes', 2.20],
                                    ['Cornflakes', 2.10],
                                    ['Schoko-Crunch', 2.80],
                                    ['Protein-Mix', 3.20],
                                ];
                                foreach ($bases as [$name, $price]):
                                ?>
                                    <div class="col-md-6">
                                        <label class="option-card d-block p-3 h-100">
                                            <input class="form-check-input me-2 base-option" type="radio" name="base" value="<?= e($name) ?>" data-price="<?= $price ?>">
                                            <strong><?= e($name) ?></strong>
                                            <div class="text-muted small">Basispreis: <?= number_format($price, 2, ',', '.') ?> €</div>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="step" data-step="2">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div>
                                    <h2 class="h4">Schritt 2: Zutaten wählen</h2>
                                    <p class="text-muted mb-0">Mindestens 20 Wahlmöglichkeiten – du kannst beliebig viele auswählen.</p>
                                </div>
                                <div class="w-100 w-md-auto">
                                    <input type="text" id="ingredientSearch" class="form-control" placeholder="Zutaten suchen...">
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-2 my-3">
                                <button type="button" class="btn btn-outline-success btn-sm filter-btn active" data-filter="all">Alle</button>
                                <button type="button" class="btn btn-outline-success btn-sm filter-btn" data-filter="frucht">Fruchtig</button>
                                <button type="button" class="btn btn-outline-success btn-sm filter-btn" data-filter="nuss">Nussig</button>
                                <button type="button" class="btn btn-outline-success btn-sm filter-btn" data-filter="schoko">Schokoladig</button>
                                <button type="button" class="btn btn-outline-success btn-sm filter-btn" data-filter="samen">Samen & Kerne</button>
                            </div>
                            <div class="row g-3" id="ingredientGrid">
                                <?php
                                $ingredients = [
                                    ['Banane', 0.40, 'frucht'], ['Erdbeeren', 0.50, 'frucht'], ['Apfel', 0.40, 'frucht'], ['Rosinen', 0.30, 'frucht'], ['Cranberries', 0.50, 'frucht'],
                                    ['Kokosraspeln', 0.40, 'frucht'], ['Mandeln', 0.60, 'nuss'], ['Cashews', 0.70, 'nuss'], ['Walnüsse', 0.70, 'nuss'], ['Haselnüsse', 0.60, 'nuss'],
                                    ['Chiasamen', 0.50, 'samen'], ['Leinsamen', 0.40, 'samen'], ['Sonnenblumenkerne', 0.40, 'samen'], ['Kürbiskerne', 0.50, 'samen'], ['Schokodrops', 0.70, 'schoko'],
                                    ['Weiße Schokolade', 0.80, 'schoko'], ['Zimt', 0.30, 'schoko'], ['Honig-Crunch', 0.60, 'schoko'], ['Vanille-Crunch', 0.60, 'schoko'], ['Protein-Knusper', 0.80, 'samen'],
                                    ['Blaubeeren', 0.60, 'frucht'], ['Pistazien', 0.90, 'nuss'],
                                ];
                                foreach ($ingredients as [$name, $price, $category]):
                                ?>
                                <div class="col-md-6 ingredient-item" data-category="<?= e($category) ?>" data-name="<?= strtolower($name) ?>">
                                    <label class="option-card d-block p-3 h-100">
                                        <input class="form-check-input me-2 ingredient-option" type="checkbox" name="ingredients[]" value="<?= e($name) ?>" data-price="<?= $price ?>">
                                        <strong><?= e($name) ?></strong>
                                        <div class="text-muted small">+ <?= number_format($price, 2, ',', '.') ?> €</div>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="step" data-step="3">
                            <h2 class="h4">Schritt 3: Extras und Verpackung</h2>
                            <div class="row g-3 mb-3">
                                <?php
                                $extras = [
                                    ['Extra große Packung', 2.00],
                                    ['Geschenkverpackung', 1.50],
                                    ['Personalisiertes Etikett', 1.00],
                                    ['Bio-Upgrade', 1.20],
                                    ['Protein-Boost', 1.80],
                                ];
                                foreach ($extras as [$name, $price]):
                                ?>
                                    <div class="col-md-6">
                                        <label class="option-card d-block p-3 h-100">
                                            <input class="form-check-input me-2 extra-option" type="checkbox" name="extras[]" value="<?= e($name) ?>" data-price="<?= $price ?>">
                                            <strong><?= e($name) ?></strong>
                                            <div class="text-muted small">+ <?= number_format($price, 2, ',', '.') ?> €</div>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="mb-3">
                                <label for="labelText" class="form-label">Name auf dem Etikett</label>
                                <input type="text" id="labelText" name="label_text" class="form-control" maxlength="120" placeholder="z. B. Max' Fitness Müsli">
                            </div>
                            <div class="mb-3">
                                <label for="couponCode" class="form-label">Gutscheincode</label>
                                <div class="input-group">
                                    <input type="text" id="couponCode" class="form-control" placeholder="z. B. MUESLI10">
                                    <button type="button" id="applyCoupon" class="btn btn-outline-success">Code anwenden</button>
                                </div>
                                <div id="couponMessage" class="small mt-2"></div>
                            </div>
                        </div>

                        <input type="hidden" name="config_name" id="configName">
                        <input type="hidden" name="total_price" id="totalPriceInput">
                        <input type="hidden" name="coupon_code" id="couponCodeInput">

                        <div class="d-flex justify-content-between mt-4 flex-wrap gap-2">
                            <button type="button" id="prevBtn" class="btn btn-outline-secondary" disabled>Zurück</button>
                            <div class="d-flex gap-2">
                                <button type="button" id="nextBtn" class="btn btn-success">Weiter</button>
                                <button type="submit" id="saveBtn" class="btn btn-primary d-none">Speichern</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-summary">
                <div class="card-body p-4">
                    <h2 class="h4">Deine Crazy Bowl 🥣 </h2>
                    <div class="bowl-preview my-3">
                        <div class="bowl-inner">
                            <div id="previewLabel" class="preview-label">Dein Müsli</div>
                            <div id="previewTags" class="preview-tags"></div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item px-0"><strong>Basis:</strong> <span id="summaryBase">Noch nicht gewählt</span></li>
                        <li class="list-group-item px-0"><strong>Zutaten:</strong> <span id="summaryIngredients">Keine</span></li>
                        <li class="list-group-item px-0"><strong>Extras:</strong> <span id="summaryExtras">Keine</span></li>
                        <li class="list-group-item px-0"><strong>Rabatt:</strong> <span id="summaryDiscount">0,00 €</span></li>
                    </ul>
                    <div class="d-grid gap-2">
                        <div class="price-box">Gesamtpreis: <span id="summaryPrice">0,00 €</span></div>
                        <button id="orderBtn" type="button" class="btn btn-warning">Jetzt bestellen</button>
                        <small class="text-muted">Das Beste dran? Du musst nicht wirklich bezahlen!</small>
                    </div>
                    <?php if (!isLoggedIn()): ?>
                        <div class="alert alert-info mt-3 mb-0 small">Log dich ein und speichere deine lieblings Müslikonfigurationen!</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.isLoggedIn = <?= isLoggedIn() ? 'true' : 'false' ?>;
</script>
<script src="assets/js/configurator.js"></script>
<?php include 'includes/footer.php'; ?>

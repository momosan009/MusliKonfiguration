<?php include 'includes/header.php'; ?>
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <span class="badge bg-warning text-dark mb-3">Individuell · Schnell · Lecker</span>
                <h1 class="display-5 fw-bold mb-3">Stelle dir dein persönliches Lieblingsmüsli zusammen.</h1>
                <p class="lead">Wähle Basis, Zutaten und Extras in mehreren Schritten und sieh sofort, wie sich deine Mischung und der Preis verändern.</p>
                <p>Registrierte Nutzer können ihre Konfiguration speichern und später erneut laden oder anpassen.</p>
                <div class="d-flex flex-wrap gap-2 mt-4">
                    <a class="btn btn-success btn-lg" href="configurator.php">Jetzt konfigurieren</a>
                    <a class="btn btn-outline-success btn-lg" href="register.php">Registrieren</a>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="assets/images/Homepage.svg" class="img-fluid rounded-4 shadow" alt="Müsli Hero Bild">
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-card h-100">
                <img src="assets/images/Konfigurieren.png" class="img-fluid rounded-3 mb-3" alt="Müsli Schüssel 1">
                <h3 class="h5">Suche dir deine Zutaten Selbst!</h3>
                <p>Sei Crazy! Suche dir deine Lieblingszutaten und Extras nacheinander und erstelle deine perfekte Müsliekonfiguration.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card h-100">
                <img src="assets/images/LiveVorschau.png" class="img-fluid rounded-3 mb-3" alt="Müsli Schüssel 2">
                <h3 class="h5">Gucke dir deine Mischung dabei an 🥣</h3>
                <p>Du bekommst eine visuelle Darstellung mit farbigen Zutaten-Tags und Schüssel-Preview von deinem Crazy Bowl!</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card h-100">
                <img src="assets/images/Saved.png" class="img-fluid rounded-3 mb-3" alt="Müsli Schüssel 3">
                <h3 class="h5">Speichere deine Müsliekonfiguration</h3>
                <p>Eingeloggte Nutzer können ihre Mischungspeichern und später erneut aufrufen. Easy Peasy!</p>
            </div>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>

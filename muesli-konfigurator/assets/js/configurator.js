document.addEventListener('DOMContentLoaded', () => {
    const steps = [...document.querySelectorAll('.step')];
    const progressBar = document.getElementById('progressBar');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const saveBtn = document.getElementById('saveBtn');
    const configForm = document.getElementById('configForm');

    if (!configForm) return;

    let currentStep = 0;
    let discount = 0;
    let activeCoupon = '';

    const presetSelect = document.getElementById('presetSelect');
    const searchInput = document.getElementById('ingredientSearch');
    const filterButtons = [...document.querySelectorAll('.filter-btn')];
    const ingredientItems = [...document.querySelectorAll('.ingredient-item')];
    const couponCode = document.getElementById('couponCode');
    const couponCodeInput = document.getElementById('couponCodeInput');
    const couponMessage = document.getElementById('couponMessage');
    const orderBtn = document.getElementById('orderBtn');
    const labelText = document.getElementById('labelText');
    const configName = document.getElementById('configName');
    const totalPriceInput = document.getElementById('totalPriceInput');

    function showStep(index) {
        steps.forEach((step, i) => step.classList.toggle('active', i === index));
        currentStep = index;
        prevBtn.disabled = index === 0;

        const isLast = index === steps.length - 1;
        nextBtn.classList.toggle('d-none', isLast);
        saveBtn.classList.toggle('d-none', !isLast);
        saveBtn.disabled = !window.isLoggedIn;
        saveBtn.textContent = window.isLoggedIn ? 'Speichern' : 'Zum Speichern einloggen';

        const progress = ((index + 1) / steps.length) * 100;
        progressBar.style.width = `${progress}%`;
        progressBar.textContent = `Schritt ${index + 1} von ${steps.length}`;
    }

    function getSelectedBase() {
        return document.querySelector('.base-option:checked');
    }

    function getChecked(selector) {
        return [...document.querySelectorAll(selector + ':checked')];
    }

    function formatPrice(value) {
        return value.toFixed(2).replace('.', ',') + ' €';
    }

    function calculateTotal() {
        let total = 0;
        const base = getSelectedBase();
        if (base) total += Number(base.dataset.price);

        getChecked('.ingredient-option').forEach(item => total += Number(item.dataset.price));
        getChecked('.extra-option').forEach(item => total += Number(item.dataset.price));

        const subtotal = total;

        if (activeCoupon === 'MUESLI10') {
            discount = subtotal * 0.10;
        } else if (activeCoupon === 'START5' && subtotal >= 20) {
            discount = 5;
        } else {
            discount = 0;
        }

        total = Math.max(0, subtotal - discount);
        totalPriceInput.value = total.toFixed(2);

        document.getElementById('summaryDiscount').textContent = formatPrice(discount);
        document.getElementById('summaryPrice').textContent = formatPrice(total);
    }

    function updateSummary() {
        const base = getSelectedBase();
        const ingredients = getChecked('.ingredient-option').map(el => el.value);
        const extras = getChecked('.extra-option').map(el => el.value);
        const label = labelText.value.trim();

        document.getElementById('summaryBase').textContent = base ? base.value : 'Noch nicht gewählt';
        document.getElementById('summaryIngredients').textContent = ingredients.length ? ingredients.join(', ') : 'Keine';
        document.getElementById('summaryExtras').textContent = extras.length ? extras.join(', ') : 'Keine';
        document.getElementById('previewLabel').textContent = label || 'Dein Müsli';

        const tags = [];
        if (base) tags.push(`<span class="tag tag-base">${base.value}</span>`);
        ingredients.forEach(item => tags.push(`<span class="tag tag-ingredient">${item}</span>`));
        extras.forEach(item => tags.push(`<span class="tag tag-extra">${item}</span>`));
        document.getElementById('previewTags').innerHTML = tags.length ? tags.join('') : '<span class="text-muted">Noch keine Zutaten gewählt</span>';

        configName.value = label || (base ? `${base.value} Spezial` : 'Meine Mischung');
        calculateTotal();
    }

    function validateCurrentStep() {
        if (currentStep === 0 && !getSelectedBase()) {
            alert('Bitte wähle zuerst eine Basis aus.');
            return false;
        }
        return true;
    }

    nextBtn.addEventListener('click', () => {
        if (!validateCurrentStep()) return;
        if (currentStep < steps.length - 1) {
            showStep(currentStep + 1);
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentStep > 0) {
            showStep(currentStep - 1);
        }
    });

    configForm.addEventListener('change', updateSummary);
    labelText.addEventListener('input', updateSummary);

    document.getElementById('applyCoupon').addEventListener('click', () => {
        const code = couponCode.value.trim().toUpperCase();
        activeCoupon = '';

        if (code === 'MUESLI10') {
            activeCoupon = code;
            couponMessage.textContent = '10 % Rabatt wurde angewendet.';
            couponMessage.className = 'small mt-2 text-success';
        } else if (code === 'START5') {
            activeCoupon = code;
            couponMessage.textContent = '5 € Rabatt ab 20 € Warenwert.';
            couponMessage.className = 'small mt-2 text-success';
        } else if (code !== '') {
            couponMessage.textContent = 'Ungültiger Gutscheincode.';
            couponMessage.className = 'small mt-2 text-danger';
        } else {
            couponMessage.textContent = 'Kein Gutscheincode eingegeben.';
            couponMessage.className = 'small mt-2 text-muted';
        }

        couponCodeInput.value = activeCoupon;
        updateSummary();
    });

    presetSelect.addEventListener('change', () => {
        if (!presetSelect.value) return;
        const preset = JSON.parse(presetSelect.value);

        document.querySelectorAll('.base-option').forEach(input => {
            input.checked = input.value === preset.base;
        });

        document.querySelectorAll('.ingredient-option').forEach(input => {
            input.checked = preset.ingredients.includes(input.value);
        });

        document.querySelectorAll('.extra-option').forEach(input => {
            input.checked = preset.extras.includes(input.value);
        });

        labelText.value = preset.label || preset.name;
        updateSummary();
    });

    let activeFilter = 'all';

    function applyIngredientFilter() {
        const search = searchInput.value.trim().toLowerCase();
        ingredientItems.forEach(item => {
            const matchesCategory = activeFilter === 'all' || item.dataset.category === activeFilter;
            const matchesSearch = item.dataset.name.includes(search);
            item.style.display = matchesCategory && matchesSearch ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', applyIngredientFilter);
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(button => button.classList.remove('active'));
            btn.classList.add('active');
            activeFilter = btn.dataset.filter;
            applyIngredientFilter();
        });
    });

    orderBtn.addEventListener('click', () => {
        alert('Demo: Hier würde später der Bestellprozess starten.');
    });

    configForm.addEventListener('submit', (event) => {
        updateSummary();
        if (!window.isLoggedIn) {
            event.preventDefault();
            alert('Bitte zuerst einloggen, um die Konfiguration zu speichern.');
        }
    });

    updateSummary();
    showStep(0);
});

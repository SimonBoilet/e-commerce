<!-- ══ MAIN ════════════════════════════════════════════════════════ -->

<section style="padding: 8rem 0 4rem; background: var(--night); min-height: 70vh; display:flex; align-items:center; position:relative; overflow:hidden;">

    <!-- Glow background -->
    <div style="position:absolute; inset:0;
                background: radial-gradient(ellipse 50% 60% at 50% 50%, rgba(200,255,0,.05) 0%, transparent 65%);
                pointer-events:none;" aria-hidden="true"></div>

    <div class="container position-relative text-center">

        <!-- Icône cadenas animée -->
        <div style="font-size:2.5rem; color:var(--volt); margin-bottom:1.2rem; animation: fadeUp .6s ease forwards;"
             aria-hidden="true">
            <i class="bi bi-lock-fill"></i>
        </div>

        <p class="section-label" style="justify-content:center;">Paiement sécurisé</p>

        <h1 style="font-family:var(--font-display); font-size:clamp(2rem,5vw,4rem); line-height:1; margin:.4rem 0 .6rem;">
            REDIRECTION EN COURS<span class="volt-text">...</span>
        </h1>

        <p style="color:var(--muted); font-size:.9rem; max-width:440px; margin:0 auto 2rem;">
            Vous allez être redirigé vers la plateforme de paiement sécurisée du
            <strong style="color:var(--white);">Crédit Agricole Up2Pay</strong>.
            Ne fermez pas cette page.
        </p>

        <!-- Indicateur de chargement -->
        <div style="display:flex; justify-content:center; gap:.5rem; margin-bottom:2.5rem;" aria-label="Chargement en cours">
            <span class="dot-pulse"></span>
            <span class="dot-pulse" style="animation-delay:.18s;"></span>
            <span class="dot-pulse" style="animation-delay:.36s;"></span>
        </div>

        <!-- Récap commande -->
        <div style="display:inline-flex; gap:2.5rem; background:var(--card-bg); border:1px solid var(--border);
                    border-radius:4px; padding:1rem 2rem; margin-bottom:2rem; flex-wrap:wrap; justify-content:center;">
            <div>
                <div style="font-size:.62rem; letter-spacing:.2em; text-transform:uppercase; color:var(--muted);">Référence</div>
                <div style="font-family:var(--font-display); font-size:1rem; color:var(--white); letter-spacing:.08em;">
                    <?php echo htmlspecialchars($paiement_data['PBX_CMD']); ?>
                </div>
            </div>
            <div style="width:1px; background:var(--border);" aria-hidden="true"></div>
            <div>
                <div style="font-size:.62rem; letter-spacing:.2em; text-transform:uppercase; color:var(--muted);">Montant TTC</div>
                <div style="font-family:var(--font-display); font-size:1.3rem; color:var(--volt);">
                    <?php echo number_format((int)$paiement_data['PBX_TOTAL'] / 100, 2, ',', ' '); ?>€
                </div>
            </div>
            <div style="width:1px; background:var(--border);" aria-hidden="true"></div>
            <div>
                <div style="font-size:.62rem; letter-spacing:.2em; text-transform:uppercase; color:var(--muted);">Devise</div>
                <div style="font-family:var(--font-display); font-size:1rem; color:var(--white);">EUR</div>
            </div>
        </div>

        <!-- Formulaire caché auto-submit -->
        <form id="form-paiement"
              method="POST"
              action="<?php echo htmlspecialchars($paiement_data['url_paiement']); ?>">

            <?php foreach ($paiement_data as $key => $value) : ?>
                <?php if ($key === 'url_paiement') continue; ?>
                <input type="hidden"
                       name="<?php echo htmlspecialchars($key); ?>"
                       value="<?php echo htmlspecialchars($value); ?>" />
            <?php endforeach; ?>

            <!-- Bouton de secours si JS désactivé -->
            <noscript>
                <button type="submit" class="btn btn-volt" style="margin-top:1rem;">
                    <i class="bi bi-lock-fill me-2"></i>
                    Accéder au paiement sécurisé
                </button>
            </noscript>
        </form>

        <!-- Badges sécurité -->
        <div style="display:flex; justify-content:center; gap:1.5rem; flex-wrap:wrap; margin-top:1.5rem;">
            <span style="font-size:.72rem; color:var(--muted); display:flex; align-items:center; gap:.4rem;">
                <i class="bi bi-shield-lock-fill" style="color:var(--volt);"></i>
                Connexion SSL 256-bit
            </span>
            <span style="font-size:.72rem; color:var(--muted); display:flex; align-items:center; gap:.4rem;">
                <i class="bi bi-bank" style="color:var(--volt);"></i>
                Crédit Agricole Up2Pay
            </span>
            <span style="font-size:.72rem; color:var(--muted); display:flex; align-items:center; gap:.4rem;">
                <i class="bi bi-credit-card-fill" style="color:var(--volt);"></i>
                3D Secure
            </span>
        </div>

    </div>
</section>

<style>
    .dot-pulse {
        width: 9px; height: 9px;
        background: var(--volt);
        border-radius: 50%;
        display: inline-block;
        animation: dotPulse 1.3s ease-in-out infinite;
    }
    @keyframes dotPulse {
        0%, 100% { transform: scale(.55); opacity: .35; }
        50%       { transform: scale(1.2); opacity: 1; }
    }
</style>

<script>
    // Auto-submit dès que la page est prête
    window.addEventListener('load', function () {
        document.getElementById('form-paiement').submit();
    });
</script>
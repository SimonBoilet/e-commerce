<!-- ══ MAIN ════════════════════════════════════════════════════════ -->

<?php
$statut  = $retour_data['statut'];
$ref     = $retour_data['ref']     ?? '—';
$montant = $retour_data['montant'] ?? null;
$montant_fmt = $montant ? number_format((int)$montant / 100, 2, ',', ' ') . '€' : '—';

/* ── Config selon statut ── */
$config = match($statut) {
    'ok'     => [
        'icon'       => 'bi-check-circle-fill',
        'icon_color' => '#C8FF00',
        'titre'      => 'PAIEMENT ACCEPTÉ',
        'sous_titre' => 'Votre commande est confirmée.',
        'message'    => 'Merci pour votre achat. Vous recevrez une confirmation par e-mail dans quelques instants.',
        'bg_glow'    => 'rgba(200,255,0,.07)',
        'btn_label'  => 'Retour à l\'accueil',
        'btn_url'    => '/',
        'btn_icon'   => 'bi-house',
    ],
    'annule' => [
        'icon'       => 'bi-x-circle-fill',
        'icon_color' => '#FFB347',
        'titre'      => 'PAIEMENT ANNULÉ',
        'sous_titre' => 'Votre paiement a été annulé.',
        'message'    => 'Vous avez annulé la transaction. Votre panier a été conservé, vous pouvez relancer un paiement à tout moment.',
        'bg_glow'    => 'rgba(255,179,71,.06)',
        'btn_label'  => 'Retour au panier',
        'btn_url'    => '/panier/',
        'btn_icon'   => 'bi-bag',
    ],
    default  => [
        'icon'       => 'bi-slash-circle-fill',
        'icon_color' => '#FF4444',
        'titre'      => 'PAIEMENT REFUSÉ',
        'sous_titre' => 'Votre paiement n\'a pas abouti.',
        'message'    => 'La transaction a été refusée par votre banque. Vérifiez vos informations bancaires et réessayez, ou contactez votre conseiller.',
        'bg_glow'    => 'rgba(255,68,68,.06)',
        'btn_label'  => 'Réessayer',
        'btn_url'    => '/paiement/',
        'btn_icon'   => 'bi-arrow-clockwise',
    ],
};
?>

<section style="padding:8rem 0 5rem; background:var(--night); min-height:70vh;
                display:flex; align-items:center; position:relative; overflow:hidden;">

    <div style="position:absolute; inset:0;
        background: radial-gradient(ellipse 50% 60% at 50% 40%,
    <?php echo $config['bg_glow']; ?> 0%, transparent 65%);
        pointer-events:none;" aria-hidden="true"></div>

    <div class="container position-relative text-center">

        <!-- Icône statut -->
        <div style="font-size:3.5rem; color:<?php echo $config['icon_color']; ?>;
            margin-bottom:1.2rem; animation:fadeUp .5s ease forwards;"
             aria-hidden="true">
            <i class="bi <?php echo $config['icon']; ?>"></i>
        </div>

        <!-- Titre -->
        <h1 style="font-family:var(--font-display); font-size:clamp(2.2rem,6vw,4.5rem);
                   line-height:1; margin-bottom:.6rem; animation:fadeUp .6s ease .1s both;">
            <?php echo $config['titre']; ?>
        </h1>

        <!-- Sous-titre -->
        <p style="font-size:1rem; color:var(--muted); margin-bottom:2rem;
                  animation:fadeUp .6s ease .2s both;">
            <?php echo $config['sous_titre']; ?>
        </p>

        <!-- Récap transaction -->
        <div style="display:inline-flex; gap:2.5rem; background:var(--card-bg);
                    border:1px solid var(--border); border-radius:4px;
                    padding:1.2rem 2rem; margin-bottom:2rem; flex-wrap:wrap;
                    justify-content:center; animation:fadeUp .6s ease .3s both;">
            <div>
                <div style="font-size:.6rem; letter-spacing:.22em; text-transform:uppercase; color:var(--muted);">
                    Référence
                </div>
                <div style="font-family:var(--font-display); font-size:1rem;
                            color:var(--white); letter-spacing:.06em; margin-top:.2rem;">
                    <?php echo htmlspecialchars($ref); ?>
                </div>
            </div>
            <?php if ($montant) : ?>
                <div style="width:1px; background:var(--border);" aria-hidden="true"></div>
                <div>
                    <div style="font-size:.6rem; letter-spacing:.22em; text-transform:uppercase; color:var(--muted);">
                        Montant
                    </div>
                    <div style="font-family:var(--font-display); font-size:1.3rem;
                        color:<?php echo $config['icon_color']; ?>; margin-top:.2rem;">
                        <?php echo $montant_fmt; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div style="width:1px; background:var(--border);" aria-hidden="true"></div>
            <div>
                <div style="font-size:.6rem; letter-spacing:.22em; text-transform:uppercase; color:var(--muted);">
                    Statut
                </div>
                <div style="font-size:.8rem; font-weight:700; letter-spacing:.1em;
                    text-transform:uppercase; color:<?php echo $config['icon_color']; ?>;
                    margin-top:.3rem; border:1px solid <?php echo $config['icon_color']; ?>33;
                    padding:.15rem .6rem; border-radius:2px;">
                    <?php echo strtoupper($statut); ?>
                </div>
            </div>
        </div>

        <!-- Message explicatif -->
        <p style="color:var(--muted); font-size:.88rem; max-width:460px;
                  margin:0 auto 2.5rem; line-height:1.8;
                  animation:fadeUp .6s ease .4s both;">
            <?php echo $config['message']; ?>
        </p>

        <!-- CTAs -->
        <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;
                    animation:fadeUp .6s ease .5s both;">
            <a href="<?php echo $config['btn_url']; ?>" class="btn btn-volt">
                <i class="bi <?php echo $config['btn_icon']; ?> me-2"></i>
                <?php echo $config['btn_label']; ?>
            </a>
            <?php if ($statut === 'ok') : ?>
                <a href="/produit/" class="btn btn-outline-volt">
                    <i class="bi bi-grid me-1"></i> Continuer mes achats
                </a>
            <?php endif; ?>
        </div>

    </div>
</section>
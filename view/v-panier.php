<!-- ══ MAIN ════════════════════════════════════════════════════════ -->

<?php
/* ── Variables disponibles depuis c-panier.php ──
 *  $panier        : array  → nb_lignes, nb_articles, total_ht, total_ttc
 *  $lignes_panier : PDOStatement → lignes du panier
 *  $idPanier      : int
 */
$panier_vide = empty($panier['nb_lignes']) || (int)$panier['nb_lignes'] === 0;
?>

<!-- ── BREADCRUMB ─────────────────────────────────────────────────── -->
<nav aria-label="Fil d'Ariane" style="padding: 6.5rem 0 0; background: var(--night);">
    <div class="container">
        <ol class="breadcrumb-volt">
            <li><a href="/">Accueil</a></li>
            <li aria-hidden="true"><i class="bi bi-chevron-right"></i></li>
            <li aria-current="page">Mon panier</li>
        </ol>
    </div>
</nav>

<!-- ── PAGE HERO ──────────────────────────────────────────────────── -->
<section style="padding: 2rem 0 3rem; background: var(--night); position: relative; overflow: hidden;">
    <div style="position:absolute; inset:0;
                background: radial-gradient(ellipse 50% 60% at 80% 50%, rgba(200,255,0,.05) 0%, transparent 65%);
                pointer-events:none;" aria-hidden="true"></div>
    <div class="container position-relative">
        <p class="section-label">Mon espace</p>
        <h1 style="font-family:var(--font-display); font-size:clamp(2.5rem,7vw,5.5rem); line-height:1; margin:0;">
            MON <span class="volt-text">PANIER</span>
        </h1>
        <?php if (!$panier_vide) : ?>
            <p style="color:var(--muted); font-size:.88rem; margin-top:.6rem;">
                <?php echo (int)$panier['nb_articles']; ?> article<?php echo (int)$panier['nb_articles'] > 1 ? 's' : ''; ?>
                · <?php echo number_format((float)$panier['total_ttc'], 2, ',', ' '); ?>€ TTC
            </p>
        <?php endif; ?>
    </div>
</section>

<!-- ══ CONTENU PANIER ════════════════════════════════════════════════ -->
<section style="padding: 3rem 0 6rem; background: var(--night);">
    <div class="container">

        <?php if ($panier_vide) : ?>
            <!-- ── PANIER VIDE ── -->
            <div class="panier-vide">
                <div class="panier-vide-icon" aria-hidden="true">
                    <i class="bi bi-bag"></i>
                </div>
                <h2 style="font-family:var(--font-display); font-size:2rem; margin-bottom:.5rem;">
                    VOTRE PANIER EST VIDE
                </h2>
                <p style="color:var(--muted); font-size:.9rem; margin-bottom:2rem;">
                    Parcourez notre gamme et trouvez votre prochain boost.
                </p>
                <a href="/produit/" class="btn btn-volt">
                    <i class="bi bi-arrow-left me-2"></i> Découvrir la gamme
                </a>
            </div>

        <?php else : ?>
            <!-- ── PANIER AVEC ARTICLES ── -->
            <div class="row g-5 align-items-start">

                <!-- ── COL GAUCHE : Lignes ── -->
                <div class="col-lg-8">

                    <!-- En-tête colonnes -->
                    <div class="panier-header d-none d-md-grid">
                        <span>Produit</span>
                        <span class="text-center">Quantité</span>
                        <span class="text-end">Prix HT</span>
                        <span class="text-end">Total TTC</span>
                        <span></span>
                    </div>

                    <!-- Lignes produits -->
                    <?php while ($ligne = $lignes_panier->fetch(PDO::FETCH_ASSOC)) :

                        /* Première image */
                        $imgs    = array_values(array_filter(array_map('trim', explode(',', $ligne['image'] ?? ''))));
                        $img_src = $imgs[0] ?? '';
                        $has_img = !empty($img_src);

                        /* Accent couleur */
                        $sid    = $ligne['identifiant'] ?? '';
                        $accent = '#C8FF00';
                        if (str_contains($sid,'dark-forest')) $accent='#8B5CF6';
                        if (str_contains($sid,'arctic'))      $accent='#00C8FF';
                        if (str_contains($sid,'red-storm'))   $accent='#FF4444';
                        if (str_contains($sid,'tropical'))    $accent='#FF9500';
                        if (str_contains($sid,'midnight'))    $accent='#4A90D9';
                        if (str_contains($sid,'berry'))       $accent='#E040FB';
                        if (str_contains($sid,'peach'))       $accent='#FFB347';
                        if (str_contains($sid,'yuzu'))        $accent='#FFD700';
                        if (str_contains($sid,'hydro'))       $accent='#00E5FF';

                        $taux    = (float)($ligne['taux_tva'] ?? 20);
                        $ttc_u   = $ligne['prix_ht'] * (1 + $taux / 100);
                        $ttc_tot = $ttc_u * $ligne['quantite'];
                        $ht_tot  = $ligne['prix_ht'] * $ligne['quantite'];  // ← ajoute cette ligne
                        ?>

                        <div class="panier-ligne" style="--accent: <?php echo $accent; ?>;" aria-label="<?php echo htmlspecialchars($ligne['nom']); ?>">

                            <!-- Image -->
                            <div class="panier-ligne-img">
                                <?php if ($has_img) : ?>
                                    <img src="<?php echo htmlspecialchars($img_src); ?>"
                                         alt="<?php echo htmlspecialchars($ligne['nom']); ?>" />
                                <?php else : ?>
                                    <svg width="60" height="100" viewBox="0 0 60 100" aria-hidden="true">
                                        <rect x="5" y="5" width="50" height="90" rx="8" fill="#1a1f2e"/>
                                        <rect x="5" y="42" width="50" height="3" fill="<?php echo $accent; ?>"/>
                                        <text x="30" y="32" font-family="'Bebas Neue'" font-size="9" fill="#F4F6F8" text-anchor="middle">VOLTEX</text>
                                        <path d="M24 55 L29 47 L29 52 L36 52 L31 60 L31 55Z" fill="<?php echo $accent; ?>"/>
                                    </svg>
                                <?php endif; ?>
                            </div>

                            <!-- Nom + identifiant -->
                            <div class="panier-ligne-info">
                                <a href="/produit/id/=<?php echo htmlspecialchars($sid); ?>"
                                   class="panier-ligne-nom">
                                    <?php echo htmlspecialchars($ligne['nom']); ?>
                                </a>
                                <span class="panier-ligne-ref"><?php echo htmlspecialchars($sid); ?></span>
                                <span class="panier-ligne-prix-unit d-md-none">
                            <?php echo number_format($ttc_u, 2, ',', ' '); ?>€ TTC / unité
                        </span>
                            </div>

                            <!-- Quantité -->
                            <form method="POST" action="/panier/" class="panier-ligne-qty">
                                <input type="hidden" name="action"   value="modifier" />
                                <input type="hidden" name="id_ligne" value="<?php echo (int)$ligne['id_ligne']; ?>" />
                                <div class="qty-wrap">
                                    <button type="button" class="qty-btn qty-minus" aria-label="Diminuer">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number" name="quantite" class="qty-input"
                                           value="<?php echo (int)$ligne['quantite']; ?>"
                                           min="1" max="99"
                                           aria-label="Quantité" />
                                    <button type="button" class="qty-btn qty-plus" aria-label="Augmenter">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                                <button type="submit" class="qty-update-btn" aria-label="Mettre à jour">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </form>

                            <!-- Prix HT -->
                            <div class="panier-ligne-prix text-end d-none d-md-block">
                                <span><?php echo number_format($ht_tot, 2, ',', ' '); ?>€</span>
                                <small>HT</small>
                            </div>

                            <!-- Total TTC -->
                            <div class="panier-ligne-total text-end">
                                <?php echo number_format($ttc_tot, 2, ',', ' '); ?>€
                                <small>TTC</small>
                            </div>

                            <!-- Supprimer -->
                            <form method="POST" action="/panier/" class="panier-ligne-del">
                                <input type="hidden" name="action"   value="supprimer" />
                                <input type="hidden" name="id_ligne" value="<?php echo (int)$ligne['id_ligne']; ?>" />
                                <button type="submit" class="btn-del" aria-label="Supprimer <?php echo htmlspecialchars($ligne['nom']); ?>">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>

                        </div>

                    <?php endwhile; ?>

                    <!-- Actions bas de liste -->
                    <div class="panier-actions-bas d-flex align-items-center justify-content-between flex-wrap gap-3 mt-4">
                        <a href="/porudit/" class="btn btn-outline-volt btn-sm-volt">
                            <i class="bi bi-arrow-left me-1"></i> Continuer mes achats
                        </a>
                        <form method="POST" action="/panier/">
                            <input type="hidden" name="action" value="vider" />
                            <button type="submit" class="btn-vider"
                                    onclick="return confirm('Vider le panier ?')">
                                <i class="bi bi-trash3 me-1"></i> Vider le panier
                            </button>
                        </form>
                    </div>

                </div>

                <!-- ── COL DROITE : Récapitulatif ── -->
                <div class="col-lg-4">
                    <div class="panier-recap">

                        <h2 style="font-family:var(--font-display); font-size:1.6rem; letter-spacing:.05em; margin-bottom:1.5rem;">
                            RÉCAPITULATIF
                        </h2>

                        <!-- Détail des montants -->
                        <div class="recap-row">
                            <span>Sous-total HT</span>
                            <span><?php echo number_format((float)$panier['total_ht'], 2, ',', ' '); ?>€</span>
                        </div>
                        <div class="recap-row">
                            <span>TVA</span>
                            <span><?php echo number_format((float)$panier['total_ttc'] - (float)$panier['total_ht'], 2, ',', ' '); ?>€</span>
                        </div>
                        <div class="recap-row">
                            <span>Livraison</span>
                            <span style="color:var(--volt);">
                            <?php echo (float)$panier['total_ttc'] >= 50 ? 'Offerte' : '4,90€'; ?>
                        </span>
                        </div>

                        <?php if ((float)$panier['total_ttc'] < 50) : ?>
                            <div class="recap-livraison-bar">
                                <?php
                                $progress = min(100, ((float)$panier['total_ttc'] / 50) * 100);
                                $restant  = 50 - (float)$panier['total_ttc'];
                                ?>
                                <div class="bar-track">
                                    <div class="bar-fill" style="width: <?php echo round($progress); ?>%;"></div>
                                </div>
                                <p style="font-size:.72rem; color:var(--muted); margin-top:.4rem; text-align:center;">
                                    Plus que <strong style="color:var(--volt);"><?php echo number_format($restant, 2, ',', ' '); ?>€</strong>
                                    pour la livraison offerte
                                </p>
                            </div>
                        <?php else : ?>
                            <div class="recap-livraison-ok">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                Vous bénéficiez de la livraison offerte !
                            </div>
                        <?php endif; ?>

                        <div class="recap-total">
                            <span>Total TTC</span>
                            <span>
                            <?php
                            $total_final = (float)$panier['total_ttc'];
                            if ($total_final < 50) $total_final += 4.90;
                            echo number_format($total_final, 2, ',', ' ');
                            ?>€
                        </span>
                        </div>

                        <!-- CTA commander -->
                        <a href="/commande/" class="btn btn-volt w-100 mt-3"
                           style="justify-content:center; display:flex; gap:.6rem; align-items:center; padding:.95rem;">
                            <i class="bi bi-arrow-right"></i>
                            Valider la commande
                        </a>

                        <!-- Garanties -->
                        <div class="recap-garanties">
                            <div class="garantie-item"><i class="bi bi-lock-fill"></i><span>Paiement sécurisé SSL</span></div>
                            <div class="garantie-item"><i class="bi bi-arrow-counterclockwise"></i><span>Retour 30 jours</span></div>
                            <div class="garantie-item"><i class="bi bi-shield-check"></i><span>ISO 22000 certifié</span></div>
                        </div>

                    </div>
                </div>

            </div>
        <?php endif; ?>

    </div>
</section>

<!-- ══ STYLES ════════════════════════════════════════════════════ -->
<style>
    /* Breadcrumb */
    .breadcrumb-volt { display:flex; align-items:center; gap:.5rem; list-style:none; margin:0; padding:0; font-size:.75rem; color:var(--muted); }
    .breadcrumb-volt a { color:var(--muted); text-decoration:none; transition:color var(--transition); }
    .breadcrumb-volt a:hover { color:var(--volt); }
    .breadcrumb-volt li:last-child { color:var(--white); }
    .breadcrumb-volt i { font-size:.6rem; }

    /* Panier vide */
    .panier-vide { text-align:center; padding:6rem 0; }
    .panier-vide-icon { font-size:4rem; color:var(--muted); margin-bottom:1.5rem; opacity:.4; }

    /* Header colonnes */
    .panier-header {
        display:grid;
        grid-template-columns: 80px 1fr 120px 110px 110px 40px;
        gap:1rem;
        padding:.6rem 1rem;
        font-size:.62rem;
        font-weight:700;
        letter-spacing:.18em;
        text-transform:uppercase;
        color:var(--muted);
        border-bottom:1px solid var(--border);
        margin-bottom:.5rem;
    }

    /* Ligne produit */
    .panier-ligne {
        display:grid;
        grid-template-columns: 80px 1fr auto auto auto auto;
        gap:1rem;
        align-items:center;
        padding:1.2rem 1rem;
        background:var(--card-bg);
        border:1px solid var(--border);
        border-radius:4px;
        margin-bottom:.6rem;
        transition:border-color var(--transition);
        position:relative;
        overflow:hidden;
    }
    .panier-ligne::before {
        content:'';
        position:absolute;
        left:0; top:0; bottom:0;
        width:2px;
        background:var(--accent,var(--volt));
        opacity:0;
        transition:opacity var(--transition);
    }
    .panier-ligne:hover { border-color:rgba(200,255,0,.25); }
    .panier-ligne:hover::before { opacity:1; }

    /* Image dans la ligne */
    .panier-ligne-img {
        width:70px; height:90px;
        background:linear-gradient(135deg,#0a0d14,#131826);
        border-radius:3px;
        display:flex; align-items:center; justify-content:center;
        overflow:hidden;
        flex-shrink:0;
    }
    .panier-ligne-img img {
        width:100%; height:100%;
        object-fit:contain;
        filter:drop-shadow(0 4px 12px rgba(200,255,0,.15));
    }

    /* Infos produit */
    .panier-ligne-info { display:flex; flex-direction:column; gap:.2rem; min-width:0; }
    .panier-ligne-nom {
        font-family:var(--font-display);
        font-size:1.05rem;
        letter-spacing:.04em;
        color:var(--white);
        text-decoration:none;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
        transition:color var(--transition);
    }
    .panier-ligne-nom:hover { color:var(--volt); }
    .panier-ligne-ref { font-size:.65rem; color:var(--muted); letter-spacing:.12em; }
    .panier-ligne-prix-unit { font-size:.72rem; color:var(--muted); margin-top:.2rem; }

    /* Quantité */
    .panier-ligne-qty { display:flex; align-items:center; gap:.4rem; }
    .qty-wrap { display:flex; align-items:center; border:1px solid var(--border); border-radius:2px; background:var(--card-bg); overflow:hidden; }
    .qty-btn { width:30px; height:34px; background:transparent; border:none; color:var(--muted); font-size:.9rem; cursor:pointer; transition:all var(--transition); }
    .qty-btn:hover { background:rgba(200,255,0,.08); color:var(--volt); }
    .qty-input { width:40px; height:34px; background:transparent; border:none; border-left:1px solid var(--border); border-right:1px solid var(--border); color:var(--white); font-family:var(--font-display); font-size:1rem; text-align:center; }
    .qty-input:focus { outline:none; }
    .qty-input::-webkit-inner-spin-button,.qty-input::-webkit-outer-spin-button { -webkit-appearance:none; }
    .qty-update-btn { width:30px; height:34px; background:rgba(200,255,0,.08); border:1px solid var(--border); color:var(--volt); border-radius:2px; cursor:pointer; font-size:.8rem; transition:all var(--transition); }
    .qty-update-btn:hover { background:rgba(200,255,0,.18); }

    /* Prix & total */
    .panier-ligne-prix span { font-family:var(--font-display); font-size:1rem; color:var(--muted); }
    .panier-ligne-prix small { font-size:.6rem; color:var(--muted); display:block; }
    .panier-ligne-total { font-family:var(--font-display); font-size:1.15rem; color:var(--volt); white-space:nowrap; }
    .panier-ligne-total small { font-family:var(--font-body); font-size:.6rem; color:var(--muted); display:block; text-align:right; }

    /* Supprimer */
    .btn-del { background:transparent; border:1px solid var(--border); color:var(--muted); width:32px; height:32px; border-radius:2px; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:.85rem; transition:all var(--transition); }
    .btn-del:hover { border-color:#FF4444; color:#FF4444; background:rgba(255,68,68,.08); }

    /* Actions bas */
    .btn-vider { background:transparent; border:1px solid var(--border); color:var(--muted); font-size:.72rem; font-weight:600; letter-spacing:.12em; text-transform:uppercase; padding:.5rem 1.1rem; border-radius:2px; cursor:pointer; transition:all var(--transition); }
    .btn-vider:hover { border-color:#FF4444; color:#FF4444; }
    .btn-sm-volt { font-size:.75rem; padding:.55rem 1.2rem; }

    /* Récapitulatif */
    .panier-recap {
        background:var(--card-bg);
        border:1px solid var(--border);
        border-radius:4px;
        padding:2rem;
        position:sticky;
        top:7rem;
    }
    .recap-row { display:flex; justify-content:space-between; align-items:center; padding:.65rem 0; border-bottom:1px solid var(--border); font-size:.85rem; color:var(--muted); }
    .recap-row:last-of-type { border-bottom:none; }
    .recap-row span:last-child { color:var(--white); font-weight:600; }

    /* Barre livraison */
    .recap-livraison-bar { padding:.8rem 0; }
    .bar-track { height:3px; background:var(--border); border-radius:2px; overflow:hidden; }
    .bar-fill { height:100%; background:var(--volt); border-radius:2px; transition:width .6s ease; }

    /* Livraison offerte */
    .recap-livraison-ok { font-size:.75rem; color:var(--volt); text-align:center; padding:.6rem 0; border:1px solid rgba(200,255,0,.2); border-radius:2px; background:rgba(200,255,0,.05); margin:.6rem 0; }

    /* Total final */
    .recap-total { display:flex; justify-content:space-between; align-items:baseline; padding:1.2rem 0 1rem; border-top:1px solid var(--border); margin-top:.5rem; }
    .recap-total span:first-child { font-size:.75rem; font-weight:700; letter-spacing:.15em; text-transform:uppercase; color:var(--muted); }
    .recap-total span:last-child { font-family:var(--font-display); font-size:2rem; color:var(--volt); }

    /* Garanties */
    .recap-garanties { margin-top:1.2rem; padding-top:1.2rem; border-top:1px solid var(--border); display:flex; flex-direction:column; gap:.5rem; }
    .garantie-item { display:flex; align-items:center; gap:.6rem; font-size:.73rem; color:var(--muted); }
    .garantie-item i { color:var(--volt); font-size:.85rem; }

    /* Responsive */
    @media (max-width: 767.98px) {
        .panier-ligne { grid-template-columns: 60px 1fr auto; grid-template-rows: auto auto; gap:.6rem; }
        .panier-ligne-prix { display:none; }
        .panier-ligne-qty { grid-column: 2; }
        .panier-ligne-total { grid-column: 3; grid-row: 2; }
        .panier-ligne-del { grid-column: 3; grid-row: 1; }
        .panier-ligne-img { width:55px; height:75px; }
    }
</style>

<!-- ══ SCRIPTS ════════════════════════════════════════════════════ -->
<script>
    /* ── Quantité +/- avec auto-submit immédiat ── */
    document.querySelectorAll('.panier-ligne-qty').forEach(form => {
        const input  = form.querySelector('.qty-input');
        const btnMin = form.querySelector('.qty-minus');
        const btnPls = form.querySelector('.qty-plus');

        btnMin.addEventListener('click', () => {
            const v = Math.max(1, parseInt(input.value) - 1);
            input.value = v;
            form.submit(); // ← auto-submit
        });

        btnPls.addEventListener('click', () => {
            const v = Math.min(99, parseInt(input.value) + 1);
            input.value = v;
            form.submit(); // ← auto-submit
        });

        // Auto-submit aussi si l'utilisateur tape directement dans l'input
        input.addEventListener('change', () => {
            const v = Math.max(1, Math.min(99, parseInt(input.value) || 1));
            input.value = v;
            form.submit();
        });
    });
</script>
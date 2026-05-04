<!-- ══ MAIN ════════════════════════════════════════════════════════ -->

<?php
/* ── Données du produit ── */
$produit = $unPruduit->fetch(PDO::FETCH_ASSOC);

if (!$produit) {
    echo '<div class="container" style="padding: 10rem 0; text-align:center;">
            <p style="color:var(--muted); font-size:1rem;">Produit introuvable.</p>
            <a href="/produit/" class="btn btn-volt mt-3">Retour à la boutique</a>
          </div>';
    return;
}

/* ── Images : découpage du champ CSV ── */
$images_raw    = array_values(array_filter(array_map('trim', explode(',', $produit['image'] ?? ''))));
$image_main    = $images_raw[0] ?? '';
$img_main_path = $image_main;
$has_main_img  = !empty($image_main);               // ← chemin déjà complet

/* ── Couleur accent ── */
$accent = '#C8FF00';
$id     = $produit['identifiant'] ?? '';
if (str_contains($id, 'dark-forest')) $accent = '#8B5CF6';
if (str_contains($id, 'arctic'))      $accent = '#00C8FF';
if (str_contains($id, 'red-storm'))   $accent = '#FF4444';
if (str_contains($id, 'tropical'))    $accent = '#FF9500';
if (str_contains($id, 'midnight'))    $accent = '#4A90D9';
if (str_contains($id, 'berry'))       $accent = '#E040FB';
if (str_contains($id, 'peach'))       $accent = '#FFB347';
if (str_contains($id, 'yuzu'))        $accent = '#FFD700';
if (str_contains($id, 'hydro'))       $accent = '#00E5FF';

/* ── Prix TTC ── */
global $pdo;
$stmtTva = $pdo->prepare('SELECT taux, nom FROM tva WHERE id = ?');
$stmtTva->execute([$produit['id_tva']]);
$tva      = $stmtTva->fetch(PDO::FETCH_ASSOC);
$taux     = $tva ? (float)$tva['taux'] : 20.0;
$nom_tva  = $tva ? $tva['nom'] : 'TVA 20%';
$prix_ttc = $produit['prix_ht'] * (1 + $taux / 100);

/* ── Badge ── */
$badge = '';
if (str_contains($id, 'electric-lemon') || str_contains($id, 'starter'))                        $badge = ['label' => 'Best-seller', 'class' => ''];
elseif (str_contains($id, 'zen') || str_contains($id, 'midnight') || str_contains($id, 'yuzu')) $badge = ['label' => 'Nouveau',     'class' => 'new-badge'];
elseif (str_contains($id, 'pack') || str_contains($id, 'coffret'))                              $badge = ['label' => '-20%',         'class' => 'promo-badge'];

/* ── Ingrédients ── */
$ingredients = ['160mg Caféine naturelle','L-Théanine','Taurine 1000mg','Vitamines B3·B6·B12','Électrolytes','Zéro sucre ajouté'];
if (str_contains($id, 'hydro')) $ingredients = ['Vitamines B3·B6·B12','Électrolytes naturels','Sodium & Potassium','Zéro caféine','Zéro sucre','Stévia'];
if (str_contains($id, 'zen'))   $ingredients = ['Ashwagandha KSM-66','L-Théanine 200mg','Matcha Bio','Vitamines B','Magnésium','Zéro sucre'];

/* ── Produits suggérés ── */
$stmtSugg = $pdo->prepare('SELECT * FROM produit WHERE statut = "publie" AND id != ? ORDER BY RAND() LIMIT 4');
$stmtSugg->execute([$produit['id']]);
$suggestions = $stmtSugg->fetchAll(PDO::FETCH_ASSOC);

/* ── Tableau des chemins d'images pour le JS ── */
$images_json = json_encode($images_raw);          // ← chemins déjà complets
?>

<!-- ── BREADCRUMB ─────────────────────────────────────────────────── -->
<nav aria-label="Fil d'Ariane" style="padding: 6.5rem 0 0; background: var(--night);">
    <div class="container">
        <ol class="breadcrumb-volt">
            <li><a href="/">Accueil</a></li>
            <li aria-hidden="true"><i class="bi bi-chevron-right"></i></li>
            <li><a href="/produit/">Boutique</a></li>
            <li aria-hidden="true"><i class="bi bi-chevron-right"></i></li>
            <li aria-current="page"><?php echo htmlspecialchars($produit['nom']); ?></li>
        </ol>
    </div>
</nav>

<!-- ── FICHE PRODUIT ──────────────────────────────────────────────── -->
<section id="product-detail" aria-labelledby="product-name"
         style="padding: 3rem 0 6rem; background: var(--night); position: relative; overflow: hidden;">

    <div style="position:absolute; width:600px; height:600px; border-radius:50%;
            background: radial-gradient(circle, <?php echo $accent; ?>18 0%, transparent 65%);
            right:-100px; top:50%; transform:translateY(-50%); pointer-events:none;"
         aria-hidden="true"></div>

    <div class="container position-relative">
        <div class="row g-5 align-items-start">

            <!-- ── COL GAUCHE : Visuel ── -->
            <div class="col-lg-5">
                <div class="product-detail-visual">

                    <!-- Image principale -->
                    <div class="product-detail-img-main" style="--accent: <?php echo $accent; ?>;">

                        <?php if ($has_main_img) : ?>
                            <img id="main-product-img"
                                 src="<?php echo htmlspecialchars($img_main_path); ?>"
                                 alt="<?php echo htmlspecialchars($produit['nom']); ?>"
                                 class="detail-real-img" />
                        <?php else : ?>
                            <svg class="detail-can-svg" id="main-product-svg"
                                 width="200" height="380" viewBox="0 0 200 380"
                                 aria-label="<?php echo htmlspecialchars($produit['nom']); ?>" role="img">
                                <defs>
                                    <linearGradient id="dCanBody" x1="0" y1="0" x2="1" y2="0">
                                        <stop offset="0%"   stop-color="#1a1f2e"/>
                                        <stop offset="40%"  stop-color="#252c3f"/>
                                        <stop offset="100%" stop-color="#111520"/>
                                    </linearGradient>
                                    <linearGradient id="dShine" x1="0" y1="0" x2="1" y2="0">
                                        <stop offset="0%"   stop-color="white" stop-opacity="0"/>
                                        <stop offset="40%"  stop-color="white" stop-opacity="0.1"/>
                                        <stop offset="100%" stop-color="white" stop-opacity="0"/>
                                    </linearGradient>
                                </defs>
                                <path d="M30 50 Q30 25 100 25 Q170 25 170 50 L170 330 Q170 355 100 355 Q30 355 30 330 Z" fill="url(#dCanBody)"/>
                                <path d="M30 50 Q30 25 100 25 Q170 25 170 50 L170 330 Q170 355 100 355 Q30 355 30 330 Z" fill="url(#dShine)"/>
                                <rect x="30" y="158" width="140" height="5" fill="<?php echo $accent; ?>"/>
                                <rect x="30" y="165" width="140" height="2" fill="<?php echo $accent; ?>" opacity=".3"/>
                                <text x="100" y="115" font-family="'Bebas Neue',sans-serif" font-size="42" fill="#F4F6F8" text-anchor="middle" letter-spacing="4">VOLTEX</text>
                                <text x="100" y="138" font-family="'DM Sans',sans-serif" font-size="8" fill="#6B7280" text-anchor="middle" letter-spacing="4">PREMIUM ENERGY</text>
                                <text x="100" y="188" font-family="'Bebas Neue',sans-serif" font-size="14" fill="<?php echo $accent; ?>" text-anchor="middle" letter-spacing="3">
                                    <?php echo strtoupper(substr(htmlspecialchars($produit['nom']), 0, 18)); ?>
                                </text>
                                <path d="M91 208 L99 194 L99 203 L111 203 L103 217 L103 208Z" fill="<?php echo $accent; ?>"/>
                                <ellipse cx="100" cy="48" rx="70" ry="22" fill="#252c3f"/>
                                <ellipse cx="100" cy="40" rx="45" ry="13" fill="#2a3045"/>
                                <ellipse cx="107" cy="36" rx="9" ry="4" fill="#404860" stroke="#505878" stroke-width="1"/>
                                <path d="M60 65 Q68 52 72 72 Q70 95 65 112 Q61 128 60 145" stroke="white" stroke-width="2.5" stroke-opacity="0.05" fill="none" stroke-linecap="round"/>
                            </svg>
                        <?php endif; ?>

                        <?php if ($badge) : ?>
                            <span class="detail-badge product-badge <?php echo $badge['class']; ?>">
                                <?php echo $badge['label']; ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Thumbnails : une par image dans le champ ── -->
                    <?php if (count($images_raw) > 0) : ?>
                        <div class="detail-thumbs" role="list" aria-label="Vues du produit">
                            <?php foreach ($images_raw as $i => $img_file) :
                                $thumb_path = $img_file;                          // ← chemin déjà complet
                                $has_thumb  = file_exists($thumb_path);
                                ?>
                                <button class="detail-thumb <?php echo $i === 0 ? 'active' : ''; ?>"
                                        role="listitem"
                                        data-img="<?php echo htmlspecialchars($thumb_path); ?>"
                                        data-index="<?php echo $i; ?>"
                                        aria-label="Vue <?php echo $i + 1; ?>"
                                        style="--accent: <?php echo $accent; ?>;">
                                    <?php if ($has_thumb) : ?>
                                        <img src="<?php echo htmlspecialchars($thumb_path); ?>"
                                             alt="Vue <?php echo $i + 1; ?>"
                                             class="thumb-img" />
                                    <?php else : ?>
                                        <svg width="40" height="60" viewBox="0 0 40 60" aria-hidden="true">
                                            <rect x="5" y="3" width="30" height="54" rx="6" fill="#1a1f2e"/>
                                            <rect x="5" y="25" width="30" height="2" fill="<?php echo $accent; ?>"/>
                                            <text x="20" y="21" font-family="'Bebas Neue'" font-size="7" fill="#F4F6F8" text-anchor="middle">VX</text>
                                            <text x="20" y="36" font-family="'Bebas Neue'" font-size="6" fill="<?php echo $accent; ?>" text-anchor="middle"><?php echo $i + 1; ?></text>
                                        </svg>
                                    <?php endif; ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- ── COL DROITE : Infos ── -->
            <div class="col-lg-7">

                <p class="section-label" style="margin-bottom: .6rem;">
                    <?php
                    $cat = 'Canette premium';
                    if (str_contains($id,'pack')||str_contains($id,'coffret')||str_contains($id,'abonnement')) $cat='Pack & coffret';
                    elseif (str_contains($id,'hydro'))                                   $cat='Eau vitaminée';
                    elseif (str_contains($id,'shaker')||str_contains($id,'tshirt'))      $cat='Accessoire';
                    echo $cat;
                    ?>
                </p>

                <h1 class="product-detail-name" id="product-name">
                    <?php echo htmlspecialchars($produit['nom']); ?>
                </h1>

                <div class="d-flex align-items-center gap-3 mt-2 mb-4">
                    <div class="product-stars" aria-label="Note 4.8">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half-fill"></i>
                    </div>
                    <span style="font-size:.8rem; color:var(--muted);">4.8 · 324 avis</span>
                    <span style="font-size:.75rem; color:var(--volt); border:1px solid rgba(200,255,0,.3); padding:.15rem .55rem; border-radius:2px; letter-spacing:.1em;">
                        <?php echo $produit['statut'] === 'publie' ? 'En stock' : 'Indisponible'; ?>
                    </span>
                </div>

                <p class="product-detail-desc">
                    <?php echo nl2br(htmlspecialchars($produit['description'] ?? '')); ?>
                </p>

                <div class="product-detail-price-block">
                    <div class="d-flex align-items-baseline gap-3 flex-wrap">
                        <span class="detail-price-ht">
                            <?php echo number_format($produit['prix_ht'], 2, ',', ' '); ?>€ <small>HT</small>
                        </span>
                        <span class="detail-price-ttc">
                            soit <?php echo number_format($prix_ttc, 2, ',', ' '); ?>€ TTC
                        </span>
                    </div>
                    <p class="detail-tva-label">
                        <i class="bi bi-info-circle me-1"></i>
                        <?php echo htmlspecialchars($nom_tva); ?> (<?php echo $taux; ?>%)
                        — prix indicatif, TVA applicable à la commande
                    </p>
                </div>

                <div class="detail-ingredients">
                    <p style="font-size:.68rem; letter-spacing:.2em; text-transform:uppercase; color:var(--volt); margin-bottom:.8rem;">Composition clé</p>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($ingredients as $ing) : ?>
                            <span class="ingredient-tag"><?php echo $ing; ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php if ($produit['statut'] === 'publie') : ?>
                    <form method="POST"
                          action="/produit/<?php echo htmlspecialchars($produit['identifiant']); ?>/"
                          class="detail-actions">
                        <input type="hidden" name="idPRoduit" value="<?php echo (int)$produit['id']; ?>" />

                        <div class="qty-wrap" aria-label="Quantité">
                            <button type="button" class="qty-btn" id="qty-minus" aria-label="Diminuer">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input type="number" name="quantite" id="qty-input" class="qty-input"
                                   value="1" min="1" max="99" aria-label="Quantité" />
                            <button type="button" class="qty-btn" id="qty-plus" aria-label="Augmenter">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>

                        <button type="submit" class="btn btn-volt btn-add-detail" aria-label="Ajouter au panier">
                            <i class="bi bi-bag-plus me-2"></i> Ajouter au panier
                        </button>

                        <button type="button" class="btn-wishlist" aria-label="Ajouter aux favoris">
                            <i class="bi bi-heart"></i>
                        </button>
                    </form>

                    <p class="detail-total" id="detail-total">
                        Total : <strong><?php echo number_format($prix_ttc, 2, ',', ' '); ?>€</strong> TTC
                    </p>
                <?php else : ?>
                    <p style="color:var(--muted); font-size:.85rem; margin-top:1.5rem;">
                        <i class="bi bi-exclamation-circle me-1"></i> Ce produit n'est pas encore disponible.
                    </p>
                <?php endif; ?>

                <div class="detail-guarantees">
                    <div class="guarantee-item"><i class="bi bi-truck guarantee-icon"></i><span>Livraison offerte dès 50€</span></div>
                    <div class="guarantee-item"><i class="bi bi-arrow-counterclockwise guarantee-icon"></i><span>Retour 30 jours</span></div>
                    <div class="guarantee-item"><i class="bi bi-shield-check guarantee-icon"></i><span>ISO 22000 certifié</span></div>
                    <div class="guarantee-item"><i class="bi bi-lock guarantee-icon"></i><span>Paiement sécurisé SSL</span></div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- ── ONGLETS ─────────────────────────────────────────────────────── -->
<section style="background: var(--surface); border-top: 1px solid var(--border); padding: 4rem 0;">
    <div class="container">
        <div class="detail-tabs" role="tablist" aria-label="Informations produit">
            <button class="detail-tab active" role="tab" aria-selected="true"  aria-controls="tab-desc"  id="btn-tab-desc">Description</button>
            <button class="detail-tab"        role="tab" aria-selected="false" aria-controls="tab-nutri" id="btn-tab-nutri">Valeurs nutritionnelles</button>
            <button class="detail-tab"        role="tab" aria-selected="false" aria-controls="tab-livr"  id="btn-tab-livr">Livraison & retours</button>
        </div>
        <div class="detail-tab-content">

            <div id="tab-desc" role="tabpanel" aria-labelledby="btn-tab-desc" class="tab-panel active">
                <div class="row g-4 mt-1">
                    <div class="col-md-8">
                        <p style="color:var(--muted); font-size:.9rem; line-height:1.9;"><?php echo nl2br(htmlspecialchars($produit['description'] ?? '')); ?></p>
                        <p style="color:var(--muted); font-size:.9rem; line-height:1.9; margin-top:1rem;">Chaque canette VOLTEX est fabriquée dans notre laboratoire certifié ISO 22000. Aucun colorant artificiel, aucun édulcorant de synthèse.</p>
                    </div>
                    <div class="col-md-4">
                        <div class="tab-info-card">
                            <div class="tab-info-row"><span>Volume</span><span><?php echo str_contains($id,'250ml') ? '250 ml' : '500 ml'; ?></span></div>
                            <div class="tab-info-row"><span>Conditionnement</span><span>Canette aluminium</span></div>
                            <div class="tab-info-row"><span>Origine</span><span>Formulé en France</span></div>
                            <div class="tab-info-row"><span>Certification</span><span>ISO 22000</span></div>
                            <div class="tab-info-row"><span>Sucre ajouté</span><span style="color:var(--volt);">Zéro</span></div>
                            <?php if (count($images_raw) > 1) : ?>
                                <div class="tab-info-row"><span>Visuels</span><span style="color:var(--volt);"><?php echo count($images_raw); ?> photos</span></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab-nutri" role="tabpanel" aria-labelledby="btn-tab-nutri" class="tab-panel" hidden>
                <div class="row mt-3">
                    <div class="col-md-5">
                        <table class="nutri-table" aria-label="Tableau nutritionnel">
                            <thead><tr><th scope="col">Pour 100 ml</th><th scope="col">Valeur</th><th scope="col">% AR*</th></tr></thead>
                            <tbody>
                            <tr><td>Énergie</td><td>22 kcal / 92 kJ</td><td>1%</td></tr>
                            <tr><td>Lipides</td><td>0 g</td><td>0%</td></tr>
                            <tr><td>Glucides</td><td>0,6 g</td><td>—</td></tr>
                            <tr><td>dont sucres</td><td>0 g</td><td>0%</td></tr>
                            <tr><td>Protéines</td><td>0 g</td><td>0%</td></tr>
                            <tr><td>Sel</td><td>0,08 g</td><td>1%</td></tr>
                            <tr><td>Caféine</td><td><?php echo str_contains($id,'hydro') ? '0 mg' : '32 mg'; ?></td><td>—</td></tr>
                            <tr><td>Taurine</td><td>200 mg</td><td>—</td></tr>
                            <tr><td>Niacine (B3)</td><td>8 mg</td><td>50%</td></tr>
                            <tr><td>B6</td><td>0,7 mg</td><td>50%</td></tr>
                            <tr><td>B12</td><td>1,25 µg</td><td>50%</td></tr>
                            </tbody>
                        </table>
                        <p style="font-size:.68rem; color:var(--muted); margin-top:.6rem;">* AR = Apports de référence pour un adulte type (8 400 kJ / 2 000 kcal)</p>
                    </div>
                </div>
            </div>

            <div id="tab-livr" role="tabpanel" aria-labelledby="btn-tab-livr" class="tab-panel" hidden>
                <div class="row g-4 mt-1">
                    <div class="col-md-6">
                        <h3 style="font-family:var(--font-display); font-size:1.3rem; margin-bottom:1rem;">Livraison</h3>
                        <div class="tab-info-card">
                            <div class="tab-info-row"><span>Standard (3-5j)</span><span>4,90€</span></div>
                            <div class="tab-info-row"><span>Express (24-48h)</span><span>7,90€</span></div>
                            <div class="tab-info-row"><span>Offerte dès</span><span style="color:var(--volt);">50€ d'achat</span></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 style="font-family:var(--font-display); font-size:1.3rem; margin-bottom:1rem;">Retours</h3>
                        <p style="color:var(--muted); font-size:.88rem; line-height:1.8;">Retour accepté sous <strong style="color:var(--white);">30 jours</strong> après réception. Remboursement intégral sous 5 jours ouvrés.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ── PRODUITS SUGGÉRÉS ───────────────────────────────────────────── -->
<?php if (!empty($suggestions)) : ?>
    <section style="background: var(--night); border-top: 1px solid var(--border); padding: 5rem 0;" aria-labelledby="sugg-heading">
        <div class="container">
            <div class="d-flex align-items-end justify-content-between mb-5">
                <div>
                    <p class="section-label">Vous aimerez aussi</p>
                    <h2 class="section-heading" id="sugg-heading" style="font-size: clamp(2rem, 5vw, 3.5rem);">
                        DANS LA MÊME <span class="volt-text">VEINE.</span>
                    </h2>
                </div>
                <a href="/produit/" class="btn btn-outline-volt d-none d-md-inline-flex">
                    Tout voir <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="row g-4">
                <?php foreach ($suggestions as $sugg) :
                    $sacc = '#C8FF00';
                    $sid  = $sugg['identifiant'] ?? '';
                    if (str_contains($sid,'dark-forest')) $sacc='#8B5CF6';
                    if (str_contains($sid,'arctic'))      $sacc='#00C8FF';
                    if (str_contains($sid,'red-storm'))   $sacc='#FF4444';
                    if (str_contains($sid,'tropical'))    $sacc='#FF9500';
                    if (str_contains($sid,'midnight'))    $sacc='#4A90D9';
                    if (str_contains($sid,'berry'))       $sacc='#E040FB';
                    if (str_contains($sid,'peach'))       $sacc='#FFB347';
                    if (str_contains($sid,'hydro'))       $sacc='#00E5FF';

                    /* Première image de la suggestion */
                    $sugg_imgs     = array_values(array_filter(array_map('trim', explode(',', $sugg['image'] ?? ''))));
                    $sugg_img_path = $sugg_imgs[0] ?? '';             // ← chemin déjà complet
                    $sugg_has_img  = !empty($sugg_img_path);
                    ?>
                    <div class="col-sm-6 col-lg-3">
                        <article class="product-card" style="--accent: <?php echo $sacc; ?>;">
                            <div class="product-img-wrap">
                                <?php if ($sugg_has_img) : ?>
                                    <img src="<?php echo htmlspecialchars($sugg_img_path); ?>"
                                         alt="<?php echo htmlspecialchars($sugg['nom']); ?>"
                                         class="product-real-img" />
                                <?php else : ?>
                                    <svg width="90" height="180" viewBox="0 0 100 200"
                                         aria-label="<?php echo htmlspecialchars($sugg['nom']); ?>"
                                         role="img" class="product-can-img">
                                        <rect x="15" y="10" width="70" height="180" rx="12" fill="#1a1f2e"/>
                                        <rect x="15" y="80" width="70" height="4" fill="<?php echo $sacc; ?>"/>
                                        <text x="50" y="65" font-family="'Bebas Neue'" font-size="13" fill="#F4F6F8" text-anchor="middle">VOLTEX</text>
                                        <text x="50" y="100" font-family="'Bebas Neue'" font-size="7" fill="<?php echo $sacc; ?>" text-anchor="middle"><?php echo strtoupper(substr($sugg['nom'],0,12)); ?></text>
                                        <path d="M43 115 L49 105 L49 112 L57 112 L51 122 L51 115Z" fill="<?php echo $sacc; ?>"/>
                                        <ellipse cx="50" cy="9" rx="35" ry="10" fill="#252c3f"/>
                                    </svg>
                                <?php endif; ?>
                                <div class="product-overlay">
                                    <a href="/produit/<?php echo htmlspecialchars($sugg['identifiant']); ?>"
                                       class="product-overlay-btn">
                                        <i class="bi bi-eye me-1"></i> Voir
                                    </a>
                                </div>
                            </div>
                            <div class="product-body">
                                <h3 class="product-name"><?php echo htmlspecialchars($sugg['nom']); ?></h3>
                                <div class="product-meta" style="margin-top:.5rem;">
                                    <div class="product-price"><?php echo number_format($sugg['prix_ht'],2,',',' '); ?>€ <small>HT</small></div>
                                    <button class="product-add-btn" aria-label="Ajouter <?php echo htmlspecialchars($sugg['nom']); ?> au panier">
                                        <i class="bi bi-bag-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- ══ STYLES ════════════════════════════════════════════════════ -->
<style>
    .breadcrumb-volt { display:flex; align-items:center; gap:.5rem; list-style:none; margin:0; padding:0; font-size:.75rem; color:var(--muted); }
    .breadcrumb-volt a { color:var(--muted); text-decoration:none; transition:color var(--transition); }
    .breadcrumb-volt a:hover { color:var(--volt); }
    .breadcrumb-volt li:last-child { color:var(--white); }
    .breadcrumb-volt i { font-size:.6rem; }
    .product-detail-visual { position:sticky; top:7rem; }
    .product-detail-img-main { background:linear-gradient(135deg,#0a0d14,#131826); border:1px solid var(--border); border-radius:4px; display:flex; align-items:center; justify-content:center; height:420px; position:relative; overflow:hidden; transition:border-color var(--transition); }
    .product-detail-img-main:hover { border-color:rgba(200,255,0,.3); }
    .product-detail-img-main::before { content:''; position:absolute; width:300px; height:300px; background:radial-gradient(circle,var(--accent,#C8FF00)22 0%,transparent 65%); border-radius:50%; pointer-events:none; }
    .detail-real-img, .detail-can-svg { position:relative; z-index:1; filter:drop-shadow(0 20px 50px rgba(200,255,0,.2)); animation:floatCan 5s ease-in-out infinite; max-height:360px; object-fit:contain; }
    /* Pause animation au hover pour voir l'image nettement */
    .product-detail-img-main:hover .detail-real-img,
    .product-detail-img-main:hover .detail-can-svg { animation-play-state: paused; }
    .detail-badge { position:absolute; top:1rem; left:1rem; z-index:2; }
    /* Thumbnails */
    .detail-thumbs { display:flex; gap:.6rem; margin-top:1rem; justify-content:center; flex-wrap:wrap; }
    .detail-thumb { width:60px; height:80px; border:1px solid var(--border); border-radius:3px; background:var(--card-bg); display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all var(--transition); padding:2px; overflow:hidden; }
    .detail-thumb:hover, .detail-thumb.active { border-color:var(--accent,var(--volt)); box-shadow:0 0 0 1px var(--accent,var(--volt)); }
    .thumb-img { width:100%; height:100%; object-fit:cover; border-radius:2px; }
    /* Transition image principale */
    #main-product-img { transition: opacity .22s ease; }
    #main-product-img.switching { opacity:0; }
    .product-detail-name { font-family:var(--font-display); font-size:clamp(2rem,5vw,3.5rem); line-height:1; letter-spacing:.04em; margin:0; }
    .product-detail-desc { font-size:.92rem; color:var(--muted); line-height:1.85; margin-bottom:1.5rem; }
    .product-stars { color:var(--volt); font-size:.78rem; }
    .product-detail-price-block { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:1.2rem 1.4rem; margin-bottom:1.5rem; }
    .detail-price-ht { font-family:var(--font-display); font-size:2.6rem; color:var(--volt); line-height:1; }
    .detail-price-ht small { font-family:var(--font-body); font-size:.7rem; color:var(--muted); letter-spacing:.12em; }
    .detail-price-ttc { font-size:.88rem; color:var(--muted); }
    .detail-tva-label { font-size:.72rem; color:var(--muted); margin:.5rem 0 0; opacity:.75; }
    .detail-ingredients { margin-bottom:1.8rem; }
    .ingredient-tag { font-size:.68rem; font-weight:600; letter-spacing:.12em; text-transform:uppercase; border:1px solid var(--border); color:var(--muted); padding:.25rem .7rem; border-radius:2px; background:var(--card-bg); transition:all var(--transition); }
    .ingredient-tag:hover { border-color:rgba(200,255,0,.4); color:var(--white); }
    .detail-actions { display:flex; align-items:center; gap:.9rem; flex-wrap:wrap; margin-bottom:.6rem; }
    .qty-wrap { display:flex; align-items:center; border:1px solid var(--border); border-radius:2px; overflow:hidden; background:var(--card-bg); }
    .qty-btn { width:38px; height:42px; background:transparent; border:none; color:var(--muted); font-size:1rem; cursor:pointer; transition:all var(--transition); }
    .qty-btn:hover { background:rgba(200,255,0,.08); color:var(--volt); }
    .qty-input { width:48px; height:42px; background:transparent; border:none; border-left:1px solid var(--border); border-right:1px solid var(--border); color:var(--white); font-family:var(--font-display); font-size:1.1rem; text-align:center; }
    .qty-input:focus { outline:none; }
    .qty-input::-webkit-inner-spin-button,.qty-input::-webkit-outer-spin-button { -webkit-appearance:none; }
    .btn-add-detail { padding:.85rem 2rem; font-size:.82rem; }
    .btn-wishlist { width:42px; height:42px; background:var(--card-bg); border:1px solid var(--border); color:var(--muted); border-radius:2px; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:1rem; transition:all var(--transition); }
    .btn-wishlist:hover { border-color:var(--volt); color:var(--volt); }
    .detail-total { font-size:.82rem; color:var(--muted); margin:0; }
    .detail-total strong { color:var(--volt); }
    .detail-guarantees { display:flex; flex-wrap:wrap; gap:.8rem; margin-top:1.8rem; padding-top:1.5rem; border-top:1px solid var(--border); }
    .guarantee-item { display:flex; align-items:center; gap:.5rem; font-size:.75rem; color:var(--muted); }
    .guarantee-icon { color:var(--volt); font-size:.95rem; }
    .detail-tabs { display:flex; gap:0; border-bottom:1px solid var(--border); margin-bottom:0; }
    .detail-tab { background:transparent; border:none; border-bottom:2px solid transparent; color:var(--muted); font-size:.75rem; font-weight:600; letter-spacing:.18em; text-transform:uppercase; padding:.9rem 1.6rem; cursor:pointer; transition:all var(--transition); margin-bottom:-1px; }
    .detail-tab:hover { color:var(--white); }
    .detail-tab.active { color:var(--volt); border-bottom-color:var(--volt); }
    .tab-panel { padding:2rem 0; }
    .tab-info-card { border:1px solid var(--border); border-radius:4px; background:var(--card-bg); overflow:hidden; }
    .tab-info-row { display:flex; justify-content:space-between; align-items:center; padding:.75rem 1.2rem; font-size:.83rem; border-bottom:1px solid var(--border); color:var(--muted); }
    .tab-info-row:last-child { border-bottom:none; }
    .tab-info-row span:last-child { color:var(--white); font-weight:600; }
    .nutri-table { width:100%; border-collapse:collapse; font-size:.82rem; }
    .nutri-table th { font-size:.65rem; letter-spacing:.2em; text-transform:uppercase; color:var(--volt); font-weight:700; padding:.6rem .9rem; border-bottom:1px solid var(--border); text-align:left; }
    .nutri-table td { padding:.6rem .9rem; color:var(--muted); border-bottom:1px solid rgba(200,255,0,.05); }
    .nutri-table tr:hover td { background:rgba(200,255,0,.03); color:var(--white); }
    .product-card { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; overflow:hidden; transition:transform var(--transition),border-color var(--transition),box-shadow var(--transition); cursor:pointer; position:relative; }
    .product-card::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; background:var(--accent,var(--volt)); transform:scaleX(0); transition:transform var(--transition); }
    .product-card:hover { transform:translateY(-6px); border-color:rgba(200,255,0,.35); box-shadow:0 20px 60px rgba(200,255,0,.08); }
    .product-card:hover::before { transform:scaleX(1); }
    .product-img-wrap { position:relative; background:linear-gradient(135deg,#0a0d14,#131826); display:flex; align-items:center; justify-content:center; height:200px; overflow:hidden; }
    .product-real-img { height:180px; object-fit:contain; filter:drop-shadow(0 8px 24px rgba(200,255,0,.15)); transition:transform var(--transition); }
    .product-can-img { height:150px; filter:drop-shadow(0 8px 24px rgba(200,255,0,.2)); transition:transform var(--transition); }
    .product-card:hover .product-real-img,.product-card:hover .product-can-img { transform:scale(1.06) rotate(-3deg); }
    .product-body { padding:1.1rem; }
    .product-name { font-family:var(--font-display); font-size:1.1rem; letter-spacing:.05em; margin-bottom:.2rem; }
    .product-meta { display:flex; align-items:center; justify-content:space-between; gap:.5rem; }
    .product-price { font-family:var(--font-display); font-size:1.2rem; color:var(--volt); }
    .product-price small { font-family:var(--font-body); font-size:.6rem; color:var(--muted); }
    .product-add-btn { background:var(--volt); color:var(--night); border:none; font-size:.68rem; font-weight:800; padding:.45rem .8rem; border-radius:2px; transition:all var(--transition); cursor:pointer; }
    .product-add-btn:hover { background:var(--volt-dim); }
    .product-overlay { position:absolute; inset:0; background:rgba(8,10,15,.7); display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity var(--transition); z-index:3; }
    .product-card:hover .product-overlay { opacity:1; }
    .product-overlay-btn { background:var(--volt); color:var(--night); font-size:.7rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase; padding:.55rem 1.1rem; border-radius:2px; text-decoration:none; }
    .product-badge { position:absolute; top:.9rem; left:.9rem; background:var(--volt); color:var(--night); font-size:.58rem; font-weight:800; letter-spacing:.15em; text-transform:uppercase; padding:.2rem .55rem; border-radius:1px; z-index:2; }
    .product-badge.new-badge { background:#00C8FF; }
    .product-badge.promo-badge { background:#FF4444; color:#fff; }
    @media (max-width:991.98px) { .product-detail-visual { position:static; margin-bottom:2rem; } .product-detail-img-main { height:320px; } }
</style>

<!-- ══ SCRIPTS ════════════════════════════════════════════════════ -->
<script>
    /* ── Images (PHP → JS) ── */
    const productImages = <?php echo $images_json; ?>;
    const mainImg       = document.getElementById('main-product-img');

    /* ── Thumbnail click → swap image principale ── */
    document.querySelectorAll('.detail-thumb').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.detail-thumb').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            if (mainImg) {
                const newSrc = btn.dataset.img;
                mainImg.classList.add('switching');
                setTimeout(() => {
                    mainImg.src = newSrc;
                    mainImg.classList.remove('switching');
                }, 220);
            }
        });
    });

    /* ── Tabs ── */
    document.querySelectorAll('.detail-tab').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.detail-tab').forEach(b => { b.classList.remove('active'); b.setAttribute('aria-selected','false'); });
            document.querySelectorAll('.tab-panel').forEach(p => p.hidden = true);
            btn.classList.add('active');
            btn.setAttribute('aria-selected','true');
            document.getElementById(btn.getAttribute('aria-controls')).hidden = false;
        });
    });

    /* ── Quantité + Total ── */
    const qtyInput = document.getElementById('qty-input');
    const ttcUnit  = <?php echo $prix_ttc; ?>;

    function updateTotal() {
        const qty = Math.max(1, parseInt(qtyInput.value) || 1);
        qtyInput.value = qty;
        const total = (ttcUnit * qty).toFixed(2).replace('.', ',');
        document.getElementById('detail-total').innerHTML = 'Total : <strong>' + total + '€</strong> TTC';
    }

    document.getElementById('qty-minus')?.addEventListener('click', () => { qtyInput.value = Math.max(1,  parseInt(qtyInput.value) - 1); updateTotal(); });
    document.getElementById('qty-plus')?.addEventListener('click',  () => { qtyInput.value = Math.min(99, parseInt(qtyInput.value) + 1); updateTotal(); });
    qtyInput?.addEventListener('input', updateTotal);

    /* ── Add to cart ── */
    document.getElementById('btn-add-cart')?.addEventListener('click', function () {
        const original = this.innerHTML;
        this.innerHTML  = '<i class="bi bi-check2 me-2"></i> Ajouté au panier !';
        this.disabled   = true;
        setTimeout(() => { this.innerHTML = original; this.disabled = false; }, 2000);
    });

    /* ── Wishlist toggle ── */
    document.querySelector('.btn-wishlist')?.addEventListener('click', function () {
        this.querySelector('i').classList.toggle('bi-heart');
        this.querySelector('i').classList.toggle('bi-heart-fill');
        this.style.color = this.querySelector('i').classList.contains('bi-heart-fill') ? 'var(--volt)' : '';
    });

    /* ── Scroll-reveal suggestions ── */
    if ('IntersectionObserver' in window) {
        const obs = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) { e.target.style.opacity='1'; e.target.style.transform='translateY(0)'; obs.unobserve(e.target); }
            });
        }, { threshold:.1 });
        document.querySelectorAll('section .col-sm-6').forEach((el, i) => {
            el.style.opacity='0'; el.style.transform='translateY(24px)';
            el.style.transition=`opacity .55s ease ${i*.08}s, transform .55s ease ${i*.08}s`;
            obs.observe(el);
        });
    }
</script>
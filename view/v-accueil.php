<!-- ══ MAIN ════════════════════════════════════════════════════════ -->

<!-- ── HERO ───────────────────────────────────────────────────── -->
<section id="hero" aria-labelledby="hero-heading">
    <div class="hero-bg" aria-hidden="true"></div>
    <div class="hero-grid-lines" aria-hidden="true"></div>
    <div class="hero-glow" aria-hidden="true"></div>

    <div class="container position-relative">
        <div class="row align-items-center">

            <!-- Copy -->
            <div class="col-lg-6">
                <h1 class="display-hero" id="hero-heading">
                    FUEL<br />YOUR<br /><span class="volt-text">EDGE.</span>
                </h1>
                <p class="hero-sub mt-4">
                    Des formules élaborées en laboratoire pour amplifier performance mentale, concentration et endurance. Chaque canette est une déclaration.
                </p>

                <div class="hero-actions d-flex flex-wrap gap-3 mt-5">
                    <a href="/produit/" class="btn btn-volt">Découvrir la gamme</a>
                    <a href="#ingredients" class="btn btn-outline-volt">Notre formule</a>
                </div>

                <div class="hero-stats d-flex align-items-center gap-4 mt-5">
                    <div>
                        <div class="hero-stat-value">12+</div>
                        <div class="hero-stat-label">Saveurs</div>
                    </div>
                    <div class="hero-stat-divider" aria-hidden="true"></div>
                    <div>
                        <div class="hero-stat-value">98%</div>
                        <div class="hero-stat-label">Naturels</div>
                    </div>
                    <div class="hero-stat-divider" aria-hidden="true"></div>
                    <div>
                        <div class="hero-stat-value">4.9★</div>
                        <div class="hero-stat-label">2 400 avis</div>
                    </div>
                </div>
            </div>

            <!-- Can Illustration -->
            <!-- Can Illustration -->
            <div class="col-lg-6">
                <div class="hero-can-wrap">

                    <?php
                    /* ── Première image du produit hero ── */
                    $hero_imgs    = array_values(array_filter(array_map('trim', explode(',', $produit_hero['image'] ?? ''))));
                    $hero_img     = $hero_imgs[0] ?? '';
                    $hero_has_img = !empty($hero_img);

                    /* ── Accent couleur ── */
                    $hero_id     = $produit_hero['identifiant'] ?? '';
                    $hero_accent = '#C8FF00';
                    if (str_contains($hero_id, 'dark-forest')) $hero_accent = '#8B5CF6';
                    if (str_contains($hero_id, 'arctic'))      $hero_accent = '#00C8FF';
                    if (str_contains($hero_id, 'red-storm'))   $hero_accent = '#FF4444';
                    if (str_contains($hero_id, 'tropical'))    $hero_accent = '#FF9500';
                    if (str_contains($hero_id, 'midnight'))    $hero_accent = '#4A90D9';
                    if (str_contains($hero_id, 'berry'))       $hero_accent = '#E040FB';
                    if (str_contains($hero_id, 'peach'))       $hero_accent = '#FFB347';
                    if (str_contains($hero_id, 'yuzu'))        $hero_accent = '#FFD700';
                    if (str_contains($hero_id, 'hydro'))       $hero_accent = '#00E5FF';
                    ?>

                    <?php if ($hero_has_img) : ?>
                        <!-- Image réelle du produit -->
                        <a href="/produit/<?php echo htmlspecialchars($hero_id); ?>"
                           aria-label="Voir <?php echo htmlspecialchars($produit_hero['nom']); ?>">
                            <img src="<?php echo htmlspecialchars($hero_img); ?>"
                                 alt="<?php echo htmlspecialchars($produit_hero['nom']); ?>"
                                 class="can-svg"
                                 style="filter:drop-shadow(0 20px 60px <?php echo $hero_accent; ?>40); max-height:480px; object-fit:contain;" />
                        </a>

                    <?php else : ?>
                        <!-- SVG fallback avec couleur dynamique -->
                        <svg class="can-svg" width="260" height="480" viewBox="0 0 260 480" fill="none"
                             xmlns="http://www.w3.org/2000/svg"
                             aria-label="Canette VOLTEX <?php echo htmlspecialchars($produit_hero['nom'] ?? ''); ?>"
                             role="img">
                            <defs>
                                <linearGradient id="canBody" x1="0" y1="0" x2="1" y2="0">
                                    <stop offset="0%"   stop-color="#1a1f2e"/>
                                    <stop offset="35%"  stop-color="#252c3f"/>
                                    <stop offset="65%"  stop-color="#1e2436"/>
                                    <stop offset="100%" stop-color="#111520"/>
                                </linearGradient>
                                <linearGradient id="canShine" x1="0" y1="0" x2="1" y2="0">
                                    <stop offset="0%"   stop-color="white" stop-opacity="0"/>
                                    <stop offset="30%"  stop-color="white" stop-opacity="0.07"/>
                                    <stop offset="45%"  stop-color="white" stop-opacity="0.13"/>
                                    <stop offset="60%"  stop-color="white" stop-opacity="0.04"/>
                                    <stop offset="100%" stop-color="white" stop-opacity="0"/>
                                </linearGradient>
                                <linearGradient id="topGrad" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%"   stop-color="#3a4055"/>
                                    <stop offset="100%" stop-color="#1a1f2e"/>
                                </linearGradient>
                                <clipPath id="canClip">
                                    <path d="M40 60 Q40 30 130 30 Q220 30 220 60 L220 420 Q220 450 130 450 Q40 450 40 420 Z"/>
                                </clipPath>
                            </defs>
                            <path d="M40 60 Q40 30 130 30 Q220 30 220 60 L220 420 Q220 450 130 450 Q40 450 40 420 Z" fill="url(#canBody)"/>
                            <path d="M40 60 Q40 30 130 30 Q220 30 220 60 L220 420 Q220 450 130 450 Q40 450 40 420 Z" fill="url(#canShine)"/>
                            <rect x="40" y="200" width="180" height="6" fill="<?php echo $hero_accent; ?>" clip-path="url(#canClip)"/>
                            <rect x="40" y="210" width="180" height="2" fill="<?php echo $hero_accent; ?>" opacity=".3" clip-path="url(#canClip)"/>
                            <text x="130" y="155" font-family="'Bebas Neue', sans-serif" font-size="56" fill="#F4F6F8" text-anchor="middle" letter-spacing="6">VOLTEX</text>
                            <text x="130" y="185" font-family="'DM Sans', sans-serif" font-size="9" fill="#6B7280" text-anchor="middle" letter-spacing="4">PREMIUM ENERGY</text>
                            <text x="130" y="235" font-family="'Bebas Neue', sans-serif" font-size="16" fill="<?php echo $hero_accent; ?>" text-anchor="middle" letter-spacing="3">
                                <?php echo strtoupper(substr($produit_hero['nom'] ?? 'VOLTEX', 0, 20)); ?>
                            </text>
                            <path d="M118 260 L128 245 L128 255 L142 255 L132 270 L132 260 Z" fill="<?php echo $hero_accent; ?>"/>
                            <text x="130" y="310" font-family="'DM Sans', sans-serif" font-size="7.5" fill="#4a5165" text-anchor="middle" letter-spacing="2">160MG CAFÉINE · ZERO SUCRE · VITAMINES B</text>
                            <text x="130" y="390" font-family="'DM Sans', sans-serif" font-size="7" fill="#3a4055" text-anchor="middle" letter-spacing="1.5">500 ML · E500</text>
                            <ellipse cx="130" cy="58" rx="90" ry="28" fill="url(#topGrad)"/>
                            <ellipse cx="130" cy="50" rx="58" ry="16" fill="#2a3045"/>
                            <ellipse cx="130" cy="45" rx="38" ry="10" fill="#323850"/>
                            <ellipse cx="138" cy="42" rx="10" ry="5" fill="#404860" stroke="#505878" stroke-width="1"/>
                            <rect x="130" y="39" width="12" height="8" rx="2" fill="#454e6a"/>
                        </svg>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>

    <div class="scroll-hint" aria-hidden="true">
        <div class="scroll-dot"></div>
        <span>Scroller</span>
    </div>
</section>

<!-- ── TICKER BAND ─────────────────────────────────────────────── -->
<div class="ticker-band" aria-hidden="true">
    <div class="ticker-track">
        <template id="ticker-tpl">
            <span class="ticker-item">VOLTEX PREMIUM <span class="ticker-sep">✦</span></span>
            <span class="ticker-item">ZÉRO SUCRE <span class="ticker-sep">✦</span></span>
            <span class="ticker-item">LIVRAISON OFFERTE DÈS 50€ <span class="ticker-sep">✦</span></span>
            <span class="ticker-item">12 SAVEURS <span class="ticker-sep">✦</span></span>
            <span class="ticker-item">FORMULÉ EN FRANCE <span class="ticker-sep">✦</span></span>
            <span class="ticker-item">160MG CAFÉINE NATURELLE <span class="ticker-sep">✦</span></span>
        </template>
    </div>
</div>

<!-- ── PRODUCTS ───────────────────────────────────────────────── -->
<section id="products" aria-labelledby="products-heading">
    <div class="container">

        <div class="row align-items-end mb-5">
            <div class="col-md-8">
                <p class="section-label">Notre gamme</p>
                <h2 class="section-heading" id="products-heading">
                    LES <span class="volt-text">ESSENTIELS</span>
                </h2>
                <p class="muted-text mt-2" style="font-size:.9rem; color:var(--muted); max-width:480px;">
                    Chaque formule est pensée pour un usage précis. Performance, récupération ou clarté mentale — choisissez votre arme.
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="/produit/" class="btn btn-outline-volt">
                    Voir tout <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">

            <?php while ($p = $essentiels->fetch(PDO::FETCH_ASSOC)) :

                /* ── Première image du champ CSV ── */
                $imgs    = array_values(array_filter(array_map('trim', explode(',', $p['image'] ?? ''))));
                $img_src = $imgs[0] ?? '';
                $has_img = !empty($img_src);

                /* ── Identifiant ── */
                $id_p = $p['identifiant'];

                /* ── Couleur accent ── */
                $accent = '#C8FF00';
                if (str_contains($id_p, 'dark-forest')) $accent = '#8B5CF6';
                if (str_contains($id_p, 'arctic'))      $accent = '#00C8FF';
                if (str_contains($id_p, 'red-storm'))   $accent = '#FF4444';
                if (str_contains($id_p, 'tropical'))    $accent = '#FF9500';
                if (str_contains($id_p, 'midnight'))    $accent = '#4A5568';
                if (str_contains($id_p, 'berry'))       $accent = '#E040FB';
                if (str_contains($id_p, 'peach'))       $accent = '#FFB347';
                if (str_contains($id_p, 'yuzu'))        $accent = '#FFD700';
                if (str_contains($id_p, 'hydro'))       $accent = '#00E5FF';

                /* ── Badge ── */
                $badge_label = '';
                $badge_class = '';
                if (str_contains($id_p, 'electric-lemon') || str_contains($id_p, 'starter')) {
                    $badge_label = 'Best-seller';
                } elseif (str_contains($id_p, 'zen') || str_contains($id_p, 'midnight') || str_contains($id_p, 'yuzu')) {
                    $badge_label = 'Nouveau';
                    $badge_class = 'new-badge';
                } elseif (str_contains($id_p, 'pack') || str_contains($id_p, 'coffret')) {
                    $badge_label = '-20%';
                    $badge_class = 'promo-badge';
                }

                /* ── Prix TTC ── */
                $ttc = $p['prix_ht'] * (1 + (float)($p['taux_tva'] ?? 20) / 100);
                ?>

                <div class="col-sm-6 col-lg-3">
                    <article class="product-card" style="--accent: <?php echo $accent; ?>;">

                        <div class="product-img-wrap">

                            <?php if ($badge_label) : ?>
                                <span class="product-badge <?php echo $badge_class; ?>">
                                <?php echo $badge_label; ?>
                            </span>
                            <?php endif; ?>

                            <?php if ($has_img) : ?>
                                <img src="<?php echo htmlspecialchars($img_src); ?>"
                                     alt="<?php echo htmlspecialchars($p['nom']); ?>"
                                     class="product-real-img" />
                            <?php else : ?>
                                <svg width="100" height="200" viewBox="0 0 100 200"
                                     aria-label="<?php echo htmlspecialchars($p['nom']); ?>"
                                     role="img" class="product-can-img">
                                    <rect x="15" y="10" width="70" height="180" rx="12" fill="#1a1f2e"/>
                                    <rect x="15" y="80" width="70" height="4" fill="<?php echo $accent; ?>"/>
                                    <text x="50" y="65" font-family="'Bebas Neue'" font-size="13" fill="#F4F6F8" text-anchor="middle">VOLTEX</text>
                                    <text x="50" y="100" font-family="'Bebas Neue'" font-size="7" fill="<?php echo $accent; ?>" text-anchor="middle">
                                        <?php echo strtoupper(substr($p['nom'], 0, 14)); ?>
                                    </text>
                                    <path d="M43 115 L49 105 L49 112 L57 112 L51 122 L51 115Z" fill="<?php echo $accent; ?>"/>
                                    <ellipse cx="50" cy="9" rx="35" ry="10" fill="#252c3f"/>
                                </svg>
                            <?php endif; ?>

                            <div class="product-overlay">
                                <a href="/produit/<?php echo htmlspecialchars($id_p); ?>"
                                   class="product-overlay-btn"
                                   aria-label="Voir <?php echo htmlspecialchars($p['nom']); ?>">
                                    <i class="bi bi-eye me-1"></i> Voir le produit
                                </a>
                            </div>

                        </div>

                        <div class="product-body">
                            <div class="product-stars mb-1" aria-label="Note 4.8">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half-fill"></i>
                            </div>
                            <h3 class="product-name"><?php echo htmlspecialchars($p['nom']); ?></h3>
                            <p class="product-desc">
                                <?php
                                $desc = htmlspecialchars($p['description'] ?? '');
                                echo mb_strlen($desc) > 60 ? mb_substr($desc, 0, 60) . '…' : $desc;
                                ?>
                            </p>
                            <div class="product-meta">

                                <div class="product-meta">
                                    <div>
                                        <div class="product-price">
                                            <?php echo number_format($p['prix_ht'], 2, ',', ' '); ?>€
                                            <small>HT</small>
                                        </div>
                                        <div style="font-size:.7rem; color:var(--muted); margin-top:.1rem;">
                                            <?php echo number_format($ttc, 2, ',', ' '); ?>€ TTC
                                        </div>
                                    </div>

                                    <form method="POST"
                                          action="/produit/<?php echo htmlspecialchars($id_p); ?>">
                                        <input type="hidden" name="idPRoduit" value="<?php echo (int)$p['id']; ?>" />
                                        <input type="hidden" name="quantite"  value="1" />
                                        <button type="submit" class="product-add-btn"
                                                aria-label="Ajouter <?php echo htmlspecialchars($p['nom']); ?> au panier">
                                            <i class="bi bi-bag-plus me-1"></i> Ajouter
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </article>
                </div>

            <?php endwhile; ?>

        </div>
    </div>
</section>

<!-- ── MARQUEE BAND ────────────────────────────────────────────── -->
<div class="marquee-split" aria-hidden="true">
    <div class="marquee-track" id="marquee-track">
        <template id="marquee-tpl">
            <span class="marquee-item">Zéro Sucre <span class="marquee-dot"></span></span>
            <span class="marquee-item">Caféine Naturelle <span class="marquee-dot"></span></span>
            <span class="marquee-item">Vitamines B Complex <span class="marquee-dot"></span></span>
            <span class="marquee-item">L-Théanine <span class="marquee-dot"></span></span>
            <span class="marquee-item">Taurine <span class="marquee-dot"></span></span>
            <span class="marquee-item">Guarana Naturel <span class="marquee-dot"></span></span>
            <span class="marquee-item">Formulé en France <span class="marquee-dot"></span></span>
            <span class="marquee-item">ISO 22000 Certifié <span class="marquee-dot"></span></span>
        </template>
    </div>
</div>

<!-- ── INGREDIENTS ─────────────────────────────────────────────── -->
<section id="ingredients" aria-labelledby="ingredients-heading">
    <div class="container">

        <div class="row mb-5">
            <div class="col-lg-7">
                <p class="section-label">La formule VOLTEX</p>
                <h2 class="section-heading" id="ingredients-heading">
                    SCIENCE <span class="volt-text">& NATURE.</span>
                </h2>
            </div>
            <div class="col-lg-5 d-flex align-items-end">
                <p style="color:var(--muted); font-size:.88rem; line-height:1.8;">
                    Chaque ingrédient est sélectionné pour sa biodisponibilité et son efficacité démontrée. Aucun compromis, aucun déchet chimique.
                </p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="ingr-card">
                    <i class="bi bi-lightning-charge-fill ingr-icon"></i>
                    <h3 class="ingr-title">Caféine Naturelle</h3>
                    <p class="ingr-text">160mg extraits de graines de guarana et de café vert. Énergie progressive sans crash.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="ingr-card">
                    <i class="bi bi-brain ingr-icon"></i>
                    <h3 class="ingr-title">L-Théanine</h3>
                    <p class="ingr-text">Acide aminé du thé vert. Synergise avec la caféine pour une concentration calme et durable.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="ingr-card">
                    <i class="bi bi-heart-pulse-fill ingr-icon"></i>
                    <h3 class="ingr-title">Taurine Pure</h3>
                    <p class="ingr-text">1000mg par canette. Soutient le métabolisme énergétique et la performance cardiovasculaire.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="ingr-card">
                    <i class="bi bi-capsule ingr-icon"></i>
                    <h3 class="ingr-title">Vitamines B3 · B6 · B12</h3>
                    <p class="ingr-text">Complexe B complet pour la conversion des nutriments en énergie cellulaire.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="ingr-card">
                    <i class="bi bi-droplet-fill ingr-icon"></i>
                    <h3 class="ingr-title">Électrolytes</h3>
                    <p class="ingr-text">Sodium, potassium et magnésium pour l'hydratation et la prévention des crampes.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="ingr-card">
                    <i class="bi bi-shield-check ingr-icon"></i>
                    <h3 class="ingr-title">Zéro Sucre Ajouté</h3>
                    <p class="ingr-text">Édulcorants naturels (stévia) uniquement. Charge glycémique nulle, goût premium.</p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ── FEATURES ────────────────────────────────────────────────── -->
<section id="features" aria-labelledby="features-heading">
    <div class="container">

        <div class="text-center mb-5">
            <p class="section-label">Pourquoi VOLTEX</p>
            <h2 class="section-heading" id="features-heading">
                L'EXPÉRIENCE <span class="volt-text">SUPÉRIEURE.</span>
            </h2>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-xl-3">
                <div class="feature-item">
                    <div class="feature-icon-wrap"><i class="bi bi-truck"></i></div>
                    <div>
                        <h3 class="feature-title">Livraison Express</h3>
                        <p class="feature-text">Offerte dès 50€. Expédiée sous 24h, livrée en 48h partout en France.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="feature-item">
                    <div class="feature-icon-wrap"><i class="bi bi-recycle"></i></div>
                    <div>
                        <h3 class="feature-title">Canettes 100% Recyclées</h3>
                        <p class="feature-text">Aluminium issu de filières de recyclage certifiées. Empreinte carbone réduite de 70%.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="feature-item">
                    <div class="feature-icon-wrap"><i class="bi bi-patch-check-fill"></i></div>
                    <div>
                        <h3 class="feature-title">Certifié ISO 22000</h3>
                        <p class="feature-text">Production contrôlée en laboratoire agréé. Traçabilité totale de chaque ingrédient.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="feature-item">
                    <div class="feature-icon-wrap"><i class="bi bi-arrow-counterclockwise"></i></div>
                    <div>
                        <h3 class="feature-title">Retour 30 Jours</h3>
                        <p class="feature-text">Pas convaincu ? Retour intégral sans questions pour tout premier achat.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ── TESTIMONIALS ────────────────────────────────────────────── -->
<section id="testimonials" aria-labelledby="testimonials-heading">
    <div class="container">

        <div class="text-center mb-5">
            <p class="section-label">Ils l'ont adopté</p>
            <h2 class="section-heading" id="testimonials-heading">
                LEUR <span class="volt-text">VERDICT.</span>
            </h2>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="testi-card">
                    <span class="testi-quote">"</span>
                    <p class="testi-text">Le seul energy drink que je bois avant mes séances de natation. L'effet est précis, sans les tremblements que j'avais avec d'autres marques.</p>
                    <div class="d-flex align-items-center gap-3">
                        <div class="testi-avatar">ML</div>
                        <div>
                            <div class="testi-name">Marc L.</div>
                            <div class="testi-role">Nageur compétitif · Lyon</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testi-card">
                    <span class="testi-quote">"</span>
                    <p class="testi-text">En startup, les nuits blanches sont monnaie courante. VOLTEX Dark Forest est devenu un rituel. La clarté mentale qu'il procure est incomparable.</p>
                    <div class="d-flex align-items-center gap-3">
                        <div class="testi-avatar" style="background: linear-gradient(135deg,#8B5CF6,#00C8FF);">SR</div>
                        <div>
                            <div class="testi-name">Sophie R.</div>
                            <div class="testi-role">Fondatrice · Paris</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testi-card">
                    <span class="testi-quote">"</span>
                    <p class="testi-text">J'ai essayé tous les energy drinks du marché. Voltex est dans une autre catégorie — goût premium, zéro sucre, et ça tient vraiment ses promesses.</p>
                    <div class="d-flex align-items-center gap-3">
                        <div class="testi-avatar" style="background: linear-gradient(135deg,#00C8FF,#C8FF00);">KD</div>
                        <div>
                            <div class="testi-name">Karim D.</div>
                            <div class="testi-role">Esportif professionnel · Bordeaux</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trust bar -->
        <div class="row mt-5 pt-4" style="border-top:1px solid var(--border);">
            <div class="col-6 col-md-3 text-center py-3">
                <div style="font-family:var(--font-display);font-size:2.4rem;color:var(--volt);">4.9★</div>
                <div class="muted-text" style="font-size:.75rem;letter-spacing:.12em;">Note moyenne</div>
            </div>
            <div class="col-6 col-md-3 text-center py-3" style="border-left:1px solid var(--border);">
                <div style="font-family:var(--font-display);font-size:2.4rem;color:var(--volt);">2 400+</div>
                <div class="muted-text" style="font-size:.75rem;letter-spacing:.12em;">Avis vérifiés</div>
            </div>
            <div class="col-6 col-md-3 text-center py-3" style="border-left:1px solid var(--border);">
                <div style="font-family:var(--font-display);font-size:2.4rem;color:var(--volt);">98%</div>
                <div class="muted-text" style="font-size:.75rem;letter-spacing:.12em;">Recommandent</div>
            </div>
            <div class="col-6 col-md-3 text-center py-3" style="border-left:1px solid var(--border);">
                <div style="font-family:var(--font-display);font-size:2.4rem;color:var(--volt);">50k+</div>
                <div class="muted-text" style="font-size:.75rem;letter-spacing:.12em;">Clients actifs</div>
            </div>
        </div>

    </div>
</section>

<!-- ── NEWSLETTER ──────────────────────────────────────────────── -->
<section id="newsletter" aria-labelledby="newsletter-heading">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <p class="section-label">Restez dans la zone</p>
                <h2 class="newsletter-heading" id="newsletter-heading">
                    REJOIGNEZ<br />L'ÉLITE <span class="volt-text">VOLTEX.</span>
                </h2>
                <p style="color:var(--muted);font-size:.88rem;line-height:1.8;margin-top:1rem;max-width:400px;">
                    Accès prioritaire aux nouveautés, offres exclusives et contenu derrière les coulisses. Zéro spam. Désinscription en un clic.
                </p>
            </div>
            <div class="col-lg-6">
                <form class="d-flex gap-2 flex-column flex-sm-row" novalidate
                      aria-label="Formulaire d'inscription newsletter">
                    <label for="email-news" class="visually-hidden">Votre adresse e-mail</label>
                    <input type="email" id="email-news" class="input-volt"
                           placeholder="votre@email.com" required autocomplete="email" />
                    <button type="submit" class="btn btn-volt flex-shrink-0">
                        S'inscrire <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </form>
                <p style="font-size:.7rem;color:var(--muted);margin-top:.75rem;">
                    En vous inscrivant, vous acceptez notre
                    <a href="#" style="color:var(--muted);text-decoration:underline;">politique de confidentialité</a>.
                    Données hébergées en France.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ══ STYLES SPÉCIFIQUES PAGE ACCUEIL ═══════════════════════════ -->
<style>
    /* Product cards overlay & image (spécifique accueil si pas dans inc.head) */
    .product-overlay { position:absolute; inset:0; background:rgba(8,10,15,.7); display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity var(--transition); z-index:3; }
    .product-card:hover .product-overlay { opacity:1; }
    .product-overlay-btn { background:var(--volt); color:var(--night); font-size:.72rem; font-weight:800; letter-spacing:.14em; text-transform:uppercase; padding:.65rem 1.4rem; border-radius:2px; text-decoration:none; transition:background var(--transition); }
    .product-overlay-btn:hover { background:var(--volt-dim); }
    .product-real-img { height:180px; object-fit:contain; filter:drop-shadow(0 8px 24px rgba(200,255,0,.15)); transition:transform var(--transition); }
    .product-card:hover .product-real-img { transform:scale(1.06) rotate(-3deg); }
    .product-card { position:relative; }
    .product-card::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; background:var(--accent,var(--volt)); transform:scaleX(0); transition:transform var(--transition); z-index:1; }
    .product-card:hover::before { transform:scaleX(1); }
    .product-badge.new-badge   { background:#00C8FF; color:var(--night); }
    .product-badge.promo-badge { background:#FF4444; color:#fff; }
</style>

<!-- ══ SCRIPTS SPÉCIFIQUES PAGE ACCUEIL ══════════════════════════ -->
<script>
    /* ── Ticker band ── */
    (function () {
        const tpl   = document.getElementById('ticker-tpl');
        const track = document.querySelector('.ticker-track');
        if (!tpl || !track) return;
        track.appendChild(tpl.content.cloneNode(true));
        track.appendChild(tpl.content.cloneNode(true));
    })();

    /* ── Marquee band ── */
    (function () {
        const tpl   = document.getElementById('marquee-tpl');
        const track = document.getElementById('marquee-track');
        if (!tpl || !track) return;
        track.appendChild(tpl.content.cloneNode(true));
        track.appendChild(tpl.content.cloneNode(true));
    })();

    /* ── Add to cart feedback ── */
    document.querySelectorAll('.product-add-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const original = this.innerHTML;
            this.innerHTML = '<i class="bi bi-check2 me-1"></i> Ajouté !';
            this.style.background = 'var(--volt-dim)';
            setTimeout(() => { this.innerHTML = original; this.style.background = ''; }, 1600);
        });
    });

    /* ── Newsletter submit ── */
    document.querySelector('#newsletter form').addEventListener('submit', function (e) {
        e.preventDefault();
        const input = this.querySelector('input');
        const btn   = this.querySelector('button');
        if (!input.value) return;
        btn.innerHTML = '<i class="bi bi-check2 me-1"></i> Inscrit !';
        btn.disabled  = true;
        input.value   = '';
        setTimeout(() => {
            btn.innerHTML = 'S\'inscrire <i class="bi bi-arrow-right ms-1"></i>';
            btn.disabled  = false;
        }, 3000);
    });

    /* ── Scroll-reveal ── */
    if ('IntersectionObserver' in window) {
        const obs = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity   = '1';
                    entry.target.style.transform = 'translateY(0)';
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: .12 });

        document.querySelectorAll('.product-card, .ingr-card, .feature-item, .testi-card').forEach((el, i) => {
            el.style.opacity   = '0';
            el.style.transform = 'translateY(28px)';
            el.style.transition = `opacity .6s ease ${i * .08}s, transform .6s ease ${i * .08}s, border-color .35s, box-shadow .35s`;
            obs.observe(el);
        });
    }
</script>
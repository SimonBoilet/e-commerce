<!-- ══ MAIN ════════════════════════════════════════════════════════ -->

<!-- ── PAGE HERO ─────────────────────────────────────────────────── -->
<section id="page-hero" aria-labelledby="page-hero-heading">
    <div class="page-hero-bg" aria-hidden="true"></div>
    <div class="page-hero-grid" aria-hidden="true"></div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <p class="section-label">Boutique VOLTEX</p>
                <h1 class="section-heading" id="page-hero-heading" style="font-size: clamp(3rem, 8vw, 6.5rem);">
                    TOUS LES <span class="volt-text">PRODUITS</span>
                </h1>
                <p style="color: var(--muted); font-size: .95rem; line-height: 1.8; max-width: 500px; margin-top: .8rem;">
                    <?php echo $lstProduit->rowCount(); ?> références disponibles — canettes premium, packs et accessoires.
                </p>
            </div>
            <div class="col-lg-4 d-none d-lg-flex justify-content-end align-items-center gap-4">
                <div class="text-end">
                    <div style="font-family: var(--font-display); font-size: 2.2rem; color: var(--volt); line-height: 1;">20</div>
                    <div class="muted-text" style="letter-spacing: .1em; text-transform: uppercase; font-size: .7rem;">Références</div>
                </div>
                <div style="width: 1px; height: 40px; background: var(--border);"></div>
                <div class="text-end">
                    <div style="font-family: var(--font-display); font-size: 2.2rem; color: var(--volt); line-height: 1;">3</div>
                    <div class="muted-text" style="letter-spacing: .1em; text-transform: uppercase; font-size: .7rem;">Gammes</div>
                </div>
            </div>
        </div>
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

<!-- ── CATALOGUE ──────────────────────────────────────────────────── -->
<section id="catalogue" aria-labelledby="catalogue-heading" style="padding: 5rem 0;">
    <div class="container">

        <!-- Barre de filtres -->
        <div class="catalogue-toolbar d-flex flex-wrap align-items-center justify-content-between gap-3 mb-5">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span style="font-size: .7rem; letter-spacing: .2em; text-transform: uppercase; color: var(--muted);">Filtrer :</span>
                <button class="filter-btn active" data-filter="tous">Tous</button>
                <button class="filter-btn" data-filter="canette">Canettes</button>
                <button class="filter-btn" data-filter="pack">Packs</button>
                <button class="filter-btn" data-filter="hydro">Hydro Volt</button>
                <button class="filter-btn" data-filter="accessoire">Accessoires</button>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="catalogue-search-wrap">
                    <i class="bi bi-search catalogue-search-icon"></i>
                    <input type="text" id="catalogue-search" class="catalogue-search"
                           placeholder="Rechercher un produit…"
                           aria-label="Rechercher un produit" />
                </div>
                <div class="d-flex gap-2">
                    <button class="view-btn active" id="view-grid" aria-label="Vue grille"><i class="bi bi-grid-3x3-gap"></i></button>
                    <button class="view-btn"        id="view-list" aria-label="Vue liste"><i class="bi bi-list-ul"></i></button>
                </div>
            </div>
        </div>

        <!-- Grille produits -->
        <div class="row g-4" id="products-grid">

            <?php
            $lstProduit->execute();

            while ($produit = $lstProduit->fetch(PDO::FETCH_ASSOC)) :

                /* ── Première image du champ (valeurs séparées par virgule) ── */
                $images       = array_map('trim', explode(',', $produit['image'] ?? ''));
                $premiere_img = $images[0] ?? '';
                $img_path     = $premiere_img;                    // ← chemin déjà complet
                $has_img      = !empty($premiere_img) && file_exists($img_path);

                /* ── Identifiant pour l'URL ── */
                $identifiant = $produit['identifiant'];

                /* ── Catégorie ── */
                $categorie = 'canette';
                if (str_contains($identifiant, 'pack') || str_contains($identifiant, 'coffret') || str_contains($identifiant, 'abonnement')) {
                    $categorie = 'pack';
                } elseif (str_contains($identifiant, 'hydro')) {
                    $categorie = 'hydro';
                } elseif (str_contains($identifiant, 'shaker') || str_contains($identifiant, 'tshirt')) {
                    $categorie = 'accessoire';
                }

                /* ── Badge ── */
                $badge_html = '';
                if (str_contains($identifiant, 'starter') || str_contains($identifiant, 'electric-lemon')) {
                    $badge_html = '<span class="product-badge">Best-seller</span>';
                } elseif (str_contains($identifiant, 'zen') || str_contains($identifiant, 'midnight') || str_contains($identifiant, 'yuzu')) {
                    $badge_html = '<span class="product-badge new-badge">Nouveau</span>';
                } elseif (str_contains($identifiant, 'pack') || str_contains($identifiant, 'coffret')) {
                    $badge_html = '<span class="product-badge promo-badge">-20%</span>';
                }

                /* ── Couleur accent ── */
                $accent = '#C8FF00';
                if (str_contains($identifiant, 'dark-forest')) $accent = '#8B5CF6';
                if (str_contains($identifiant, 'arctic'))      $accent = '#00C8FF';
                if (str_contains($identifiant, 'red-storm'))   $accent = '#FF4444';
                if (str_contains($identifiant, 'tropical'))    $accent = '#FF9500';
                if (str_contains($identifiant, 'midnight'))    $accent = '#4A5568';
                if (str_contains($identifiant, 'berry'))       $accent = '#E040FB';
                if (str_contains($identifiant, 'peach'))       $accent = '#FFB347';
                if (str_contains($identifiant, 'yuzu'))        $accent = '#FFD700';
                if (str_contains($identifiant, 'hydro'))       $accent = '#00E5FF';

                /* ── Statut ── */
                $is_brouillon = ($produit['statut'] === 'brouillon');
                ?>

                <div class="col-sm-6 col-lg-4 col-xl-3 product-col"
                     data-categorie="<?php echo $categorie; ?>"
                     data-nom="<?php echo strtolower(htmlspecialchars($produit['nom'])); ?>">

                    <article class="product-card <?php echo $is_brouillon ? 'product-card--draft' : ''; ?>"
                             style="--accent: <?php echo $accent; ?>;">

                        <?php if ($is_brouillon) : ?>
                            <div class="draft-ribbon" aria-label="Brouillon">Brouillon</div>
                        <?php endif; ?>

                        <!-- Visuel -->
                        <div class="product-img-wrap">
                            <?php echo $badge_html; ?>
                            <span class="product-flavour-tag"><?php echo ucfirst($categorie); ?></span>

                            <?php if ($has_img) : ?>
                                <img src="<?php echo htmlspecialchars($img_path); ?>"
                                     alt="<?php echo htmlspecialchars($produit['nom']); ?>"
                                     class="product-real-img" />
                            <?php else : ?>
                                <svg width="100" height="200" viewBox="0 0 100 200"
                                     aria-label="<?php echo htmlspecialchars($produit['nom']); ?>"
                                     role="img" class="product-can-img">
                                    <rect x="15" y="10" width="70" height="180" rx="12" fill="#1a1f2e"/>
                                    <rect x="15" y="80" width="70" height="4" fill="<?php echo $accent; ?>"/>
                                    <text x="50" y="65" font-family="'Bebas Neue'" font-size="13" fill="#F4F6F8" text-anchor="middle">VOLTEX</text>
                                    <text x="50" y="100" font-family="'Bebas Neue'" font-size="7" fill="<?php echo $accent; ?>" text-anchor="middle">
                                        <?php echo strtoupper(substr($produit['nom'], 0, 14)); ?>
                                    </text>
                                    <path d="M43 115 L49 105 L49 112 L57 112 L51 122 L51 115Z" fill="<?php echo $accent; ?>"/>
                                    <ellipse cx="50" cy="9" rx="35" ry="10" fill="#252c3f"/>
                                </svg>
                            <?php endif; ?>

                            <!-- Overlay — URL avec identifiant texte -->
                            <div class="product-overlay">
                                <a href="/produit/<?php echo htmlspecialchars($identifiant); ?>"
                                   class="product-overlay-btn"
                                   aria-label="Voir <?php echo htmlspecialchars($produit['nom']); ?>">
                                    <i class="bi bi-eye me-1"></i> Voir le produit
                                </a>
                            </div>
                        </div>

                        <!-- Infos -->
                        <div class="product-body">
                            <div class="product-stars mb-1" aria-label="Note 4.8 sur 5">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half-fill"></i>
                            </div>

                            <h2 class="product-name"><?php echo htmlspecialchars($produit['nom']); ?></h2>

                            <p class="product-desc">
                                <?php
                                $desc = htmlspecialchars($produit['description'] ?? '');
                                echo mb_strlen($desc) > 60 ? mb_substr($desc, 0, 60) . '…' : $desc;
                                ?>
                            </p>

                            <div class="product-meta">
                                <div class="product-meta">
                                    <div>
                                        <div class="product-price">
                                            <?php echo number_format($produit['prix_ht'], 2, ',', ' '); ?>€
                                            <small>HT</small>
                                        </div>
                                    </div>

                                    <?php if (!$is_brouillon) : ?>
                                        <form method="POST"
                                              action="/produit/<?php echo htmlspecialchars($identifiant); ?>">
                                            <input type="hidden" name="idPRoduit" value="<?php echo (int)$produit['id']; ?>" />
                                            <input type="hidden" name="quantite"  value="1" />
                                            <button type="submit" class="product-add-btn"
                                                    aria-label="Ajouter <?php echo htmlspecialchars($produit['nom']); ?> au panier">
                                                <i class="bi bi-bag-plus me-1"></i> Ajouter
                                            </button>
                                        </form>
                                    <?php else : ?>
                                        <button class="product-add-btn" disabled>
                                            <i class="bi bi-bag-plus me-1"></i> Ajouter
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </article>
                </div>

            <?php endwhile; ?>

        </div>

        <div id="no-results" class="text-center py-5" style="display: none;" aria-live="polite">
            <i class="bi bi-search" style="font-size: 2.5rem; color: var(--muted); display: block; margin-bottom: 1rem;"></i>
            <p style="color: var(--muted); font-size: .95rem;">Aucun produit ne correspond à votre recherche.</p>
            <button class="btn btn-outline-volt mt-3" onclick="resetFilters()">Réinitialiser les filtres</button>
        </div>

    </div>
</section>

<!-- ── BANDEAU CTA ─────────────────────────────────────────────── -->
<section style="background: var(--surface); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 3.5rem 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <p class="section-label">Offre du moment</p>
                <h2 style="font-family: var(--font-display); font-size: clamp(1.8rem, 4vw, 3rem); margin: 0;">
                    LIVRAISON OFFERTE <span class="volt-text">DÈS 50€</span> D'ACHAT
                </h2>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <a href="/produit/" class="btn btn-volt">
                    Composer mon panier <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ══ STYLES ═════════════════════════════════════════════════════ -->
<style>
    #page-hero { padding: 9rem 0 4rem; position: relative; overflow: hidden; background: var(--night); }
    .page-hero-bg { position: absolute; inset: 0; background: radial-gradient(ellipse 50% 70% at 80% 50%, rgba(200,255,0,.06) 0%, transparent 65%), var(--night); }
    .page-hero-grid { position: absolute; inset: 0; background-image: linear-gradient(rgba(200,255,0,.03) 1px, transparent 1px), linear-gradient(90deg, rgba(200,255,0,.03) 1px, transparent 1px); background-size: 60px 60px; mask-image: radial-gradient(ellipse 100% 100% at 100% 50%, black 0%, transparent 70%); }

    .catalogue-toolbar { padding: 1.2rem 1.5rem; background: var(--card-bg); border: 1px solid var(--border); border-radius: 4px; }
    .filter-btn { background: transparent; border: 1px solid var(--border); color: var(--muted); font-size: .68rem; font-weight: 600; letter-spacing: .15em; text-transform: uppercase; padding: .4rem .9rem; border-radius: 2px; cursor: pointer; transition: all var(--transition); }
    .filter-btn:hover { border-color: rgba(200,255,0,.4); color: var(--white); }
    .filter-btn.active { background: var(--volt); border-color: var(--volt); color: var(--night); font-weight: 800; }
    .catalogue-search-wrap { position: relative; display: flex; align-items: center; }
    .catalogue-search-icon { position: absolute; left: .85rem; color: var(--muted); font-size: .9rem; pointer-events: none; }
    .catalogue-search { background: rgba(255,255,255,.05); border: 1px solid var(--border); color: var(--white); border-radius: 2px; padding: .5rem .9rem .5rem 2.3rem; font-family: var(--font-body); font-size: .82rem; width: 220px; transition: border-color var(--transition), background var(--transition); }
    .catalogue-search:focus { outline: none; border-color: var(--volt); background: rgba(200,255,0,.04); color: var(--white); }
    .catalogue-search::placeholder { color: var(--muted); }
    .view-btn { background: transparent; border: 1px solid var(--border); color: var(--muted); width: 34px; height: 34px; border-radius: 2px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all var(--transition); font-size: .9rem; }
    .view-btn.active, .view-btn:hover { border-color: var(--volt); color: var(--volt); }

    .product-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 4px; overflow: hidden; transition: transform var(--transition), border-color var(--transition), box-shadow var(--transition); cursor: pointer; position: relative; }
    .product-card:hover { transform: translateY(-6px); border-color: rgba(200,255,0,.35); box-shadow: 0 20px 60px rgba(200,255,0,.08); }
    .product-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: var(--accent, var(--volt)); transform: scaleX(0); transition: transform var(--transition); }
    .product-card:hover::before { transform: scaleX(1); }
    .product-card--draft { opacity: .6; }
    .product-card--draft:hover { transform: none; box-shadow: none; border-color: var(--border); }
    .draft-ribbon { position: absolute; top: 14px; right: -22px; background: var(--muted); color: var(--white); font-size: .58rem; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; padding: .2rem 2rem; transform: rotate(45deg); z-index: 5; }
    .product-img-wrap { position: relative; background: linear-gradient(135deg, #0a0d14 0%, #131826 100%); display: flex; align-items: center; justify-content: center; height: 240px; overflow: hidden; }
    .product-real-img { height: 180px; object-fit: contain; filter: drop-shadow(0 8px 24px rgba(200,255,0,.15)); transition: transform var(--transition); }
    .product-card:hover .product-real-img, .product-card:hover .product-can-img { transform: scale(1.06) rotate(-3deg); }
    .product-badge { position: absolute; top: .9rem; left: .9rem; background: var(--volt); color: var(--night); font-size: .58rem; font-weight: 800; letter-spacing: .15em; text-transform: uppercase; padding: .2rem .55rem; border-radius: 1px; z-index: 2; }
    .product-badge.new-badge { background: #00C8FF; color: var(--night); }
    .product-badge.promo-badge { background: #FF4444; color: #fff; }
    .product-flavour-tag { position: absolute; bottom: .9rem; right: .9rem; font-size: .58rem; letter-spacing: .15em; text-transform: uppercase; color: var(--muted); border: 1px solid var(--border); padding: .18rem .55rem; border-radius: 2px; background: rgba(8,10,15,.6); z-index: 2; }
    .product-overlay { position: absolute; inset: 0; background: rgba(8,10,15,.7); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity var(--transition); z-index: 3; }
    .product-card:hover .product-overlay { opacity: 1; }
    .product-overlay-btn { background: var(--volt); color: var(--night); font-size: .72rem; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; padding: .65rem 1.4rem; border-radius: 2px; text-decoration: none; transition: background var(--transition), transform var(--transition); }
    .product-overlay-btn:hover { background: var(--volt-dim); transform: translateY(-2px); }
    .product-body { padding: 1.2rem; }
    .product-stars { color: var(--volt); font-size: .72rem; }
    .product-name { font-family: var(--font-display); font-size: 1.25rem; letter-spacing: .05em; margin-bottom: .2rem; }
    .product-desc { font-size: .8rem; color: var(--muted); line-height: 1.6; margin-bottom: .9rem; min-height: 52px; }
    .product-meta { display: flex; align-items: flex-end; justify-content: space-between; gap: .5rem; }
    .product-price { font-family: var(--font-display); font-size: 1.4rem; color: var(--volt); line-height: 1; }
    .product-price small { font-family: var(--font-body); font-size: .62rem; color: var(--muted); letter-spacing: .1em; }
    .product-add-btn { background: var(--volt); color: var(--night); border: none; font-size: .68rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; padding: .5rem 1rem; border-radius: 2px; white-space: nowrap; transition: all var(--transition); flex-shrink: 0; cursor: pointer; }
    .product-add-btn:hover:not(:disabled) { background: var(--volt-dim); transform: translateY(-1px); }
    .product-add-btn:disabled { background: var(--muted); cursor: not-allowed; opacity: .5; }
    #products-grid.list-view .product-col { width: 100%; max-width: 100%; flex: 0 0 100%; }
    #products-grid.list-view .product-card { display: flex; flex-direction: row; }
    #products-grid.list-view .product-img-wrap { width: 200px; min-width: 200px; height: auto; flex-shrink: 0; }
    #products-grid.list-view .product-body { flex: 1; display: flex; flex-direction: column; justify-content: space-between; }
    #products-grid.list-view .product-desc { min-height: auto; }
    #products-grid.list-view .product-overlay { display: none; }
    #no-results { color: var(--muted); }
</style>

<!-- ══ SCRIPTS ════════════════════════════════════════════════════ -->
<script>
    (function () {
        const tpl = document.getElementById('ticker-tpl');
        const track = document.querySelector('.ticker-track');
        if (!tpl || !track) return;
        track.appendChild(tpl.content.cloneNode(true));
        track.appendChild(tpl.content.cloneNode(true));
    })();

    const filterBtns  = document.querySelectorAll('.filter-btn');
    const productCols = document.querySelectorAll('.product-col');
    let activeFilter  = 'tous';
    let searchQuery   = '';

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            activeFilter = btn.dataset.filter;
            applyFilters();
        });
    });

    document.getElementById('catalogue-search').addEventListener('input', function () {
        searchQuery = this.value.toLowerCase().trim();
        applyFilters();
    });

    function applyFilters() {
        let visible = 0;
        productCols.forEach(col => {
            const show = (activeFilter === 'tous' || col.dataset.categorie === activeFilter)
                && (searchQuery === '' || col.dataset.nom.includes(searchQuery));
            col.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        document.getElementById('no-results').style.display = visible === 0 ? 'block' : 'none';
    }

    function resetFilters() {
        searchQuery = ''; activeFilter = 'tous';
        document.getElementById('catalogue-search').value = '';
        filterBtns.forEach(b => b.classList.remove('active'));
        document.querySelector('[data-filter="tous"]').classList.add('active');
        applyFilters();
    }

    document.getElementById('view-grid').addEventListener('click', function () {
        document.getElementById('products-grid').classList.remove('list-view');
        this.classList.add('active');
        document.getElementById('view-list').classList.remove('active');
    });
    document.getElementById('view-list').addEventListener('click', function () {
        document.getElementById('products-grid').classList.add('list-view');
        this.classList.add('active');
        document.getElementById('view-grid').classList.remove('active');
    });

    document.querySelectorAll('.product-add-btn:not(:disabled)').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const original = this.innerHTML;
            this.innerHTML = '<i class="bi bi-check2 me-1"></i> Ajouté !';
            this.style.background = 'var(--volt-dim)';
            setTimeout(() => { this.innerHTML = original; this.style.background = ''; }, 1600);
        });
    });

    if ('IntersectionObserver' in window) {
        const obs = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) { e.target.style.opacity = '1'; e.target.style.transform = 'translateY(0)'; obs.unobserve(e.target); }
            });
        }, { threshold: .1 });
        document.querySelectorAll('.product-col').forEach((el, i) => {
            el.style.opacity = '0'; el.style.transform = 'translateY(24px)';
            el.style.transition = `opacity .55s ease ${i * .06}s, transform .55s ease ${i * .06}s`;
            obs.observe(el);
        });
    }
</script>
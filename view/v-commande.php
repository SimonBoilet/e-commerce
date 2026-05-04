<!-- ══ MAIN ════════════════════════════════════════════════════════ -->

<nav aria-label="Fil d'Ariane" style="padding: 6.5rem 0 0; background: var(--night);">
    <div class="container">
        <ol class="breadcrumb-volt">
            <li><a href="index.php">Accueil</a></li>
            <li aria-hidden="true"><i class="bi bi-chevron-right"></i></li>
            <li><a href="/panier/">Panier</a></li>
            <li aria-hidden="true"><i class="bi bi-chevron-right"></i></li>
            <li aria-current="page">Coordonnées</li>
        </ol>
    </div>
</nav>

<section style="padding: 3rem 0 6rem; background: var(--night);">
    <div class="container">

        <p class="section-label">Étape 1 / 2</p>
        <h1 style="font-family:var(--font-display); font-size:clamp(2rem,5vw,4rem); line-height:1; margin-bottom:2.5rem;">
            VOS <span class="volt-text">COORDONNÉES</span>
        </h1>

        <form method="POST" action="/commande/" novalidate>
            <div class="row g-5">

                <!-- ── Facturation ── -->
                <div class="col-lg-6">
                    <h2 class="form-section-title">
                        <i class="bi bi-receipt me-2"></i> Adresse de facturation
                    </h2>

                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label-volt" for="f_nom">Nom *</label>
                            <input type="text" id="f_nom" name="facturation_nom"
                                   class="input-volt w-100" required placeholder="Dupont" />
                        </div>
                        <div class="col-6">
                            <label class="form-label-volt" for="f_prenom">Prénom *</label>
                            <input type="text" id="f_prenom" name="facturation_prenom"
                                   class="input-volt w-100" required placeholder="Jean" />
                        </div>
                        <div class="col-12">
                            <label class="form-label-volt" for="f_email">E-mail *</label>
                            <input type="email" id="f_email" name="facturation_email"
                                   class="input-volt w-100" required placeholder="jean@email.com" />
                        </div>
                        <div class="col-12">
                            <label class="form-label-volt" for="f_tel">Téléphone *</label>
                            <input type="tel" id="f_tel" name="facturation_telephone"
                                   class="input-volt w-100" required placeholder="06 00 00 00 00" />
                        </div>
                        <div class="col-12">
                            <label class="form-label-volt" for="f_adresse">Adresse *</label>
                            <input type="text" id="f_adresse" name="facturation_adresse"
                                   class="input-volt w-100" required placeholder="12 rue de la Paix" />
                        </div>
                        <div class="col-12">
                            <label class="form-label-volt" for="f_complement">Complément</label>
                            <input type="text" id="f_complement" name="facturation_complement"
                                   class="input-volt w-100" placeholder="Bât A, étage 2..." />
                        </div>
                        <div class="col-4">
                            <label class="form-label-volt" for="f_cp">Code postal *</label>
                            <input type="text" id="f_cp" name="facturation_code_postal"
                                   class="input-volt w-100" required placeholder="75001" />
                        </div>
                        <div class="col-8">
                            <label class="form-label-volt" for="f_ville">Ville *</label>
                            <input type="text" id="f_ville" name="facturation_ville"
                                   class="input-volt w-100" required placeholder="Paris" />
                        </div>
                    </div>

                    <!-- Case "même adresse" -->
                    <div class="same-address-wrap mt-4">
                        <label class="same-address-label">
                            <input type="checkbox" name="same_address" id="same_address"
                                   value="1" checked />
                            <span>Adresse de livraison identique à la facturation</span>
                        </label>
                    </div>
                </div>

                <!-- ── Livraison ── -->
                <div class="col-lg-6" id="livraison-section" style="display:none;">
                    <h2 class="form-section-title">
                        <i class="bi bi-truck me-2"></i> Adresse de livraison
                    </h2>

                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label-volt" for="l_nom">Nom</label>
                            <input type="text" id="l_nom" name="livraison_nom"
                                   class="input-volt w-100" placeholder="Dupont" />
                        </div>
                        <div class="col-6">
                            <label class="form-label-volt" for="l_prenom">Prénom</label>
                            <input type="text" id="l_prenom" name="livraison_prenom"
                                   class="input-volt w-100" placeholder="Jean" />
                        </div>
                        <div class="col-12">
                            <label class="form-label-volt" for="l_email">E-mail</label>
                            <input type="email" id="l_email" name="livraison_email"
                                   class="input-volt w-100" placeholder="jean@email.com" />
                        </div>
                        <div class="col-12">
                            <label class="form-label-volt" for="l_tel">Téléphone</label>
                            <input type="tel" id="l_tel" name="livraison_telephone"
                                   class="input-volt w-100" placeholder="06 00 00 00 00" />
                        </div>
                        <div class="col-12">
                            <label class="form-label-volt" for="l_adresse">Adresse</label>
                            <input type="text" id="l_adresse" name="livraison_adresse"
                                   class="input-volt w-100" placeholder="12 rue de la Paix" />
                        </div>
                        <div class="col-12">
                            <label class="form-label-volt" for="l_complement">Complément</label>
                            <input type="text" id="l_complement" name="livraison_complement"
                                   class="input-volt w-100" placeholder="Bât A, étage 2..." />
                        </div>
                        <div class="col-4">
                            <label class="form-label-volt" for="l_cp">Code postal</label>
                            <input type="text" id="l_cp" name="livraison_code_postal"
                                   class="input-volt w-100" placeholder="75001" />
                        </div>
                        <div class="col-8">
                            <label class="form-label-volt" for="l_ville">Ville</label>
                            <input type="text" id="l_ville" name="livraison_ville"
                                   class="input-volt w-100" placeholder="Paris" />
                        </div>
                    </div>
                </div>

                <!-- ── Récap & bouton ── -->
                <div class="col-12">
                    <div class="commande-footer">
                        <a href="/panier/" class="btn btn-outline-volt">
                            <i class="bi bi-arrow-left me-1"></i> Retour au panier
                        </a>
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <div style="text-align:right;">
                                <div style="font-size:.68rem; letter-spacing:.18em; text-transform:uppercase; color:var(--muted);">Total à payer</div>
                                <div style="font-family:var(--font-display); font-size:1.8rem; color:var(--volt); line-height:1;">
                                    <?php echo number_format($total_ttc_commande, 2, ',', ' '); ?>€
                                    <small style="font-family:var(--font-body); font-size:.65rem; color:var(--muted);">TTC</small>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-volt" style="padding:.9rem 2.2rem;">
                                <i class="bi bi-lock-fill me-2"></i>
                                Procéder au paiement
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</section>

<style>
    .breadcrumb-volt { display:flex; align-items:center; gap:.5rem; list-style:none; margin:0; padding:0; font-size:.75rem; color:var(--muted); }
    .breadcrumb-volt a { color:var(--muted); text-decoration:none; transition:color var(--transition); }
    .breadcrumb-volt a:hover { color:var(--volt); }
    .breadcrumb-volt li:last-child { color:var(--white); }
    .breadcrumb-volt i { font-size:.6rem; }

    .form-section-title { font-family:var(--font-display); font-size:1.3rem; letter-spacing:.06em; margin-bottom:1.2rem; color:var(--white); }
    .form-label-volt { font-size:.65rem; font-weight:700; letter-spacing:.18em; text-transform:uppercase; color:var(--muted); display:block; margin-bottom:.35rem; }
    .input-volt { background:rgba(255,255,255,.04); border:1px solid var(--border); color:var(--white); border-radius:2px; padding:.65rem 1rem; font-family:var(--font-body); font-size:.88rem; transition:border-color var(--transition), background var(--transition); }
    .input-volt:focus { outline:none; border-color:var(--volt); background:rgba(200,255,0,.04); color:var(--white); }
    .input-volt::placeholder { color:var(--muted); }

    .same-address-wrap { background:var(--card-bg); border:1px solid var(--border); border-radius:4px; padding:1rem 1.2rem; }
    .same-address-label { display:flex; align-items:center; gap:.8rem; cursor:pointer; font-size:.85rem; color:var(--white); }
    .same-address-label input[type=checkbox] { accent-color:var(--volt); width:16px; height:16px; cursor:pointer; }

    .commande-footer { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1.2rem; padding:1.5rem; background:var(--card-bg); border:1px solid var(--border); border-radius:4px; margin-top:1rem; }
</style>

<script>
    /* ── Toggle adresse livraison ── */
    const checkbox   = document.getElementById('same_address');
    const livSection = document.getElementById('livraison-section');

    function toggleLivraison() {
        livSection.style.display = checkbox.checked ? 'none' : 'block';
    }

    checkbox.addEventListener('change', toggleLivraison);
    toggleLivraison(); // état initial
</script>
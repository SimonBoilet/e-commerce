<?php require_once 'Backoffice/view/v-bo-layout-head.php'; ?>

    <div class="bo-topbar">
        <div class="bo-topbar-title">COMMANDES</div>
        <div class="bo-topbar-right">
            <span style="font-size:.75rem; color:var(--muted);"><?php echo count($bo_commandes); ?> commande<?php echo count($bo_commandes) > 1 ? 's' : ''; ?></span>
        </div>
    </div>

    <div class="bo-content">

        <!-- Filtres rapides -->
        <div style="display:flex; gap:.5rem; flex-wrap:wrap; margin-bottom:1.5rem;" id="filtres">
            <button class="filtre-btn active" data-statut="tous">Toutes</button>
            <button class="filtre-btn" data-statut="payee">Payées</button>
            <button class="filtre-btn" data-statut="en_attente">En attente</button>
            <button class="filtre-btn" data-statut="refusee">Refusées</button>
            <button class="filtre-btn" data-statut="annulee">Annulées</button>

            <input type="text" id="search-commande" placeholder="Rechercher client, email..."
                   style="margin-left:auto; background:var(--card); border:1px solid var(--border); color:var(--white);
                      border-radius:2px; padding:.4rem .9rem; font-size:.78rem; width:240px;" />
        </div>

        <div class="bo-card" style="padding:0; overflow:hidden;">
            <table class="bo-table" id="table-commandes">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Email</th>
                    <th>Ville</th>
                    <th>Produits</th>
                    <th>Total TTC</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bo_commandes as $c) : ?>
                    <tr class="commande-row"
                        data-statut="<?php echo $c['statut']; ?>"
                        data-search="<?php echo strtolower($c['facturation_nom'] . ' ' . $c['facturation_prenom'] . ' ' . $c['facturation_email']); ?>">
                        <td>
                            <span style="font-family:var(--font-d); font-size:1.1rem; color:var(--volt);">#<?php echo $c['id']; ?></span>
                        </td>
                        <td>
                            <div style="color:var(--white); font-weight:600;">
                                <?php echo htmlspecialchars($c['facturation_prenom'] . ' ' . $c['facturation_nom']); ?>
                            </div>
                        </td>
                        <td><?php echo htmlspecialchars($c['facturation_email']); ?></td>
                        <td><?php echo htmlspecialchars($c['facturation_ville']); ?></td>
                        <td>
                        <span style="font-family:var(--font-d); font-size:1rem; color:var(--white);">
                            <?php echo $c['nb_produits']; ?>
                        </span>
                        </td>
                        <td>
                        <span style="color:var(--volt); font-family:var(--font-d); font-size:1.1rem;">
                            <?php echo number_format((float)$c['total_ttc'], 2, ',', ' '); ?>€
                        </span>
                        </td>
                        <td>
                        <span class="bo-badge bo-badge-<?php echo $c['statut']; ?>">
                            <?php echo $c['statut']; ?>
                        </span>
                        </td>
                        <td>
                            <a href="/backoffice/commande/<?php echo $c['id']; ?>" class="bo-btn">
                                <i class="bi bi-eye me-1"></i> Détail
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

    <style>
        .filtre-btn {
            background:transparent; border:1px solid var(--border); color:var(--muted);
            font-size:.62rem; font-weight:700; letter-spacing:.15em; text-transform:uppercase;
            padding:.35rem .8rem; border-radius:2px; cursor:pointer; transition:all .15s;
        }
        .filtre-btn:hover { border-color:rgba(200,255,0,.4); color:var(--white); }
        .filtre-btn.active { background:var(--volt); border-color:var(--volt); color:var(--night); }
    </style>

    <script>
        /* ── Filtres statut ── */
        document.querySelectorAll('.filtre-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.filtre-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                applyFilters();
            });
        });

        document.getElementById('search-commande').addEventListener('input', applyFilters);

        function applyFilters() {
            const statut = document.querySelector('.filtre-btn.active').dataset.statut;
            const search = document.getElementById('search-commande').value.toLowerCase();
            document.querySelectorAll('.commande-row').forEach(row => {
                const matchS = statut === 'tous' || row.dataset.statut === statut;
                const matchQ = search === '' || row.dataset.search.includes(search);
                row.style.display = matchS && matchQ ? '' : 'none';
            });
        }
    </script>

<?php require_once 'Backoffice/view/v-bo-layout-foot.php'; ?>
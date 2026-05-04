<?php require_once 'Backoffice/view/v-bo-layout-head.php'; ?>

    <div class="bo-topbar">
        <div class="bo-topbar-title">PAIEMENTS</div>
        <div class="bo-topbar-right">
            <span style="font-size:.75rem; color:var(--muted);"><?php echo count($bo_paiements); ?> paiement<?php echo count($bo_paiements) > 1 ? 's' : ''; ?></span>
        </div>
    </div>

    <div class="bo-content">

        <div style="display:flex; gap:.5rem; flex-wrap:wrap; margin-bottom:1.5rem;">
            <button class="filtre-btn active" data-statut="tous">Tous</button>
            <button class="filtre-btn" data-statut="accepte">Acceptés</button>
            <button class="filtre-btn" data-statut="refuse">Refusés</button>
            <button class="filtre-btn" data-statut="annule">Annulés</button>
            <input type="text" id="search-paiement" placeholder="Rechercher ref, client..."
                   style="margin-left:auto; background:var(--card); border:1px solid var(--border); color:var(--white);
                      border-radius:2px; padding:.4rem .9rem; font-size:.78rem; width:240px;" />
        </div>

        <div class="bo-card" style="padding:0; overflow:hidden;">
            <table class="bo-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Référence banque</th>
                    <th>Client</th>
                    <th>Email</th>
                    <th>Montant</th>
                    <th>Statut paiement</th>
                    <th>Statut commande</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bo_paiements as $p) : ?>
                    <tr class="paiement-row"
                        data-statut="<?php echo $p['statut']; ?>"
                        data-search="<?php echo strtolower($p['ref_banque'] . ' ' . $p['facturation_nom'] . ' ' . $p['facturation_prenom'] . ' ' . $p['facturation_email']); ?>">
                        <td style="font-family:var(--font-d); font-size:1.1rem; color:var(--volt);">#<?php echo $p['id']; ?></td>
                        <td style="font-size:.75rem; color:var(--white);"><?php echo htmlspecialchars($p['ref_banque']); ?></td>
                        <td style="color:var(--white); font-weight:600;">
                            <?php echo htmlspecialchars($p['facturation_prenom'] . ' ' . $p['facturation_nom']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($p['facturation_email']); ?></td>
                        <td style="color:var(--volt); font-family:var(--font-d); font-size:1.1rem;">
                            <?php echo number_format((float)$p['montant'], 2, ',', ' '); ?>€
                        </td>
                        <td><span class="bo-badge bo-badge-<?php echo $p['statut']; ?>"><?php echo $p['statut']; ?></span></td>
                        <td><span class="bo-badge bo-badge-<?php echo $p['statut_commande']; ?>"><?php echo $p['statut_commande']; ?></span></td>
                        <td style="font-size:.72rem;"><?php echo $p['date_paiement']; ?></td>
                        <td>
                            <div style="display:flex; gap:.4rem;">
                                <a href="/backoffice/paiement/<?php echo $p['id']; ?>" class="bo-btn">
                                    <i class="bi bi-eye me-1"></i> Détail
                                </a>
                                <a href="/backoffice/commande/<?php echo $p['id_commande']; ?>" class="bo-btn-outline">
                                    <i class="bi bi-receipt"></i>
                                </a>
                            </div>
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
        document.querySelectorAll('.filtre-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.filtre-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                applyFilters();
            });
        });
        document.getElementById('search-paiement').addEventListener('input', applyFilters);

        function applyFilters() {
            const statut = document.querySelector('.filtre-btn.active').dataset.statut;
            const search = document.getElementById('search-paiement').value.toLowerCase();
            document.querySelectorAll('.paiement-row').forEach(row => {
                const matchS = statut === 'tous' || row.dataset.statut === statut;
                const matchQ = search === '' || row.dataset.search.includes(search);
                row.style.display = matchS && matchQ ? '' : 'none';
            });
        }
    </script>

<?php require_once 'Backoffice/view/v-bo-layout-foot.php'; ?>
<?php require_once 'Backoffice/view/v-bo-layout-head.php'; ?>

    <!-- Topbar -->
    <div class="bo-topbar">
        <div class="bo-topbar-title">DASHBOARD</div>
        <div class="bo-topbar-right">
            <span class="bo-badge-env">Préprod</span>
            <span style="font-size:.75rem; color:var(--muted);"><?php echo date('d/m/Y H:i'); ?></span>
        </div>
    </div>

    <div class="bo-content">

        <!-- Stats -->
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="bo-stat">
                    <div class="bo-stat-label">Chiffre d'affaires</div>
                    <div class="bo-stat-value"><?php echo number_format((float)$bo_stats['ca_total'], 2, ',', ' '); ?>€</div>
                    <i class="bi bi-graph-up bo-stat-icon"></i>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bo-stat">
                    <div class="bo-stat-label">Commandes totales</div>
                    <div class="bo-stat-value"><?php echo $bo_stats['total_commandes']; ?></div>
                    <i class="bi bi-receipt bo-stat-icon"></i>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bo-stat">
                    <div class="bo-stat-label">Commandes payées</div>
                    <div class="bo-stat-value"><?php echo $bo_stats['commandes_payees']; ?></div>
                    <i class="bi bi-check-circle bo-stat-icon"></i>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bo-stat" style="--volt: #FFB347;">
                    <div class="bo-stat-label" style="color:var(--muted);">En attente</div>
                    <div class="bo-stat-value" style="color:#FFB347;"><?php echo $bo_stats['commandes_attente']; ?></div>
                    <i class="bi bi-clock bo-stat-icon" style="color:#FFB347;"></i>
                </div>
            </div>
        </div>

        <div class="row g-4">

            <!-- Dernières commandes -->
            <div class="col-lg-7">
                <div class="bo-card">
                    <div class="bo-card-title">
                        <i class="bi bi-receipt"></i> Dernières commandes
                        <a href="/backoffice/commande/" class="bo-btn-outline ms-auto" style="font-size:.6rem; padding:.2rem .6rem;">Tout voir</a>
                    </div>
                    <table class="bo-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Client</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($dernieres_commandes as $c) : ?>
                            <tr>
                                <td style="color:var(--volt); font-family:var(--font-d);">#<?php echo $c['id']; ?></td>
                                <td>
                                    <div style="color:var(--white); font-weight:600; font-size:.82rem;"><?php echo htmlspecialchars($c['facturation_prenom'] . ' ' . $c['facturation_nom']); ?></div>
                                    <div style="font-size:.7rem;"><?php echo htmlspecialchars($c['facturation_email']); ?></div>
                                </td>
                                <td style="color:var(--white); font-weight:600;"><?php echo number_format((float)$c['total_ttc'], 2, ',', ' '); ?>€</td>
                                <td><span class="bo-badge bo-badge-<?php echo $c['statut']; ?>"><?php echo $c['statut']; ?></span></td>
                                <td><a href="/backoffice/commande/<?php echo $c['id']; ?>" class="bo-btn-outline" style="font-size:.6rem; padding:.2rem .6rem;">Voir</a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Derniers paiements -->
            <div class="col-lg-5">
                <div class="bo-card">
                    <div class="bo-card-title">
                        <i class="bi bi-credit-card"></i> Derniers paiements
                        <a href="/backoffice/paiement/" class="bo-btn-outline ms-auto" style="font-size:.6rem; padding:.2rem .6rem;">Tout voir</a>
                    </div>
                    <table class="bo-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Référence</th>
                            <th>Montant</th>
                            <th>Statut</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($derniers_paiements as $p) : ?>
                            <tr style="cursor:pointer;" onclick="location.href='/backoffice/paiement/<?php echo $p['id']; ?>'">
                                <td style="color:var(--volt); font-family:var(--font-d);">#<?php echo $p['id']; ?></td>
                                <td>
                                    <div style="color:var(--white); font-size:.78rem;"><?php echo htmlspecialchars($p['ref_banque']); ?></div>
                                    <div style="font-size:.68rem;"><?php echo htmlspecialchars($p['facturation_prenom'] . ' ' . $p['facturation_nom']); ?></div>
                                </td>
                                <td style="color:var(--white); font-weight:600;"><?php echo number_format((float)$p['montant'], 2, ',', ' '); ?>€</td>
                                <td><span class="bo-badge bo-badge-<?php echo $p['statut']; ?>"><?php echo $p['statut']; ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- API Notice -->
            <div class="col-12">
                <div class="bo-card">
                    <div class="bo-card-title"><i class="bi bi-braces"></i> API VOLTEX — Endpoints disponibles</div>
                    <div class="row g-3">
                        <?php
                        $base = 'https://b2-gp96.kevinpecro.info/api/';
                        $endpoints = [
                            ['url' => $base . 'liste/', 'desc' => 'Notice complète de l\'API', 'icon' => 'bi-list-ul', 'params' => 'token'],
                            ['url' => $base . 'commande/', 'desc' => 'Liste toutes les commandes. Avec id : détail + produits.', 'icon' => 'bi-receipt', 'params' => 'token, id (optionnel)'],
                            ['url' => $base . 'paiement/', 'desc' => 'Liste tous les paiements. Avec id : détail + commande + produits.', 'icon' => 'bi-credit-card', 'params' => 'token, id (optionnel)'],
                        ];
                        foreach ($endpoints as $ep) :
                            ?>
                            <div class="col-md-4">
                                <div style="background:var(--surface); border:1px solid var(--border); border-radius:3px; padding:1.1rem;">
                                    <div style="display:flex; align-items:center; gap:.5rem; margin-bottom:.6rem;">
                                        <i class="bi <?php echo $ep['icon']; ?>" style="color:var(--volt);"></i>
                                        <span style="font-size:.58rem; font-weight:700; letter-spacing:.15em; text-transform:uppercase; background:rgba(200,255,0,.1); color:var(--volt); padding:.1rem .4rem; border-radius:1px;">POST</span>
                                    </div>
                                    <div style="font-size:.75rem; color:var(--white); margin-bottom:.3rem; word-break:break-all;"><?php echo $ep['url']; ?></div>
                                    <div style="font-size:.72rem; color:var(--muted); margin-bottom:.5rem;"><?php echo $ep['desc']; ?></div>
                                    <div style="font-size:.65rem; color:var(--muted); border-top:1px solid var(--border); padding-top:.4rem;">
                                        <strong style="color:var(--volt);">Params :</strong> <?php echo $ep['params']; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php require_once 'Backoffice/view/v-bo-layout-foot.php'; ?>
<?php require_once 'Backoffice/view/v-bo-layout-head.php'; ?>

    <div class="bo-topbar">
        <div class="bo-topbar-title">PAIEMENT #<?php echo $bo_paiement['id']; ?></div>
        <div class="bo-topbar-right">
            <span class="bo-badge bo-badge-<?php echo $bo_paiement['statut']; ?>"><?php echo $bo_paiement['statut']; ?></span>
            <a href="/backoffice/paiement/" class="bo-btn-outline">
                <i class="bi bi-arrow-left me-1"></i> Retour
            </a>
        </div>
    </div>

    <div class="bo-content">

        <div class="bo-breadcrumb">
            <a href="/backoffice/">Dashboard</a>
            <i class="bi bi-chevron-right"></i>
            <a href="/backoffice/paiement/">Paiements</a>
            <i class="bi bi-chevron-right"></i>
            <span>#<?php echo $bo_paiement['id']; ?></span>
        </div>

        <div class="row g-4">

            <!-- Infos paiement -->
            <div class="col-md-5">
                <div class="bo-card">
                    <div class="bo-card-title"><i class="bi bi-credit-card"></i> Détail du paiement</div>
                    <div class="bo-info-row">
                        <span class="label">ID</span>
                        <span class="value" style="font-family:var(--font-d); font-size:1.3rem; color:var(--volt);">#<?php echo $bo_paiement['id']; ?></span>
                    </div>
                    <div class="bo-info-row">
                        <span class="label">Référence banque</span>
                        <span class="value"><?php echo htmlspecialchars($bo_paiement['ref_banque']); ?></span>
                    </div>
                    <div class="bo-info-row">
                        <span class="label">Code autorisation</span>
                        <span class="value"><?php echo htmlspecialchars($bo_paiement['autorisation'] ?? '—'); ?></span>
                    </div>
                    <div class="bo-info-row">
                        <span class="label">Montant</span>
                        <span class="value" style="font-family:var(--font-d); font-size:1.6rem; color:var(--volt);">
                        <?php echo number_format((float)$bo_paiement['montant'], 2, ',', ' '); ?>€
                    </span>
                    </div>
                    <div class="bo-info-row">
                        <span class="label">Statut</span>
                        <span class="value">
                        <span class="bo-badge bo-badge-<?php echo $bo_paiement['statut']; ?>">
                            <?php echo $bo_paiement['statut']; ?>
                        </span>
                    </span>
                    </div>
                    <div class="bo-info-row">
                        <span class="label">Date paiement</span>
                        <span class="value"><?php echo $bo_paiement['date_paiement']; ?></span>
                    </div>
                    <div class="bo-info-row">
                        <span class="label">Commande liée</span>
                        <span class="value">
                        <a href="/backoffice/commande/<?php echo $bo_paiement['id_commande']; ?>"
                           style="color:var(--volt); text-decoration:none;">
                            #<?php echo $bo_paiement['id_commande']; ?>
                        </a>
                    </span>
                    </div>
                </div>

                <!-- Données brutes -->
                <?php if (!empty($bo_paiement['donnees_brutes'])) : ?>
                    <div class="bo-card">
                        <div class="bo-card-title"><i class="bi bi-code-square"></i> Données brutes banque</div>
                        <pre style="font-size:.68rem; color:var(--muted); background:var(--surface);
                            border:1px solid var(--border); border-radius:2px; padding:.8rem;
                            overflow-x:auto; white-space:pre-wrap; word-break:break-all;"><?php
                            $raw = json_decode($bo_paiement['donnees_brutes'], true);
                            echo htmlspecialchars(json_encode($raw, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                            ?></pre>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Commande associée -->
            <div class="col-md-7">
                <?php if ($bo_paiement_commande) : ?>
                    <div class="bo-card">
                        <div class="bo-card-title"><i class="bi bi-receipt"></i> Commande #<?php echo $bo_paiement_commande['id']; ?></div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div style="font-size:.58rem; letter-spacing:.18em; text-transform:uppercase; color:var(--muted); margin-bottom:.3rem;">Facturation</div>
                                <div style="color:var(--white); font-weight:600; font-size:.85rem;"><?php echo htmlspecialchars($bo_paiement_commande['facturation_prenom'] . ' ' . $bo_paiement_commande['facturation_nom']); ?></div>
                                <div style="font-size:.75rem; color:var(--muted);"><?php echo htmlspecialchars($bo_paiement_commande['facturation_email']); ?></div>
                                <div style="font-size:.75rem; color:var(--muted);"><?php echo htmlspecialchars($bo_paiement_commande['facturation_adresse']); ?></div>
                                <div style="font-size:.75rem; color:var(--muted);"><?php echo htmlspecialchars($bo_paiement_commande['facturation_code_postal'] . ' ' . $bo_paiement_commande['facturation_ville']); ?></div>
                            </div>
                            <div class="col-6">
                                <div style="font-size:.58rem; letter-spacing:.18em; text-transform:uppercase; color:var(--muted); margin-bottom:.3rem;">Livraison</div>
                                <div style="color:var(--white); font-weight:600; font-size:.85rem;"><?php echo htmlspecialchars($bo_paiement_commande['livraison_prenom'] . ' ' . $bo_paiement_commande['livraison_nom']); ?></div>
                                <div style="font-size:.75rem; color:var(--muted);"><?php echo htmlspecialchars($bo_paiement_commande['livraison_adresse']); ?></div>
                                <div style="font-size:.75rem; color:var(--muted);"><?php echo htmlspecialchars($bo_paiement_commande['livraison_code_postal'] . ' ' . $bo_paiement_commande['livraison_ville']); ?></div>
                            </div>
                        </div>
                        <div style="margin-top:1rem; padding-top:1rem; border-top:1px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <span class="bo-badge bo-badge-<?php echo $bo_paiement_commande['statut']; ?>"><?php echo $bo_paiement_commande['statut']; ?></span>
                            </div>
                            <div style="font-family:var(--font-d); font-size:1.4rem; color:var(--volt);">
                                <?php echo number_format((float)$bo_paiement_commande['total_ttc'], 2, ',', ' '); ?>€ TTC
                            </div>
                        </div>
                    </div>

                    <!-- Produits -->
                    <div class="bo-card">
                        <div class="bo-card-title"><i class="bi bi-bag"></i> Produits</div>
                        <table class="bo-table">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Produit</th>
                                <th>Qté</th>
                                <th>Prix TTC</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($bo_paiement_produits as $p) : ?>
                                <tr>
                                    <td>
                                        <?php if ($p['image']) : ?>
                                            <img src="/<?php echo htmlspecialchars($p['image']); ?>"
                                                 alt="" style="height:45px; width:36px; object-fit:contain;
                                         background:var(--surface); border-radius:2px; padding:2px;" />
                                        <?php else : ?>
                                            <div style="width:36px; height:45px; background:var(--surface); border-radius:2px;
                                                display:flex; align-items:center; justify-content:center;">
                                                <i class="bi bi-image" style="color:var(--muted); font-size:.8rem;"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="color:var(--white); font-weight:600;"><?php echo htmlspecialchars($p['nom']); ?></td>
                                    <td style="font-family:var(--font-d); font-size:1.1rem;"><?php echo $p['quantite']; ?></td>
                                    <td style="color:var(--volt);"><?php echo number_format($p['prix_ttc'], 2, ',', ' '); ?>€</td>
                                    <td style="color:var(--volt); font-weight:700;">
                                        <?php echo number_format($p['prix_ttc'] * $p['quantite'], 2, ',', ' '); ?>€
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

<?php require_once 'Backoffice/view/v-bo-layout-foot.php'; ?>
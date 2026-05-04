<?php require_once 'Backoffice/view/v-bo-layout-head.php'; ?>

    <div class="bo-topbar">
        <div class="bo-topbar-title">COMMANDE #<?php echo $bo_commande['id']; ?></div>
        <div class="bo-topbar-right">
            <span class="bo-badge bo-badge-<?php echo $bo_commande['statut']; ?>"><?php echo $bo_commande['statut']; ?></span>
            <a href="/backoffice/commande/" class="bo-btn-outline">
                <i class="bi bi-arrow-left me-1"></i> Retour
            </a>
        </div>
    </div>

    <div class="bo-content">

        <div class="bo-breadcrumb">
            <a href="/backoffice/">Dashboard</a>
            <i class="bi bi-chevron-right"></i>
            <a href="/backoffice/commande/">Commandes</a>
            <i class="bi bi-chevron-right"></i>
            <span>#<?php echo $bo_commande['id']; ?></span>
        </div>

        <div class="row g-4">

            <!-- Infos facturation -->
            <div class="col-md-6">
                <div class="bo-card">
                    <div class="bo-card-title"><i class="bi bi-receipt"></i> Facturation</div>
                    <div class="bo-info-row"><span class="label">Nom</span><span class="value"><?php echo htmlspecialchars($bo_commande['facturation_prenom'] . ' ' . $bo_commande['facturation_nom']); ?></span></div>
                    <div class="bo-info-row"><span class="label">Email</span><span class="value"><?php echo htmlspecialchars($bo_commande['facturation_email']); ?></span></div>
                    <div class="bo-info-row"><span class="label">Téléphone</span><span class="value"><?php echo htmlspecialchars($bo_commande['facturation_telephone']); ?></span></div>
                    <div class="bo-info-row"><span class="label">Adresse</span><span class="value"><?php echo htmlspecialchars($bo_commande['facturation_adresse']); ?></span></div>
                    <?php if ($bo_commande['facturation_complement']) : ?>
                        <div class="bo-info-row"><span class="label">Complément</span><span class="value"><?php echo htmlspecialchars($bo_commande['facturation_complement']); ?></span></div>
                    <?php endif; ?>
                    <div class="bo-info-row"><span class="label">Code postal</span><span class="value"><?php echo htmlspecialchars($bo_commande['facturation_code_postal']); ?></span></div>
                    <div class="bo-info-row"><span class="label">Ville</span><span class="value"><?php echo htmlspecialchars($bo_commande['facturation_ville']); ?></span></div>
                </div>
            </div>

            <!-- Infos livraison -->
            <div class="col-md-6">
                <div class="bo-card">
                    <div class="bo-card-title"><i class="bi bi-truck"></i> Livraison</div>
                    <div class="bo-info-row"><span class="label">Nom</span><span class="value"><?php echo htmlspecialchars($bo_commande['livraison_prenom'] . ' ' . $bo_commande['livraison_nom']); ?></span></div>
                    <div class="bo-info-row"><span class="label">Email</span><span class="value"><?php echo htmlspecialchars($bo_commande['livraison_email']); ?></span></div>
                    <div class="bo-info-row"><span class="label">Téléphone</span><span class="value"><?php echo htmlspecialchars($bo_commande['livraison_telephone']); ?></span></div>
                    <div class="bo-info-row"><span class="label">Adresse</span><span class="value"><?php echo htmlspecialchars($bo_commande['livraison_adresse']); ?></span></div>
                    <?php if ($bo_commande['livraison_complement']) : ?>
                        <div class="bo-info-row"><span class="label">Complément</span><span class="value"><?php echo htmlspecialchars($bo_commande['livraison_complement']); ?></span></div>
                    <?php endif; ?>
                    <div class="bo-info-row"><span class="label">Code postal</span><span class="value"><?php echo htmlspecialchars($bo_commande['livraison_code_postal']); ?></span></div>
                    <div class="bo-info-row"><span class="label">Ville</span><span class="value"><?php echo htmlspecialchars($bo_commande['livraison_ville']); ?></span></div>
                </div>
            </div>

            <!-- Produits -->
            <div class="col-12">
                <div class="bo-card">
                    <div class="bo-card-title"><i class="bi bi-bag"></i> Produits commandés</div>
                    <table class="bo-table">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Produit</th>
                            <th>Identifiant</th>
                            <th>Qté</th>
                            <th>Prix HT</th>
                            <th>TVA</th>
                            <th>Prix TTC</th>
                            <th>Total TTC</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($bo_commande_produits as $p) : ?>
                            <tr>
                                <td>
                                    <?php if ($p['image']) : ?>
                                        <img src="/<?php echo htmlspecialchars($p['image']); ?>"
                                             alt="" style="height:50px; width:40px; object-fit:contain;
                                         background:var(--surface); border-radius:2px; padding:2px;" />
                                    <?php else : ?>
                                        <div style="width:40px; height:50px; background:var(--surface); border-radius:2px;
                                                display:flex; align-items:center; justify-content:center;">
                                            <i class="bi bi-image" style="color:var(--muted);"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td style="color:var(--white); font-weight:600;"><?php echo htmlspecialchars($p['nom']); ?></td>
                                <td style="font-size:.72rem;"><?php echo htmlspecialchars($p['identifiant']); ?></td>
                                <td style="font-family:var(--font-d); font-size:1.1rem; color:var(--white);"><?php echo $p['quantite']; ?></td>
                                <td><?php echo number_format($p['prix_ht'], 2, ',', ' '); ?>€</td>
                                <td><?php echo $p['taux_tva']; ?>%</td>
                                <td style="color:var(--volt);"><?php echo number_format($p['prix_ttc'], 2, ',', ' '); ?>€</td>
                                <td style="color:var(--volt); font-weight:700;">
                                    <?php echo number_format($p['prix_ttc'] * $p['quantite'], 2, ',', ' '); ?>€
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Récap financier + Paiement -->
            <div class="col-md-6">
                <div class="bo-card">
                    <div class="bo-card-title"><i class="bi bi-calculator"></i> Récapitulatif</div>
                    <div class="bo-info-row">
                        <span class="label">Total TTC</span>
                        <span class="value" style="font-family:var(--font-d); font-size:1.5rem; color:var(--volt);">
                        <?php echo number_format((float)$bo_commande['total_ttc'], 2, ',', ' '); ?>€
                    </span>
                    </div>
                    <div class="bo-info-row">
                        <span class="label">Statut commande</span>
                        <span class="value"><span class="bo-badge bo-badge-<?php echo $bo_commande['statut']; ?>"><?php echo $bo_commande['statut']; ?></span></span>
                    </div>
                </div>
            </div>

            <?php if ($bo_commande_paiement) : ?>
                <div class="col-md-6">
                    <div class="bo-card">
                        <div class="bo-card-title"><i class="bi bi-credit-card"></i> Paiement associé</div>
                        <div class="bo-info-row"><span class="label">Référence banque</span><span class="value"><?php echo htmlspecialchars($bo_commande_paiement['ref_banque']); ?></span></div>
                        <div class="bo-info-row"><span class="label">Autorisation</span><span class="value"><?php echo htmlspecialchars($bo_commande_paiement['autorisation']); ?></span></div>
                        <div class="bo-info-row"><span class="label">Montant</span><span class="value" style="color:var(--volt);"><?php echo number_format((float)$bo_commande_paiement['montant'], 2, ',', ' '); ?>€</span></div>
                        <div class="bo-info-row"><span class="label">Statut paiement</span><span class="value"><span class="bo-badge bo-badge-<?php echo $bo_commande_paiement['statut']; ?>"><?php echo $bo_commande_paiement['statut']; ?></span></span></div>
                        <div class="bo-info-row"><span class="label">Date</span><span class="value"><?php echo $bo_commande_paiement['date_paiement']; ?></span></div>
                        <div style="margin-top:1rem;">
                            <a href="/backoffice/paiement/<?php echo $bo_commande_paiement['id']; ?>" class="bo-btn">
                                <i class="bi bi-eye me-1"></i> Voir le paiement
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

<?php require_once 'Backoffice/view/v-bo-layout-foot.php'; ?>
<?php

function BOPaiement() {
    global $pdo;

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id > 0) {

        /* ── Détail paiement ── */
        $stmt = $pdo->prepare("SELECT * FROM paiement WHERE id = ?");
        $stmt->execute([$id]);
        global $bo_paiement;
        $bo_paiement = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$bo_paiement) {
            header('Location: /backoffice/paiement/');
            exit;
        }

        /* ── Commande associée ── */
        $stmtC = $pdo->prepare("SELECT * FROM commande WHERE id = ?");
        $stmtC->execute([$bo_paiement['id_commande']]);
        global $bo_paiement_commande;
        $bo_paiement_commande = $stmtC->fetch(PDO::FETCH_ASSOC);

        /* ── Produits de la commande ── */
        $stmtP = $pdo->prepare("
            SELECT cp.quantite, cp.prix_ht, cp.taux_tva,
                   p.nom, p.identifiant, p.image
            FROM commande_produit cp
            JOIN produit p ON p.id = cp.id_produit
            WHERE cp.id_commande = ?
        ");
        $stmtP->execute([$bo_paiement['id_commande']]);
        global $bo_paiement_produits;
        $bo_paiement_produits = $stmtP->fetchAll(PDO::FETCH_ASSOC);

        foreach ($bo_paiement_produits as &$p) {
            $imgs       = array_values(array_filter(array_map('trim', explode(',', $p['image'] ?? ''))));
            $p['image'] = $imgs[0] ?? null;
            $p['prix_ttc'] = round($p['prix_ht'] * (1 + $p['taux_tva'] / 100), 2);
        }
        unset($p);

        require_once 'Backoffice/view/v-bo-paiement-detail.php';

    } else {

        /* ── Liste tous les paiements ── */
        global $bo_paiements;
        $bo_paiements = $pdo->query("
            SELECT p.id, p.statut, p.montant, p.date_paiement, p.ref_banque, p.autorisation,
                   c.facturation_nom, c.facturation_prenom, c.facturation_email,
                   c.statut AS statut_commande, c.id AS id_commande
            FROM paiement p
            JOIN commande c ON c.id = p.id_commande
            ORDER BY p.id DESC
        ")->fetchAll(PDO::FETCH_ASSOC);

        require_once 'Backoffice/view/v-bo-paiement.php';
    }
}
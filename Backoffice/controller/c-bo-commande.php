<?php

function BOCommande() {
    global $pdo;

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id > 0) {

        /* ── Détail commande ── */
        $stmt = $pdo->prepare("SELECT * FROM commande WHERE id = ?");
        $stmt->execute([$id]);
        global $bo_commande;
        $bo_commande = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$bo_commande) {
            header('Location: /backoffice/commande/');
            exit;
        }

        /* ── Produits de la commande ── */
        $stmtP = $pdo->prepare("
            SELECT cp.quantite, cp.prix_ht, cp.taux_tva,
                   p.nom, p.identifiant, p.image
            FROM commande_produit cp
            JOIN produit p ON p.id = cp.id_produit
            WHERE cp.id_commande = ?
        ");
        $stmtP->execute([$id]);
        global $bo_commande_produits;
        $bo_commande_produits = $stmtP->fetchAll(PDO::FETCH_ASSOC);

        foreach ($bo_commande_produits as &$p) {
            $imgs       = array_values(array_filter(array_map('trim', explode(',', $p['image'] ?? ''))));
            $p['image'] = $imgs[0] ?? null;
            $p['prix_ttc'] = round($p['prix_ht'] * (1 + $p['taux_tva'] / 100), 2);
        }
        unset($p);

        /* ── Paiement lié ── */
        $stmtPay = $pdo->prepare("SELECT * FROM paiement WHERE id_commande = ? ORDER BY id DESC LIMIT 1");
        $stmtPay->execute([$id]);
        global $bo_commande_paiement;
        $bo_commande_paiement = $stmtPay->fetch(PDO::FETCH_ASSOC);

        require_once 'Backoffice/view/v-bo-commande-detail.php';

    } else {

        /* ── Liste toutes les commandes ── */
        global $bo_commandes;
        $bo_commandes = $pdo->query("
            SELECT c.id, c.statut, c.total_ttc,
                   c.facturation_nom, c.facturation_prenom,
                   c.facturation_email, c.facturation_ville,
                   (SELECT COUNT(*) FROM commande_produit cp WHERE cp.id_commande = c.id) AS nb_produits
            FROM commande c
            ORDER BY c.id DESC
        ")->fetchAll(PDO::FETCH_ASSOC);

        require_once 'Backoffice/view/v-bo-commande.php';
    }
}
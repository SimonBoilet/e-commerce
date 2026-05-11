<?php
function APICommande() {
    global $pdo;

    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');

    // 1. Sécurité
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(["error" => "Method Not Allowed"]);
        exit;
    }

    verifierToken();

    // 2. Logique
    if (isset($_POST['id']) && (int)$_POST['id'] > 0) {
        $idCommande = (int)$_POST['id'];

        $stmtCommande = $pdo->prepare("SELECT * FROM commande WHERE id = ?");
        $stmtCommande->execute([$idCommande]);
        $commande = $stmtCommande->fetch();

        if (!$commande) {
            http_response_code(404);
            echo json_encode(['error' => 'Commande introuvable']);
            exit;
        }

        $stmtProduits = $pdo->prepare("
            SELECT cp.quantite, cp.prix_ht, cp.taux_tva, p.id AS produit_id, p.nom, p.image
            FROM commande_produit cp
            JOIN produit p ON p.id = cp.id_produit
            WHERE cp.id_commande = ?
        ");
        $stmtProduits->execute([$idCommande]);
        $produits = $stmtProduits->fetchAll();

        foreach ($produits as &$p) {
            $p['prix_ttc'] = round($p['prix_ht'] * (1 + $p['taux_tva'] / 100), 2);
        }

        $commande['produits'] = $produits;
        echo json_encode($commande);
    } else {
        $lst = $pdo->query("SELECT * FROM commande ORDER BY id DESC")->fetchAll();
        echo json_encode($lst);
    }
}
<?php
function APIPaiement() {
    global $pdo;

    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(["error" => "Method Not Allowed"]);
        exit;
    }

    verifierToken();

    if (isset($_POST['id']) && (int)$_POST['id'] > 0) {
        $idPaiement = (int)$_POST['id'];

        $stmtPaiement = $pdo->prepare("SELECT * FROM paiement WHERE id = ?");
        $stmtPaiement->execute([$idPaiement]);
        $paiement = $stmtPaiement->fetch();

        if (!$paiement) {
            http_response_code(404);
            echo json_encode(['error' => 'Paiement introuvable']);
            exit;
        }

        $stmtCommande = $pdo->prepare("SELECT id, statut, total_ttc FROM commande WHERE id = ?");
        $stmtCommande->execute([$paiement['id_commande']]);
        $paiement['commande'] = $stmtCommande->fetch();

        echo json_encode($paiement);
    } else {
        $lst = $pdo->query("SELECT p.*, c.statut AS statut_commande FROM paiement p JOIN commande c ON c.id = p.id_commande ORDER BY p.id DESC")->fetchAll();
        echo json_encode($lst);
    }
}
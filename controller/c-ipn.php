<?php

function ipn() {
    global $pdo;

    $PBX_CLE = 'E7DD686B8817CD0A6772BBB0C744705A6C3814444C15337FF7878EAFDC1CF4BA67ABAC9E92C8BA5C000C187DAA22CFA9C3182D94C22F69698982A285EBAB8846';

    $montant        = $_POST['montant']   ?? null;
    $ref            = $_POST['ref']       ?? null;
    $auto           = $_POST['auto']      ?? null;
    $erreur         = $_POST['erreur']    ?? null;
    $sign           = $_POST['sign']      ?? null;
    $donnees_brutes = json_encode($_POST);

    if (!$ref || !$montant || !$erreur) {
        http_response_code(400);
        exit('Données manquantes');
    }

    $message = 'montant=' . $montant . '&ref=' . $ref . '&auto=' . $auto . '&erreur=' . $erreur;
    $binKey       = pack('H*', $PBX_CLE);
    $hmac_calcule = strtoupper(hash_hmac('sha512', $message, $binKey));
    if ($hmac_calcule !== strtoupper($sign)) {
        http_response_code(403);
        exit('Signature invalide');
    }

    $parts      = explode('-', $ref);
    $idCommande = (int)end($parts);

    if ($idCommande <= 0) {
        http_response_code(400);
        exit('Référence commande invalide');
    }

    $checkCommande = $pdo->prepare("SELECT id FROM commande WHERE id = ?");
    $checkCommande->execute([$idCommande]);
    if (!$checkCommande->fetch()) {
        http_response_code(404);
        exit('Commande introuvable');
    }

    $montant_float = (float)$montant / 100;

    if ($erreur === '00000') {
        $statut_paiement = 'accepte';
        $statut_commande = 'payee';
    } elseif ($erreur === '00001') {
        $statut_paiement = 'annule';
        $statut_commande = 'annulee';
    } else {
        $statut_paiement = 'refuse';
        $statut_commande = 'refusee';
    }

    $pdo->prepare("INSERT INTO paiement (id_commande, ref_banque, autorisation, montant, statut, donnees_brutes) VALUES (?, ?, ?, ?, ?, ?)")
        ->execute([$idCommande, $ref, $auto, $montant_float, $statut_paiement, $donnees_brutes]);

    $pdo->prepare("UPDATE commande SET statut = ? WHERE id = ?")
        ->execute([$statut_commande, $idCommande]);

    http_response_code(200);
    exit('OK');
}
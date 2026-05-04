<?php

function paiement() {

    if (isset($_GET['id']) && in_array($_GET['id'], ['ok', 'annule', 'refuse'])) {

        /* ── Récupérer les params banque depuis l'URI originale ── */
        $uri_parts     = parse_url($_SERVER['REQUEST_URI']);
        parse_str($uri_parts['query'] ?? '', $bank_params);

        if ($_GET['id'] === 'ok') {
            if (isset($_SESSION['id_panier'])) {
                global $pdo;
                $pdo->prepare("DELETE FROM panier_produit WHERE id_panier = ?")
                    ->execute([$_SESSION['id_panier']]);
                unset($_SESSION['id_panier']);
            }
            unset($_SESSION['id_commande']);
            unset($_SESSION['commande_total']);
            unset($_SESSION['commande_email']);
        }

        global $retour_data;
        $retour_data = [
            'statut'  => $_GET['id'],
            'montant' => $bank_params['montant'] ?? null,
            'ref'     => $bank_params['ref']     ?? null,
            'auto'    => $bank_params['auto']    ?? null,
            'erreur'  => $bank_params['erreur']  ?? null,
        ];

        require_once 'view/inc/inc.head.php';
        require_once 'view/inc/inc.header.php';
        require_once 'view/v-retour-paiement.php';
        require_once 'view/inc/inc.footer.php';
        return;
    }

    /* ── Vérifier qu'une commande est en attente ── */
    if (empty($_SESSION['id_commande'])) {
        header('Location: /panier/');
        exit;
    }

    $PBX_SITE        = '3277512';
    $PBX_RANG        = '001';
    $PBX_IDENTIFIANT = '38023694';
    $PBX_CLE         = 'E7DD686B8817CD0A6772BBB0C744705A6C3814444C15337FF7878EAFDC1CF4BA67ABAC9E92C8BA5C000C187DAA22CFA9C3182D94C22F69698982A285EBAB8846';

    $BASE_URL = 'https://b2-gp96.kevinpecro.info';

    $numeroCommande = '25gp96-' . $_SESSION['id_commande'];
    $montant        = (string)$_SESSION['commande_total'];
    $emailClient    = $_SESSION['commande_email'] ?? 'client@test.com';

    $PBX_TOTAL     = $montant;
    $PBX_DEVISE    = '978';
    $PBX_CMD       = $numeroCommande;
    $PBX_PORTEUR   = $emailClient;
    $PBX_HASH      = 'SHA512';
    $PBX_TIME      = date('c');
    $PBX_RETOUR    = 'montant:M;ref:R;auto:A;erreur:E;sign:K';
    $PBX_RUF1      = 'POST';

    $PBX_EFFECTUE   = $BASE_URL . '/paiement/ok/';
    $PBX_ANNULE     = $BASE_URL . '/paiement/annule/';
    $PBX_REFUSE     = $BASE_URL . '/paiement/refuse/';
    $PBX_REPONDRE_A = $BASE_URL . '/ipn/';

    $message =
        'PBX_SITE='         . $PBX_SITE        .
        '&PBX_RANG='        . $PBX_RANG        .
        '&PBX_IDENTIFIANT=' . $PBX_IDENTIFIANT .
        '&PBX_TOTAL='       . $PBX_TOTAL       .
        '&PBX_DEVISE='      . $PBX_DEVISE      .
        '&PBX_CMD='         . $PBX_CMD         .
        '&PBX_PORTEUR='     . $PBX_PORTEUR     .
        '&PBX_RETOUR='      . $PBX_RETOUR      .
        '&PBX_RUF1='        . $PBX_RUF1        .
        '&PBX_HASH='        . $PBX_HASH        .
        '&PBX_TIME='        . $PBX_TIME        .
        '&PBX_EFFECTUE='    . $PBX_EFFECTUE    .
        '&PBX_ANNULE='      . $PBX_ANNULE      .
        '&PBX_REFUSE='      . $PBX_REFUSE      .
        '&PBX_REPONDRE_A='  . $PBX_REPONDRE_A;

    $binKey   = pack('H*', $PBX_CLE);
    $PBX_HMAC = strtoupper(hash_hmac('sha512', $message, $binKey));

    global $paiement_data;
    $paiement_data = [
        'url_paiement'    => 'https://preprod-tpeweb.e-transactions.fr/cgi/MYchoix_pagepaiement.cgi',
        'PBX_SITE'        => $PBX_SITE,
        'PBX_RANG'        => $PBX_RANG,
        'PBX_IDENTIFIANT' => $PBX_IDENTIFIANT,
        'PBX_TOTAL'       => $PBX_TOTAL,
        'PBX_DEVISE'      => $PBX_DEVISE,
        'PBX_CMD'         => $PBX_CMD,
        'PBX_PORTEUR'     => $PBX_PORTEUR,
        'PBX_RETOUR'      => $PBX_RETOUR,
        'PBX_RUF1'        => $PBX_RUF1,
        'PBX_HASH'        => $PBX_HASH,
        'PBX_TIME'        => $PBX_TIME,
        'PBX_EFFECTUE'    => $PBX_EFFECTUE,
        'PBX_ANNULE'      => $PBX_ANNULE,
        'PBX_REFUSE'      => $PBX_REFUSE,
        'PBX_REPONDRE_A'  => $PBX_REPONDRE_A,
        'PBX_HMAC'        => $PBX_HMAC,
    ];

    require_once 'view/inc/inc.head.php';
    require_once 'view/inc/inc.header.php';
    require_once 'view/v-paiement.php';
    require_once 'view/inc/inc.footer.php';
}

function retourPaiement() {

    $statut = $_GET['statut'] ?? 'refuse';

    global $retour_data;
    $retour_data = [
        'statut'  => $statut,
        'montant' => $_GET['montant'] ?? null,
        'ref'     => $_GET['ref']     ?? null,
        'auto'    => $_GET['auto']    ?? null,
        'erreur'  => $_GET['erreur']  ?? null,
    ];

    require_once 'view/inc/inc.head.php';
    require_once 'view/inc/inc.header.php';
    require_once 'view/v-retour-paiement.php';
    require_once 'view/inc/inc.footer.php';
}
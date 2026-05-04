<?php

function produit() {
    global $pdo;

    /* ── Traitement POST ajout panier AVANT le rendu ── */
    if (isset($_POST['quantite'], $_POST['idPRoduit'])) {
        ajouterProduitDansPanier((int)$_POST['idPRoduit'], (int)$_POST['quantite']);
        $retour = isset($_GET['id'])
            ? '/produit/' . urlencode($_GET['id']) . '/'
            : '/produit/';
        header('Location: ' . $retour);
        exit;
    }

    if (isset($_GET['id']) && $_GET['id']) {
        $identifiant = $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM produit WHERE identifiant = ?");
        $stmt->execute([$identifiant]);

        global $unPruduit;
        $unPruduit = $stmt;
        unProduit();
    } else {
        global $lstProduit;
        $lstProduit = $pdo->query("SELECT * FROM produit");
        lstProduit();
    }
}

function unProduit() {
    global $unPruduit;
    require_once 'view/inc/inc.head.php';
    require_once 'view/inc/inc.header.php';
    require_once 'view/produit/v-unProduit.php';
    require_once 'view/inc/inc.footer.php';
}

function lstProduit() {
    global $lstProduit;
    require_once 'view/inc/inc.head.php';
    require_once 'view/inc/inc.header.php';
    require_once 'view/produit/v-lstProduit.php';
    require_once 'view/inc/inc.footer.php';
}
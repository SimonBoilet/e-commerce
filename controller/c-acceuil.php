<?php

function accueil() {
    global $pdo;
    global $essentiels;
    global $produit_hero;  // ← nouveau

    // Produit aléatoire pour le hero
    $produit_hero = $pdo->query(
        "SELECT * FROM produit WHERE statut = 'publie' ORDER BY RAND() LIMIT 1"
    )->fetch(PDO::FETCH_ASSOC);

    // 4 produits pour la section Essentiels
    $essentiels = $pdo->query(
        "SELECT p.*, t.taux AS taux_tva
         FROM produit p
         LEFT JOIN tva t ON t.id = p.id_tva
         WHERE p.statut = 'publie'
         ORDER BY p.id ASC
         LIMIT 4"
    );

    require_once 'view/inc/inc.head.php';
    require_once 'view/inc/inc.header.php';
    require_once 'view/v-accueil.php';
    require_once 'view/inc/inc.footer.php';
}
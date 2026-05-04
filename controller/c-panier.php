<?php

/* ══════════════════════════════════════════════
 *  AFFICHAGE DU PANIER
 * ══════════════════════════════════════════════ */
function panier() {
    global $pdo, $panier, $lignes_panier;

    if (session_status() === PHP_SESSION_NONE) session_start();

    $idPanier = verifPanier();

    global $lignes_panier;
    $lignes_panier = $pdo->prepare(
        "SELECT pp.id        AS id_ligne,
                pp.quantite,
                p.id         AS id_produit,
                p.nom,
                p.identifiant,
                p.prix_ht,
                p.image,
                t.taux       AS taux_tva
         FROM panier_produit pp
         JOIN produit p  ON p.id  = pp.id_produit
         LEFT JOIN tva t ON t.id  = p.id_tva
         WHERE pp.id_panier = ?
         ORDER BY pp.id ASC"
    );
    $lignes_panier->execute([$idPanier]);

    global $panier;
    $stmtTotal = $pdo->prepare(
        "SELECT COUNT(pp.id)                                          AS nb_lignes,
                COALESCE(SUM(pp.quantite), 0)                         AS nb_articles,
                COALESCE(SUM(p.prix_ht * pp.quantite), 0)             AS total_ht,
                COALESCE(SUM(p.prix_ht * (1 + t.taux/100) * pp.quantite), 0) AS total_ttc
         FROM panier_produit pp
         JOIN produit p  ON p.id  = pp.id_produit
         LEFT JOIN tva t ON t.id  = p.id_tva
         WHERE pp.id_panier = ?"
    );
    $stmtTotal->execute([$idPanier]);
    $panier = $stmtTotal->fetch(PDO::FETCH_ASSOC);

    require_once 'view/inc/inc.head.php';
    require_once 'view/inc/inc.header.php';
    require_once 'view/v-panier.php';
    require_once 'view/inc/inc.footer.php';
}

/* ══════════════════════════════════════════════
 *  VÉRIFICATION / CRÉATION DU PANIER
 *  Adapté à la vraie structure : pas de colonne statut,
 *  id_client NOT NULL → on utilise id_client = 1 par défaut
 * ══════════════════════════════════════════════ */
function verifPanier(): int {
    global $pdo;

    if (session_status() === PHP_SESSION_NONE) session_start();

    // Panier déjà en session → vérifier qu'il existe en base
    if (isset($_SESSION['id_panier'])) {
        $check = $pdo->prepare("SELECT id FROM panier WHERE id = ?");
        $check->execute([$_SESSION['id_panier']]);
        if ($check->fetch()) {
            return (int) $_SESSION['id_panier'];
        }
        // N'existe plus → on en recrée un
        unset($_SESSION['id_panier']);
    }

    // Créer un nouveau panier (id_client = 1 par défaut, pas de login pour l'instant)
    $stmt = $pdo->prepare("INSERT INTO panier (id_client, date_creation) VALUES (1, NOW())");
    $stmt->execute();
    $idPanier = (int) $pdo->lastInsertId();

    $_SESSION['id_panier'] = $idPanier;

    return $idPanier;
}

/* ══════════════════════════════════════════════
 *  AJOUTER UN PRODUIT
 * ══════════════════════════════════════════════ */
function ajouterProduitDansPanier(int $idProduit, int $quantite): void {
    global $pdo;

    if ($quantite < 1) return;

    $idPanier = verifPanier();

    // Produit déjà dans le panier ?
    $check = $pdo->prepare(
        "SELECT id, quantite FROM panier_produit
         WHERE id_panier = ? AND id_produit = ?"
    );
    $check->execute([$idPanier, $idProduit]);
    $ligne = $check->fetch(PDO::FETCH_ASSOC);

    if ($ligne) {
        // Augmenter la quantité existante
        $pdo->prepare("UPDATE panier_produit SET quantite = ? WHERE id = ?")
            ->execute([$ligne['quantite'] + $quantite, $ligne['id']]);
    } else {
        // Insérer nouvelle ligne
        $pdo->prepare("INSERT INTO panier_produit (id_panier, id_produit, quantite) VALUES (?, ?, ?)")
            ->execute([$idPanier, $idProduit, $quantite]);
    }
}

/* ══════════════════════════════════════════════
 *  MODIFIER LA QUANTITÉ D'UNE LIGNE
 * ══════════════════════════════════════════════ */
function modifierQuantite(int $idLigne, int $quantite): void {
    global $pdo;

    if ($quantite < 1) {
        supprimerLigne($idLigne);
        return;
    }

    $pdo->prepare("UPDATE panier_produit SET quantite = ? WHERE id = ?")
        ->execute([$quantite, $idLigne]);
}

/* ══════════════════════════════════════════════
 *  SUPPRIMER UNE LIGNE
 * ══════════════════════════════════════════════ */
function supprimerLigne(int $idLigne): void {
    global $pdo;
    $pdo->prepare("DELETE FROM panier_produit WHERE id = ?")
        ->execute([$idLigne]);
}

/* ══════════════════════════════════════════════
 *  VIDER LE PANIER
 * ══════════════════════════════════════════════ */
function viderPanier(): void {
    global $pdo;
    $idPanier = verifPanier();
    $pdo->prepare("DELETE FROM panier_produit WHERE id_panier = ?")
        ->execute([$idPanier]);
}
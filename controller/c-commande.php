<?php

function commande() {
    global $pdo, $panier, $lignes_panier;

    if (session_status() === PHP_SESSION_NONE) session_start();

    /* ── Vérifier qu'un panier existe ── */
    if (empty($_SESSION['id_panier'])) {
        header('Location: /panier/');
        exit;
    }

    $idPanier = (int)$_SESSION['id_panier'];

    /* ── Récupérer le total du panier ── */
    $stmtTotal = $pdo->prepare(
        "SELECT COALESCE(SUM(p.prix_ht * (1 + t.taux/100) * pp.quantite), 0) AS total_ttc
         FROM panier_produit pp
         JOIN produit p  ON p.id = pp.id_produit
         LEFT JOIN tva t ON t.id = p.id_tva
         WHERE pp.id_panier = ?"
    );
    $stmtTotal->execute([$idPanier]);
    $total = $stmtTotal->fetch(PDO::FETCH_ASSOC);

    if ((float)$total['total_ttc'] <= 0) {
        header('Location: /paiement/');
        exit;
    }

    /* ── Traitement du formulaire ── */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['facturation_email'])) {

        /* ── Livraison identique à facturation si cochée ── */
        $same = isset($_POST['same_address']);

        /* ── INSERT commande ── */
        $stmt = $pdo->prepare(
            "INSERT INTO commande (
                id_client,
                total_ttc,
                facturation_nom,       facturation_prenom,
                facturation_email,     facturation_telephone,
                facturation_adresse,   facturation_complement,
                facturation_code_postal, facturation_ville,
                livraison_nom,         livraison_prenom,
                livraison_email,       livraison_telephone,
                livraison_adresse,     livraison_complement,
                livraison_code_postal, livraison_ville
            ) VALUES (
                1,
                :total_ttc,
                :f_nom,       :f_prenom,
                :f_email,     :f_tel,
                :f_adresse,   :f_complement,
                :f_cp,        :f_ville,
                :l_nom,       :l_prenom,
                :l_email,     :l_tel,
                :l_adresse,   :l_complement,
                :l_cp,        :l_ville
            )"
        );

        $stmt->execute([
            ':total_ttc'    => round((float)$total['total_ttc'], 2),
            ':f_nom'        => trim($_POST['facturation_nom']),
            ':f_prenom'     => trim($_POST['facturation_prenom']),
            ':f_email'      => trim($_POST['facturation_email']),
            ':f_tel'        => trim($_POST['facturation_telephone']),
            ':f_adresse'    => trim($_POST['facturation_adresse']),
            ':f_complement' => trim($_POST['facturation_complement'] ?? ''),
            ':f_cp'         => trim($_POST['facturation_code_postal']),
            ':f_ville'      => trim($_POST['facturation_ville']),
            ':l_nom'        => $same ? trim($_POST['facturation_nom'])     : trim($_POST['livraison_nom']),
            ':l_prenom'     => $same ? trim($_POST['facturation_prenom'])  : trim($_POST['livraison_prenom']),
            ':l_email'      => $same ? trim($_POST['facturation_email'])   : trim($_POST['livraison_email']),
            ':l_tel'        => $same ? trim($_POST['facturation_telephone']): trim($_POST['livraison_telephone']),
            ':l_adresse'    => $same ? trim($_POST['facturation_adresse']) : trim($_POST['livraison_adresse']),
            ':l_complement' => $same ? trim($_POST['facturation_complement'] ?? '') : trim($_POST['livraison_complement'] ?? ''),
            ':l_cp'         => $same ? trim($_POST['facturation_code_postal']): trim($_POST['livraison_code_postal']),
            ':l_ville'      => $same ? trim($_POST['facturation_ville'])   : trim($_POST['livraison_ville']),
        ]);

        $idCommande = (int)$pdo->lastInsertId();

        /* ── Copier les lignes du panier dans commande_produit ── */
        $lignes = $pdo->prepare(
            "SELECT pp.id_produit, pp.quantite,
                    p.prix_ht, t.taux AS taux_tva
             FROM panier_produit pp
             JOIN produit p  ON p.id = pp.id_produit
             LEFT JOIN tva t ON t.id = p.id_tva
             WHERE pp.id_panier = ?"
        );
        $lignes->execute([$idPanier]);

        $insertLigne = $pdo->prepare(
            "INSERT INTO commande_produit
                (id_commande, id_produit, prix_ht, taux_tva, quantite)
             VALUES (?, ?, ?, ?, ?)"
        );

        while ($l = $lignes->fetch(PDO::FETCH_ASSOC)) {
            $insertLigne->execute([
                $idCommande,
                $l['id_produit'],
                $l['prix_ht'],
                $l['taux_tva'] ?? 20,
                $l['quantite'],
            ]);
        }

        /* ── Stocker l'id commande en session → récupéré par c-paiement ── */
        $_SESSION['id_commande']    = $idCommande;
        $_SESSION['commande_email'] = trim($_POST['facturation_email']);
        $_SESSION['commande_total'] = round((float)$total['total_ttc'] * 100); // centimes

        /* ── Redirection vers le paiement ── */
        header('Location: /paiement/');
        exit;
    }

    /* ── Affichage du formulaire ── */
    global $total_ttc_commande;
    $total_ttc_commande = (float)$total['total_ttc'];

    require_once 'view/inc/inc.head.php';
    require_once 'view/inc/inc.header.php';
    require_once 'view/v-commande.php';
    require_once 'view/inc/inc.footer.php';
}
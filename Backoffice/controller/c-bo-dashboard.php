<?php

function BODashboard() {
    global $pdo;

    /* ── Stats globales ── */
    $stats = $pdo->query("
        SELECT
            (SELECT COUNT(*) FROM commande)                             AS total_commandes,
            (SELECT COUNT(*) FROM commande WHERE statut = 'payee')      AS commandes_payees,
            (SELECT COUNT(*) FROM commande WHERE statut = 'en_attente') AS commandes_attente,
            (SELECT COALESCE(SUM(montant), 0) FROM paiement WHERE statut = 'accepte') AS ca_total,
            (SELECT COUNT(*) FROM paiement)                             AS total_paiements,
            (SELECT COUNT(*) FROM paiement WHERE statut = 'accepte')    AS paiements_acceptes
    ")->fetch(PDO::FETCH_ASSOC);

    /* ── Dernières commandes ── */
    global $dernieres_commandes;
    $dernieres_commandes = $pdo->query("
        SELECT c.id, c.statut, c.total_ttc,
               c.facturation_nom, c.facturation_prenom, c.facturation_email
        FROM commande c
        ORDER BY c.id DESC
        LIMIT 5
    ")->fetchAll(PDO::FETCH_ASSOC);

    /* ── Derniers paiements ── */
    global $derniers_paiements;
    $derniers_paiements = $pdo->query("
        SELECT p.id, p.statut, p.montant, p.date_paiement, p.ref_banque,
               c.facturation_nom, c.facturation_prenom
        FROM paiement p
        JOIN commande c ON c.id = p.id_commande
        ORDER BY p.id DESC
        LIMIT 5
    ")->fetchAll(PDO::FETCH_ASSOC);

    global $bo_stats;
    $bo_stats = $stats;

    require_once 'Backoffice/view/v-bo-dashboard.php';
}
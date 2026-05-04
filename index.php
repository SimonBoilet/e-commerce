<?php

session_start();

require_once 'model/model.php';
require_once 'controller/c-acceuil.php';
require_once 'controller/c-produit.php';
require_once 'controller/c-panier.php';
require_once 'controller/c-paiement.php';
require_once 'controller/c-commande.php';
require_once 'controller/c-ipn.php';
require_once 'controller/api/c-apiLIste.php';
require_once 'controller/api/c-apiCommande.php';
require_once 'controller/api/c-apiPaiement.php';
require_once 'Backoffice/controller/c-bo-dashboard.php';
require_once 'Backoffice/controller/c-bo-commande.php';
require_once 'Backoffice/controller/c-bo-paiement.php';

/* ══ ROUTING API ══════════════════════════════════════════════════ */
if (isset($_GET['pageAPI'])) {
    switch ($_GET['pageAPI']) {
        case 'liste':    APIListe();    break;
        case 'commande': APICommande(); break;
        case 'paiement': APIPaiement(); break;
        default:         APIListe();    break;
    }
    exit;
}

/* ══ ROUTING BACKOFFICE ═══════════════════════════════════════════ */
if (isset($_GET['pageBO'])) {
    switch ($_GET['pageBO']) {
        case 'dashboard': BODashboard(); break;
        case 'commande':  BOCommande();  break;
        case 'paiement':  BOPaiement();  break;
        default:          BODashboard(); break;
    }
    exit;
}

/* ══ ACTIONS POST PANIER ══════════════════════════════════════════ */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'modifier':
            modifierQuantite((int)$_POST['id_ligne'], (int)$_POST['quantite']);
            header('Location: /panier/');
            exit;
        case 'supprimer':
            supprimerLigne((int)$_POST['id_ligne']);
            header('Location: /panier/');
            exit;
        case 'vider':
            viderPanier();
            header('Location: /panier/');
            exit;
    }
}

/* ══ ROUTING SITE ════════════════════════════════════════════════ */
if (isset($_GET['page']) && $_GET['page']) {
    switch ($_GET['page']) {
        case 'produit':  produit();  break;
        case 'panier':   panier();   break;
        case 'paiement': paiement(); break;
        case 'commande': commande(); break;
        case 'ipn':      ipn();      break;
        default:         accueil();  break;
    }
} else {
    accueil();
}
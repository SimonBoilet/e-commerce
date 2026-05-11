<?php


date_default_timezone_set('Europe/Paris');


// ─── Configuration ───────────────────────────────────────────────
$host = 'localhost';
$port = 3306;
$dbname = 'b2-gp96';
$username = 'b2-gp96';
$password = 'X2!Q8V3?Z7F4T1p9A6';
$charset = 'utf8';

// ─── DSN (Data Source Name) ───────────────────────────────────────
// MySQL / MariaDB :
$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

// PostgreSQL (décommenter si besoin) :
// $dsn = "pgsql:host=$host;port=5432;dbname=$dbname";

// SQLite (décommenter si besoin) :
// $dsn = "sqlite:/chemin/vers/ma_base.db";

// ─── Options PDO ──────────────────────────────────────────────────
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Lance des exceptions sur erreur
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Retourne des tableaux associatifs
    PDO::ATTR_EMULATE_PREPARES => false,                   // Requêtes préparées natives
];

// ─── Connexion ────────────────────────────────────────────────────
try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // Ne jamais afficher $e->getMessage() en production
    error_log($e->getMessage());
    throw new RuntimeException('Impossible de se connecter à la base de données.', (int)$e->getCode());
}

function verifierToken() {
    $token_attendu = "VOLTEX2026";
    $token_recu = $_POST['token'] ?? '';

    if ($token_recu !== $token_attendu) {
        header('Content-Type: application/json');
        http_response_code(401);
        echo json_encode(["error" => "Token invalide ou absent"]);
        exit; // On arrête tout ici
    }
}
<?php
function APIListe() {
    global $pdo;
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(["error" => "Method Not Allowed. Use POST."]);
        exit;
    }

    $db_status = "OFFLINE";
    try {
        if ($pdo->query("SELECT 1")) $db_status = "ONLINE";
    } catch (Exception $e) { $db_status = "ERROR"; }

    $base = 'https://b2-gp96.kevinpecro.info/api/';
    $notice = [
        'api'       => 'VOLTEX API',
        'health' => [
            'database' => $db_status,
            'php_version' => PHP_VERSION,
            'server' => $_SERVER['SERVER_SOFTWARE']
        ],
        'version'   => '1.0',
        'auth'      => 'Toutes les requêtes nécessitent un POST avec le champ token',
        'endpoints' => [
            [
                'nom'         => 'Liste des endpoints',
                'url'         => $base . 'liste/',
                'methode'     => 'POST',
                'description' => 'Retourne la liste de tous les endpoints disponibles.',
                'params'      => ['token' => 'obligatoire'],
            ],
            [
                'nom'         => 'Commandes',
                'url'         => $base . 'commande/',
                'methode'     => 'POST',
                'description' => 'Liste ou détail commande.',
                'params'      => ['token' => 'obligatoire', 'id' => 'optionnel'],
            ],
            [
                'nom'         => 'Paiements',
                'url'         => $base . 'paiement/',
                'methode'     => 'POST',
                'description' => 'Liste ou détail paiements.',
                'params'      => ['token' => 'obligatoire', 'id' => 'optionnel'],
            ]
        ]
    ];

    echo json_encode($notice, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
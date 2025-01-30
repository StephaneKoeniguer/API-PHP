<?php

include('Connect.php');
include('Produit.php');

// Récupérer la méthode HTTP de la requête
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Créer une instance de produit et récupère un objet PDO de la classe Connect
$produit = new Produit((new Connect())->getConnection());

// Récupérer l'URL de la requête (route), ignore les paramètres de la requête (?id=...)
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Routage
switch ($requestUri) {
    case '/produits' :
        echo $produit->getAllProduit();
        break;
    case '/produits/show':
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
        if (!empty($id) && $requestMethod == 'GET') {
            echo $produit->showProduit($id);
        } else {
            echo json_encode([
                "status" => 400,
                "error" => "ID de produit manquant."
            ]);
        }
        break;
    case '/produits/add' :
        $data = json_decode(file_get_contents('php://input'), true);
        if ($requestMethod == 'POST') {
            echo $produit->addProduit($data);
        } else {
            echo json_encode([
                "status" => 400,
                "error" => "Methode non autorisée",
            ]);
        }
        break;
    case '/produits/update' :
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
        $data = json_decode(file_get_contents('php://input'), true);
        if (!empty($id) && $requestMethod == 'PUT') {
            echo $produit->updateProduit($id, $data);
        } else {
            echo json_encode([
                "status" => 400,
                "error" => "ID de produit manquant ou méthode non autorisée"
            ]);
        }
        break;
    case '/produits/delete' :
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
        if (!empty($id) && $requestMethod == 'DELETE') {
            echo $produit->deleteProduit($id);
        } else {
            echo json_encode([
                "status" => 400,
                "error" => "ID de produit manquant ou méthode non autorisée"
            ]);
        }
        break;
    default :
        echo json_encode([
            "status" => 404,
            "message" => "Page non trouvée."
        ]);
        break;
}

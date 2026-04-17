<?php

declare(strict_types=1);

use App\Config\Database;
use App\Controller\AdminController;
use App\Controller\AuthController;
use App\Controller\HomeController;
use App\Controller\TripController;
use App\Core\Auth;
use Buki\Router\Router;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

// Je charge la configuration locale si le fichier .env existe.
if (file_exists(__DIR__ . '/../.env')) {
    Dotenv::createImmutable(__DIR__ . '/..')->load();
}

// J'ouvre la session pour gerer l'authentification et les messages flash.
session_start();

// Je prepare les services partages (connexion PDO + service d'authentification).
$pdo = Database::getConnection();
$auth = new Auth($pdo);

// J'instancie mes controleurs.
$homeController = new HomeController($pdo, $auth);
$authController = new AuthController($auth);
$tripController = new TripController($pdo, $auth);
$adminController = new AdminController($pdo, $auth);

$router = new Router();

// Routes publiques et authentification.
$router->get('/', fn() => $homeController->index());
$router->get('/login', fn() => $authController->showLogin());
$router->post('/login', fn() => $authController->login());
$router->post('/logout', fn() => $authController->logout());

// Routes metier pour la gestion des trajets.
$router->get('/trajets/creer', fn() => $tripController->showCreate());
$router->post('/trajets/creer', fn() => $tripController->create());
$router->get('/trajets/modifier/:id', fn($id) => $tripController->showEdit((int) $id));
$router->post('/trajets/modifier/:id', fn($id) => $tripController->update((int) $id));
$router->post('/trajets/supprimer/:id', fn($id) => $tripController->delete((int) $id));

// Routes d'administration (agences, utilisateurs, supervision des trajets).
$router->get('/admin', fn() => $adminController->dashboard());
$router->get('/admin/agences/creer', fn() => $adminController->showAgencyCreate());
$router->post('/admin/agences/creer', fn() => $adminController->createAgency());
$router->get('/admin/agences/modifier/:id', fn($id) => $adminController->showAgencyEdit((int) $id));
$router->post('/admin/agences/modifier/:id', fn($id) => $adminController->updateAgency((int) $id));
$router->post('/admin/agences/supprimer/:id', fn($id) => $adminController->deleteAgency((int) $id));
$router->post('/admin/trajets/supprimer/:id', fn($id) => $adminController->deleteTrip((int) $id));

$router->run();

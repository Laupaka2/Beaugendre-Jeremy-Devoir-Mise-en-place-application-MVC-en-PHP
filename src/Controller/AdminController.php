<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Auth;
use App\Core\Controller;
use App\Repository\AgencyRepository;
use App\Repository\TripRepository;
use App\Repository\UserRepository;
use PDO;

/**
 * Controleur reserve a l'administrateur.
 * Je regroupe ici les fonctionnalites de supervision et de gestion des agences.
 */
final class AdminController extends Controller
{
    public function __construct(private readonly PDO $pdo, private readonly Auth $auth)
    {
    }

    /**
     * Affiche le tableau de bord administrateur.
     */
    public function dashboard(): void
    {
        $this->assertAdmin();

        // Je prepare toutes les donnees d'administration en une seule page.
        $this->render('admin/dashboard', [
            'title' => 'Administration',
            'auth' => $this->auth,
            'user' => $this->auth->user(),
            'users' => (new UserRepository($this->pdo))->findAll(),
            'agencies' => (new AgencyRepository($this->pdo))->findAll(),
            'trips' => (new TripRepository($this->pdo))->findAll(),
        ]);
    }

    /**
     * Affiche le formulaire de creation d'agence.
     */
    public function showAgencyCreate(): void
    {
        $this->assertAdmin();
        $this->render('admin/agency_form', [
            'title' => 'Creer une agence',
            'auth' => $this->auth,
            'user' => $this->auth->user(),
            'agency' => null,
        ]);
    }

    /**
     * Cree une nouvelle agence.
     */
    public function createAgency(): void
    {
        $this->assertAdmin();
        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            $this->setFlash('danger', 'Le nom de l agence est obligatoire.');
            $this->redirect('/admin/agences/creer');
        }

        // Ecriture + redirection + message flash conformes au brief.
        (new AgencyRepository($this->pdo))->create($name);
        $this->setFlash('success', 'Agence creee.');
        $this->redirect('/admin');
    }

    /**
     * Affiche le formulaire de modification d'agence.
     */
    public function showAgencyEdit(int $id): void
    {
        $this->assertAdmin();
        $agency = (new AgencyRepository($this->pdo))->findById($id);
        if ($agency === null) {
            $this->setFlash('danger', 'Agence introuvable.');
            $this->redirect('/admin');
        }

        $this->render('admin/agency_form', [
            'title' => 'Modifier une agence',
            'auth' => $this->auth,
            'user' => $this->auth->user(),
            'agency' => $agency,
        ]);
    }

    /**
     * Met a jour une agence existante.
     */
    public function updateAgency(int $id): void
    {
        $this->assertAdmin();
        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            $this->setFlash('danger', 'Le nom de l agence est obligatoire.');
            $this->redirect('/admin/agences/modifier/' . $id);
        }

        // Mise a jour d'agence depuis le formulaire admin.
        (new AgencyRepository($this->pdo))->update($id, $name);
        $this->setFlash('success', 'Agence modifiee.');
        $this->redirect('/admin');
    }

    /**
     * Supprime une agence.
     */
    public function deleteAgency(int $id): void
    {
        $this->assertAdmin();
        (new AgencyRepository($this->pdo))->delete($id);
        $this->setFlash('success', 'Agence supprimee.');
        $this->redirect('/admin');
    }

    /**
     * Supprime un trajet depuis l'espace admin.
     */
    public function deleteTrip(int $id): void
    {
        $this->assertAdmin();
        (new TripRepository($this->pdo))->delete($id);
        $this->setFlash('success', 'Trajet supprime.');
        $this->redirect('/admin');
    }

    private function assertAdmin(): void
    {
        // Protection d'acces aux routes d'administration.
        if (!$this->auth->isAdmin()) {
            $this->setFlash('danger', 'Acces reserve a l administrateur.');
            $this->redirect('/');
        }
    }
}

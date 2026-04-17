<?php if (!$auth->isLoggedIn()): ?>
    <h1 class="message-title">Pour obtenir plus d'informations sur un trajet, veuillez vous connecter</h1>
<?php else: ?>
    <h1 class="section-title">Trajets proposes</h1>
<?php endif; ?>

<?php if ($trips === []): ?>
    <div class="alert alert-info">Aucun trajet disponible pour le moment.</div>
<?php else: ?>
    <?php // Tableau principal des trajets affiches selon les regles du brief. ?>
    <div class="table-responsive trips-table">
        <table class="table table-striped align-middle mb-0">
            <thead>
            <tr>
                <th>Depart</th>
                <th>Date depart</th>
                <th>Heure depart</th>
                <th>Arrivee</th>
                <th>Date arrivee</th>
                <th>Heure arrivee</th>
                <th>Places dispo</th>
                <?php if ($auth->isLoggedIn()): ?>
                    <th class="table-action">Actions</th>
                <?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($trips as $trip): ?>
                <tr>
                    <td><?= htmlspecialchars($trip['departure_agency']) ?></td>
                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($trip['departure_at']))) ?></td>
                    <td><?= htmlspecialchars(date('H:i', strtotime($trip['departure_at']))) ?></td>
                    <td><?= htmlspecialchars($trip['arrival_agency']) ?></td>
                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($trip['arrival_at']))) ?></td>
                    <td><?= htmlspecialchars(date('H:i', strtotime($trip['arrival_at']))) ?></td>
                    <td><?= (int) $trip['available_seats'] ?></td>
                    <?php if ($auth->isLoggedIn()): ?>
                        <td>
                            <button class="btn btn-sm btn-outline-dark mini-action" data-bs-toggle="modal" data-bs-target="#trip-<?= (int) $trip['id'] ?>" title="Voir les details">
                                <i class="bi bi-eye"></i>
                            </button>
                            <?php if ($auth->isAdmin() || (int) $trip['user_id'] === (int) $user['id']): ?>
                                <a class="btn btn-sm btn-outline-secondary mini-action" href="/trajets/modifier/<?= (int) $trip['id'] ?>" title="Modifier">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="/trajets/supprimer/<?= (int) $trip['id'] ?>" method="post" class="d-inline">
                                    <button class="btn btn-sm btn-outline-danger mini-action" type="submit" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                </tr>

                <?php if ($auth->isLoggedIn()): ?>
                    <?php // La modale de contact n'est visible que pour un utilisateur connecte. ?>
                    <div class="modal fade" id="trip-<?= (int) $trip['id'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Contact trajet</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Conducteur :</strong> <?= htmlspecialchars($trip['first_name'] . ' ' . $trip['last_name']) ?></p>
                                    <p><strong>Email :</strong> <?= htmlspecialchars($trip['email']) ?></p>
                                    <p><strong>Telephone :</strong> <?= htmlspecialchars($trip['phone']) ?></p>
                                    <p><strong>Nombre total de places :</strong> <?= (int) $trip['total_seats'] ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

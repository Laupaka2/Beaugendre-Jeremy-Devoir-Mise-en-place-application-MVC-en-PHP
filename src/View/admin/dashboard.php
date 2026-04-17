<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 m-0">Tableau de bord administrateur</h1>
    <a class="btn btn-primary" href="/admin/agences/creer">Ajouter une agence</a>
</div>

<?php // Bloc de consultation des utilisateurs (admin uniquement). ?>
<h2 id="utilisateurs" class="h5 mt-4">Utilisateurs</h2>
<div class="table-responsive mb-4">
    <table class="table table-sm table-bordered">
        <thead><tr><th>Nom</th><th>Email</th><th>Telephone</th><th>Role</th></tr></thead>
        <tbody>
        <?php foreach ($users as $member): ?>
            <tr>
                <td><?= htmlspecialchars($member['first_name'] . ' ' . $member['last_name']) ?></td>
                <td><?= htmlspecialchars($member['email']) ?></td>
                <td><?= htmlspecialchars($member['phone']) ?></td>
                <td><?= htmlspecialchars($member['role']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php // Bloc CRUD des agences. ?>
<h2 id="agences" class="h5 mt-4">Agences</h2>
<div class="table-responsive mb-4">
    <table class="table table-sm table-bordered">
        <thead><tr><th>Nom</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($agencies as $agency): ?>
            <tr>
                <td><?= htmlspecialchars($agency['name']) ?></td>
                <td>
                    <a class="btn btn-sm btn-outline-warning" href="/admin/agences/modifier/<?= (int) $agency['id'] ?>">Modifier</a>
                    <form method="post" action="/admin/agences/supprimer/<?= (int) $agency['id'] ?>" class="d-inline">
                        <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php // Bloc de supervision des trajets avec suppression admin. ?>
<h2 id="trajets" class="h5 mt-4">Trajets</h2>
<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead><tr><th>Depart</th><th>Arrivee</th><th>Date</th><th>Auteur</th><th>Places dispo</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($trips as $trip): ?>
            <tr>
                <td><?= htmlspecialchars($trip['departure_agency']) ?></td>
                <td><?= htmlspecialchars($trip['arrival_agency']) ?></td>
                <td><?= htmlspecialchars($trip['departure_at']) ?></td>
                <td><?= htmlspecialchars($trip['email']) ?></td>
                <td><?= (int) $trip['available_seats'] ?></td>
                <td>
                    <form method="post" action="/admin/trajets/supprimer/<?= (int) $trip['id'] ?>">
                        <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

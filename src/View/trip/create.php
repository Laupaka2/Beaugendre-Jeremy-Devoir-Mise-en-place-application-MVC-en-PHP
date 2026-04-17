<?php
$isEdit = $trip !== null;
$action = $isEdit ? '/trajets/modifier/' . (int) $trip['id'] : '/trajets/creer';
?>

<h1 class="h3 mb-3"><?= $isEdit ? 'Modifier un trajet' : 'Creer un trajet' ?></h1>

<form action="<?= $action ?>" method="post" class="card card-body shadow-sm">
    <?php // Les donnees conducteur sont pre-remplies et non modifiables (consigne du brief). ?>
    <h2 class="h6">Conducteur</h2>
    <div class="row g-3 mb-2">
        <div class="col-md-3">
            <label class="form-label">Nom</label>
            <input class="form-control" value="<?= htmlspecialchars($user['last_name']) ?>" readonly>
        </div>
        <div class="col-md-3">
            <label class="form-label">Prenom</label>
            <input class="form-control" value="<?= htmlspecialchars($user['first_name']) ?>" readonly>
        </div>
        <div class="col-md-3">
            <label class="form-label">Email</label>
            <input class="form-control" value="<?= htmlspecialchars($user['email']) ?>" readonly>
        </div>
        <div class="col-md-3">
            <label class="form-label">Telephone</label>
            <input class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" readonly>
        </div>
    </div>

    <hr>
    <?php // Partie editable du formulaire trajet. ?>
    <h2 class="h6">Informations du trajet</h2>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Agence depart</label>
            <select class="form-select" name="departure_agency_id" required>
                <option value="">Choisir</option>
                <?php foreach ($agencies as $agency): ?>
                    <option value="<?= (int) $agency['id'] ?>" <?= $isEdit && (int) $trip['departure_agency_id'] === (int) $agency['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($agency['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Agence arrivee</label>
            <select class="form-select" name="arrival_agency_id" required>
                <option value="">Choisir</option>
                <?php foreach ($agencies as $agency): ?>
                    <option value="<?= (int) $agency['id'] ?>" <?= $isEdit && (int) $trip['arrival_agency_id'] === (int) $agency['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($agency['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Depart (date/heure)</label>
            <input class="form-control" type="datetime-local" name="departure_at"
                   value="<?= $isEdit ? htmlspecialchars(date('Y-m-d\TH:i', strtotime($trip['departure_at']))) : '' ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Arrivee (date/heure)</label>
            <input class="form-control" type="datetime-local" name="arrival_at"
                   value="<?= $isEdit ? htmlspecialchars(date('Y-m-d\TH:i', strtotime($trip['arrival_at']))) : '' ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Nombre total de places</label>
            <input class="form-control" type="number" min="1" name="total_seats" value="<?= $isEdit ? (int) $trip['total_seats'] : 1 ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Places disponibles</label>
            <input class="form-control" type="number" min="0" name="available_seats" value="<?= $isEdit ? (int) $trip['available_seats'] : 1 ?>" required>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-primary" type="submit"><?= $isEdit ? 'Enregistrer' : 'Creer' ?></button>
    </div>
</form>

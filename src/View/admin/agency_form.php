<?php
$isEdit = $agency !== null;
$action = $isEdit ? '/admin/agences/modifier/' . (int) $agency['id'] : '/admin/agences/creer';
?>

<h1 class="h3 mb-3"><?= $isEdit ? 'Modifier agence' : 'Creer agence' ?></h1>
<?php // Formulaire reutilise en creation et en modification d'agence. ?>
<form method="post" action="<?= $action ?>" class="card card-body shadow-sm">
    <div class="mb-3">
        <label class="form-label" for="name">Nom de l agence</label>
        <input class="form-control" id="name" name="name" value="<?= $isEdit ? htmlspecialchars($agency['name']) : '' ?>" required>
    </div>
    <button class="btn btn-primary" type="submit"><?= $isEdit ? 'Enregistrer' : 'Creer' ?></button>
</form>

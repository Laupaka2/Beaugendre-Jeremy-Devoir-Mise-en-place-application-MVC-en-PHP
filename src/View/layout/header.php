<header class="pt-4">
    <?php // Le header change selon le role (visiteur, utilisateur, administrateur). ?>
    <div class="container topbar px-4 py-2 d-flex justify-content-between align-items-center">
        <a href="<?= $auth->isAdmin() ? '/admin' : '/' ?>" class="brand-link">Touche pas au klaxon</a>
        <nav class="d-flex align-items-center gap-2">
            <?php if (!$auth->isLoggedIn()): ?>
                <a class="btn btn-dark btn-sm px-3" href="/login">Connexion</a>
            <?php elseif ($auth->isAdmin()): ?>
                <a class="btn btn-admin btn-sm" href="/admin#utilisateurs">Utilisateurs</a>
                <a class="btn btn-admin btn-sm" href="/admin#agences">Agences</a>
                <a class="btn btn-admin btn-sm" href="/admin#trajets">Trajets</a>
                <span class="px-2">Bonjour <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></span>
                <form action="/logout" method="post" class="d-inline">
                    <button class="btn btn-dark btn-sm px-3" type="submit">Deconnexion</button>
                </form>
            <?php else: ?>
                <a class="btn btn-dark btn-sm px-3" href="/trajets/creer">Creer un trajet</a>
                <span class="px-2">Bonjour <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></span>
                <form action="/logout" method="post" class="d-inline">
                    <button class="btn btn-dark btn-sm px-3" type="submit">Deconnexion</button>
                </form>
            <?php endif; ?>
        </nav>
    </div>
</header>

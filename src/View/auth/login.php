<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <h1 class="h3 mb-3">Connexion</h1>
        <?php // Formulaire de connexion avec email + mot de passe. ?>
        <form action="/login" method="post" class="card card-body shadow-sm">
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input class="form-control" type="email" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Mot de passe</label>
                <input class="form-control" type="password" id="password" name="password" required>
            </div>
            <button class="btn btn-primary" type="submit">Se connecter</button>
        </form>
    </div>
</div>

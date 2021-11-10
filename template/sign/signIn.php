<!-- Header -->
<?php include "../template/components/header.php"; ?>

<main class="container h-100">
    <div class="row g-5 h-100">
        <div class="col-12 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-4 bgd-darklight rounded p-4">
                    <h3 class="text-center pb-3">Connexion</h3>
                    <form action="/signin" method="post" class="pb-4">
                        <div class="form-group pb-2">
                            <label for="pseudoInput">Votre email ou pseudo :</label>
                            <input type="text" class="form-control mt-2" id="pseudoInput" name="pseudoInput" value="" required>
                        </div>

                        <div class="form-group pb-2">
                            <label for="passwordInput">Votre mot de passe :</label>
                            <input type="password" class="form-control mt-2" id="passwordInput" name="passwordInput" value="" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn-custom">Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
<?php include "../template/components/footer.php" ?>

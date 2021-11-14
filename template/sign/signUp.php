<!-- Header -->
<?php include "../template/components/header.php"; ?>

<main class="container h-100">
    <div class="row g-5 h-100">
        <div class="col-12 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-4 bgd-darklight rounded p-4">
                    <h3 class="text-center pb-3">Inscrivez-vous</h3>
                    <form action="/signup" method="post" class="pb-4">
                        <div class="form-group pb-2">
                            <label for="pseudoInput">Votre pseudo :</label>
                            <input type="text" class="form-control mt-2" id="pseudoInput" name="pseudoInput" value="" required>
                            <?php
                                if (!empty($formErrors['pseudoInput'])):
                            ?>
                                <p class=""><?= $formErrors['pseudoInput'] ?></p>
                            <?php
                                endif;
                            ?>
                        </div>

                        <div class="form-group pb-2">
                            <label for="emailInput">Votre adresse mail :</label>
                            <input type="email" class="form-control mt-2" id="emailInput" name="emailInput" value="" required>
                        </div>

                        <div class="form-group pb-2">
                            <label for="passwordInput">Votre mot de passe :</label>
                            <input type="password" class="form-control mt-2" id="passwordInput" name="passwordInput" value="" required>
                        </div>

                        <div class="form-group pb-2">
                            <label for="cPasswordInput">Confirmation mot de passe :</label>
                            <input type="password" class="form-control mt-2" id="cPasswordInput" name="cPasswordInput" value="" required>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="checkInput" name="checkInput" value="1" required>
                            <label class="form-check-label" for="checkInput">J'accepte les <a href="#">CGU</a></label>
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

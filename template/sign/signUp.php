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
                            <input type="text" class="form-control mt-2 <?php echo(!empty($formErrors['pseudoInput'])) ? 'border-danger' : '';?>" id="pseudoInput" name="pseudoInput" value="" required>
                            <?php
                                if (!empty($formErrors['pseudoInput'])):
                            ?>
                                <small class="text-danger"><?= $formErrors['pseudoInput'] ?></small>
                            <?php
                                endif;
                            ?>
                        </div>

                        <div class="form-group pb-2">
                            <label for="emailInput">Votre adresse mail :</label>
                            <input type="email" class="form-control mt-2 <?php echo(!empty($formErrors['emailInput'])) ? 'border-danger' : '';?>" id="emailInput" name="emailInput" value="" required>
                            <?php
                                if (!empty($formErrors['emailInput'])):
                            ?>
                                <small class="text-danger"><?= $formErrors['emailInput'] ?></small>
                            <?php
                                endif;
                            ?>
                        </div>

                        <div class="form-group pb-2">
                            <label for="passwordInput">Votre mot de passe :</label>
                            <input type="password" class="form-control mt-2 <?php echo(!empty($formErrors['passwordInput'])) ? 'border-danger' : '';?>" id="passwordInput" name="passwordInput" value="" required>
                            <?php
                                if (!empty($formErrors['passwordInput'])):
                            ?>
                                <small class="text-danger"><?= $formErrors['passwordInput'] ?></small>
                            <?php
                                endif;
                            ?>
                        </div>

                        <div class="form-group pb-2">
                            <label for="cPasswordInput">Confirmation mot de passe :</label>
                            <input type="password" class="form-control mt-2 <?php echo(!empty($formErrors['cPasswordInput'])) ? 'border-danger' : '';?>" id="cPasswordInput" name="cPasswordInput" value="" required>
                            <?php
                                if (!empty($formErrors['cPasswordInput'])):
                            ?>
                                <small class="text-danger"><?= $formErrors['cPasswordInput'] ?></small>
                            <?php
                                endif;
                            ?>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input <?php echo(!empty($formErrors['checkInput'])) ? 'border-danger' : '';?>" id="checkInput" name="checkInput" value="1" required>
                            <label class="form-check-label" for="checkInput">J'accepte les <a href="#">CGU</a></label>
                            <?php
                                if (!empty($formErrors['checkInput'])):
                            ?>
                                <small class="text-danger"><?= $formErrors['checkInput'] ?></small>
                            <?php
                                endif;
                            ?>
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

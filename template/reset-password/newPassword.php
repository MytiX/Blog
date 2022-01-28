<!-- Header -->
<?php include "../template/components/header.php"; ?>

<main class="container h-100">
    <div class="row g-5 h-100">
        <div class="col-12 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-4 bgd-darklight rounded p-4">
                    <h3 class="text-center pb-3">Réinitialiser votre mot de passe</h3>
                    <?php if (!empty($errorFlash = $session->flash('errorFlash'))):?>
                        <div class="alert alert-warning" role="alert">
                            <?= $errorFlash ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($successFlash = $session->flash('successFlash'))):?>
                        <div class="alert alert-success" role="alert">
                            <?= $successFlash ?>
                        </div>
                    <?php endif; ?>
                    <form action="" method="post" class="pb-4">
                        <div class="form-group pb-2">
                            <label for="passwordInput">Nouveau mot de passe :</label>
                            <input type="password" class="form-control mt-2" id="passwordInput" name="passwordInput" required>
                            <?php if (!empty($errorFlash = $session->flash('passwordInput'))):?>
                                <small class="text-danger"><?= $errorFlash ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="form-group pb-2">
                            <label for="cPasswordInput">Confirmation mot de passe :</label>
                            <input type="password" class="form-control mt-2" id="cPasswordInput" name="cPasswordInput" required>
                            <?php if (!empty($errorFlash = $session->flash('cPasswordInput'))):?>
                                <small class="text-danger"><?= $errorFlash ?></small>
                            <?php endif; ?>
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

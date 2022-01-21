<div class="row justify-content-around">
    <div class="col-12 col-md-8">
        <?php if (!empty($successFlash = $session->flash('successFlash'))):?>
            <small class="text-success"><?= $successFlash ?></small>
        <?php endif; ?>
    </div>
    <div class="col-12 col-md-8">
        <h3 class="blog-post-title mb-4 border-bottom-custom pb-4">Contactez-moi !</h3>
        <form action="#" method="post" class="pb-4">
            <div class="form-group pb-2">
                <label for="emailInput">Votre adresse mail :</label>
                <input type="email" class="form-control mt-2" id="emailInput" name="emailInput" value="<?= (!empty($form['emailInput'])) ? $form['emailInput'] : '' ?>" required>
                <?php if (!empty($errorFlash = $session->flash('emailInput'))):?>
                    <small class="text-danger"><?= $errorFlash ?></small>
                <?php endif; ?>
            </div>
            <div class="form-group pb-2">
                <label for="objetInput">Quel est l'objet de votre message ?</label>
                <input type="text" class="form-control mt-2" id="objetInput" name="objetInput" value="<?= (!empty($form['objetInput'])) ? $form['objetInput'] : '' ?>" required>
                <?php if (!empty($errorFlash = $session->flash('objetInput'))):?>
                    <small class="text-danger"><?= $errorFlash ?></small>
                <?php endif; ?>
            </div>
            <div class="form-group pb-2">
                <label for="messageInput">Votre message :</label>
                <textarea class="form-control mt-2" id="messageInput" name="messageInput" rows="3" required><?= (!empty($form['messageInput'])) ? $form['messageInput'] : '' ?></textarea>
                <?php if (!empty($errorFlash = $session->flash('messageInput'))):?>
                    <small class="text-danger"><?= $errorFlash ?></small>
                <?php endif; ?>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="checkInput" name="checkInput" value="1" required>
                <label class="form-check-label" for="checkInput">J'accepte les <a href="#">CGU</a></label>
                <?php if (!empty($errorFlash = $session->flash('checkInput'))):?>
                    <small class="text-danger"><?= $errorFlash ?></small>
                <?php endif; ?>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn-custom">Envoyer</button>
            </div>
        </form>
    </div>
</div>

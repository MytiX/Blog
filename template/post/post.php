<!-- Header -->
<?php include '../template/components/header.php'; ?>

<main class="container">

    <div class="row g-5">
        <div class="col-md-8">
            <article class="blog-post">

            <div class="d-flex justify-content-between">
                <span class="blog-post-meta">Dernière mise à jour le :
                    <?= $post['date']?>
                </span>
                <span class="blog-post-meta">Auteur :
                    <?= $post['author'] ?>
                </span>
            </div>

                <h2 class="pb-4 fst-italic blog-post-title">
                    <?= $post['title'] ?>
                </h2>

                <img src="../uploads/img/<?= $post['img'] ?>" alt="" class="img-fluid pb-3">

                <?= $post['content'] ?>

            </article>

            <div class="separator border-bottom-custom"></div>

            <div class="comments">

                <h3 class="mt-2">Les commentaires</h3>

                <?php if(!empty($post['comments'])): ?>

                    <?php foreach ($post['comments'] as $comment):?>

                        <div class="comment border-rounded my-3 p-3">
                            <p class="mb-0"><?= $comment['content'] ?></p>
                            <p class="text-end mb-0"><?= $comment['pseudo'] ?></p>
                        </div>

                    <?php endforeach;?>

                <?php else: ?>
                    <p>Pas de commentaire</p>
                <?php endif ?>

                <form action="" method="post" class="py-2">

                    <div class="form-group py-2">
                        <label for="content" class="py-2">Votre commentaire</label>
                        <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                        <?php if (!empty($errorFlash = $session->flash('content'))):?>
                            <small class="text-danger"><?= $errorFlash ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn-custom">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>

        <?php include '../template/components/aside.php'; ?>
    </div>
</main>

<!-- Footer -->
<?php include '../template/components/footer.php'; ?>

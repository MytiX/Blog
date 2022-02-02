<!-- Header -->
<?php include "../template/components/header.php"; ?>

<main class="container">
    <div class="row py-3">
        <div class="col-12">
            <a href="/admin/post/add" class="btn btn-custom a-custom">Créer un article</a>
            <?php if (!empty($successFlash = $session->flash('successFlash'))):?>
                <span class="alert alert-success mx-5" role="alert"><?= $successFlash ?></span>
            <?php endif; ?>
            <?php if (!empty($errorFlash = $session->flash('errorFlash'))):?>
                <span class="alert alert-danger mx-5" role="alert"><?= $errorFlash ?></span>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-dark table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Titre</th>
                        <th scope="col">Crée le</th>
                        <th scope="col">Dernière mise à jour</th>
                        <th scope="col">Active</th>
                        <th scope="col">Promu</th>
                        <th scope="col">Commentaires</th>
                        <th colspan="2">Modification</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($posts)): ?>
                        <?php foreach ($posts as $post): ?>
                            <tr>
                                <td><?= $post->getId() ?></td>
                                <td><?= htmlspecialchars($post->getTitle()) ?></td>
                                <td><?= $post->getCreatedAt()->format('d/m/Y H:i:s') ?></td>
                                <td><?= $post->getUpdateAt()->format('d/m/Y H:i:s') ?></td>
                                <td><?= ($post->getActive() === 1) ? 'Oui' : 'Non' ?></td>
                                <td><?= ($post->getPromote() === 1) ? 'Oui' : 'Non' ?></td>
                                <td><?= (!empty($post->getComments())) ? 'Oui' : 'Non' ?></td>
                                <td><a href="/admin/post/edit/<?= $post->getId() ?>" class="btn btn-custom a-custom">Edition</a></td>
                                <td><a href="/admin/post/delete/<?= $post->getId() ?>" class="btn btn-custom a-custom">Suppression</a></td>
                            </tr>
                        <?php endforeach;?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Pas d'articles</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Footer -->
<?php include "../template/components/footer.php" ?>

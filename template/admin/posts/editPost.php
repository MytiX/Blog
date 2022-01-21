<!-- Header -->
<?php include "../template/components/header.php"; ?>

<main class="container">
    <?php if(!empty($post['image']) && is_string($post['image'])): ?>
        <div class="row">
            <div class="col-12 col-md-6">
                <p class="my-2">Photo de présentation</p>
                <img src="../../../uploads/img/<?= $post['image'] ?>" alt="" class="img-fluid">
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-12">
            <?php include "../template/admin/posts/components/formPost.php";?>
        </div>
    </div>
    <?php if($edit): ?>

    <!-- Commentaire -->
        <div class="row">
            <div class="col-12">
                <h2>Commentaires</h2>

                <div class="row">
                    <div class="col-12">
                        <?php if (!empty($successFlash = $session->flash('comments'))):?>
                            <span class="alert alert-success d-inline-block" role="alert"><?= $successFlash ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <table class="table table-dark table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Contenu</th>
                                    <th scope="col">Crée le</th>
                                    <th colspan="2">Approbation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($comments)): ?>
                                    <?php foreach ($comments as $comment): ?>
                                        <tr>
                                            <td><?= $comment->getContent() ?></td>
                                            <td><?= $comment->getCreatedAt()->format('d/m/Y H:i:s') ?></td>
                                            <?php if ($comment->getActive() === 0): ?>
                                                <td><a href="/admin/comment/validate/<?= $comment->getId() ?>" class="btn btn-custom a-custom">Valider</a></td>
                                            <?php else: ?>
                                                <td><a href="/admin/comment/disable/<?= $comment->getId() ?>" class="btn btn-custom a-custom">Désactiver</a></td>
                                            <?php endif; ?>
                                            <td><a href="/admin/comment/delete/<?= $comment->getId() ?>" class="btn btn-custom a-custom">Suppression</a></td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4">Pas de commentaire sur cet article</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main>

<script src="https://cdn.tiny.cloud/1/a8gv2ccn8gw086m4yhrujfp1fu5dn2oanajt5lm503et7vsv/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#content'
   });
</script>

<!-- Footer -->
<?php include "../template/components/footer.php" ?>

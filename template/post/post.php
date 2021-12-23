<!-- Header -->
<?php include '../template/components/header.php'; ?>

<main class="container">

    <div class="row g-5">
        <div class="col-md-8">
            <article class="blog-post">
                <h2 class="pb-4 mt-4 fst-italic blog-post-title">
                    <?php echo $post->getTitle(); ?>
                </h2>
                <p class="blog-post-meta">Dernière mise à jour le :
                    <?php
                        $date = new DateTime($post->getCreatedAt());

                        echo($date->format('d/m/Y'));
                    ?>
                </p>

                <img src="../uploads/img/<?= $post->getImage() ?>" alt="" class="img-fluid pb-3">

                <?php echo $post->getContent(); ?>

            </article>
        </div>

        <?php include '../template/components/aside.php'; ?>
    </div>
</main>

<!-- Footer -->
<?php include '../template/components/footer.php'; ?>

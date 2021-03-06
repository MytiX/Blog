<div class="row g-5">
    <div class="col-12 col-lg-8">
        <?php if(!empty($posts)): ?>
            <?php for ($i=0; $i < count($posts); $i++): ?>
                <article class="blog-post border-bottom-custom">
                    <a href="/blog/<?= $posts[$i]->getSlug() . '-' . $posts[$i]->getId()  ?>" class="a-custom">
                        <h2 class="blog-post-title"><?= $posts[$i]->getTitle() ?></h2>
                        <p><?= $posts[$i]->getHeader() ?></p>
                    </a>
                    <p class="blog-post-meta">
                        <?= $date = $posts[$i]->getUpdateAt()->format('d/m/Y') ?>
                    </p>
                </article>
            <?php endfor; ?>
            <?php else: ?>
                <p class="text-center">Aucun article à présenter</p>
            <?php endif; ?>
            <?php if(isset($pagination) && $pagination == true): ?>
                <?php include 'pagination.php' ?>
            <?php endif; ?>
    </div>

    <?php include 'aside.php' ?>
</div>

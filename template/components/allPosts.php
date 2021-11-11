<div class="row g-5">
    <div class="col-md-8">
        <h2 class="pb-4 mb-4 fst-italic border-bottom-custom">
            Les derniers articles
        </h2>

        <?php for ($i=0; $i < count($posts); $i++): ?>
            <article class="blog-post border-bottom-custom">
                <a href="/blog/<?= $posts[$i]->getSlug() . '-' . $posts[$i]->getId()  ?>" class="a-custom">
                    <h2 class="blog-post-title"><?= $posts[$i]->getTitle() ?></h2>
                    <p><?= $posts[$i]->getHeader(); ?></p>
                </a>
                <p class="blog-post-meta">
                    <?php
                        $date = new DateTime($posts[$i]->getCreatedAt());

                        echo($date->format('d/m/Y'));
                    ?>
                </p>
            </article>
        <?php endfor; ?>
    </div>

    <?php include 'aside.php' ?>
</div>
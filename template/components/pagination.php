<div class="col-md-12 text-center">
    <?php if($page > 1 ): ?>
        <a href="<?= sprintf('%s?page=%s', $route, $page - 1) ?>">Précédent</a>
    <?php endif; ?>

    <?= $page ?>

    <?php if($moreResult): ?>
        <a href="<?= sprintf('%s?page=%s', $route, $page + 1) ?>">Suivant</a>
    <?php endif; ?>

</div>

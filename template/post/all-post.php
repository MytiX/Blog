<?php
    $route = '/all-post';
    $pagination = true;
?>
<!-- Header -->
<?php include "../template/components/header.php"; ?>

<main class="container">
    <div class="row">
        <div class="col-md-8">
            <h2 class="pb-4 mb-4 fst-italic border-bottom-custom">
                Tous les articles
            </h2>
        </div>
    </div>
    <?php include "../template/components/allPosts.php" ?>
</main>

<!-- Footer -->
<?php include "../template/components/footer.php" ?>

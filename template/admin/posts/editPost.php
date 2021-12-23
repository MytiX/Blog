<!-- Header -->
<?php include "../template/components/header.php"; ?>

<main class="container">
    <div class="row">
        <div class="col-12">
            <?php include "../template/admin/posts/components/formPost.php";?>
        </div>
    </div>
    <?php if(null !== $post->getId()): ?>

    <!-- Commentaire -->
        <div class="row">
            <div class="col-12">
                <h2>Commentaires</h2>
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

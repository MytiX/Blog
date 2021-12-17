<!-- Header -->
<?php include "../template/components/header.php"; ?>

<main class="container">
    <div class="row">
        <div class="col-12">
            <form action="/admin/post/add" method="post" class="pb-4">
                <div class="form-group pb-2">
                    <label for="titleInput">Titre de l'article</label>
                    <input type="text" class="form-control mt-2" id="titleInput" name="titleInput" value="" required>
                </div>

                <div class="form-group pb-2">
                    <label for="teaserInput">Texte d'accroche</label>
                    <input type="text" class="form-control mt-2" id="teaserInput" name="teaserInput" value="" required>
                </div>

                <div class="form-group pb-2">
                    <label for="slugInput">Slug</label>
                    <input type="text" class="form-control mt-2" id="slugInput" name="slugInput" value="" required>
                </div>

                <div class="form-group pb-2">
                    <label for="contentInput">Contenu</label>
                    <textarea class="form-control" id="contentInput" name="contentInput" rows="20"></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn-custom">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="https://cdn.tiny.cloud/1/a8gv2ccn8gw086m4yhrujfp1fu5dn2oanajt5lm503et7vsv/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#contentInput'
   });
</script>

<!-- Footer -->
<?php include "../template/components/footer.php" ?>

<form action="" method="post" class="pb-4" enctype="multipart/form-data">
    <div class="form-group pb-2">
        <label for="title">Titre de l'article</label>
        <input type="text" class="form-control mt-2" id="title" name="title" value="<?php if(!empty($post->getTitle())) { echo($post->getTitle()); } ?>">
        <?php if (!empty($errorFlash = $session->flash('title'))):?>
            <small class="text-danger"><?= $errorFlash ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group pb-2">
        <label for="header">Texte d'accroche</label>
        <input type="text" class="form-control mt-2" id="header" name="header" value="<?php if(!empty($post->getHeader())) { echo($post->getHeader()); } ?>">
        <?php if (!empty($errorFlash = $session->flash('header'))):?>
            <small class="text-danger"><?= $errorFlash ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group pb-2">
        <label for="slug">Slug</label>
        <input type="text" class="form-control mt-2" id="slug" name="slug" value="<?php if(!empty($post->getSlug())) { echo($post->getSlug()); } ?>">
        <?php if (!empty($errorFlash = $session->flash('slug'))):?>
            <small class="text-danger"><?= $errorFlash ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group pb-2">
        <label for="content">Contenu</label>
        <textarea class="form-control" id="content" name="content" rows="20"><?php if(!empty($post->getContent())) { echo($post->getContent()); } ?></textarea>
        <?php if (!empty($errorFlash = $session->flash('content'))):?>
            <small class="text-danger"><?= $errorFlash ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group pb-2">
        <label for="imageInput" class="d-flex">Image de présentation</label>
        <input type="file" class="form-control-file" id="imageInput" name="image" accept="image/png, image/jpeg">
        <?php if (!empty($errorFlash = $session->flash('image'))):?>
            <small class="text-danger"><?= $errorFlash ?></small>
        <?php endif; ?>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn-custom">Envoyer</button>
    </div>
</form>

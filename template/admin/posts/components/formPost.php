<form action="" method="post" class="pb-4" enctype="multipart/form-data">
    <div class="form-group pb-2">
        <label for="title">Titre de l'article</label>
        <input type="text" class="form-control mt-2" id="title" name="title" value="<?php if(!empty($post['title'])) { echo($post['title']); } ?>" required>
        <?php if (!empty($errorFlash = $session->flash('title'))):?>
            <small class="text-danger"><?= $errorFlash ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group pb-2">
        <label for="header">Texte d'accroche</label>
        <input type="text" class="form-control mt-2" id="header" name="header" value="<?php if(!empty($post['header'])) { echo($post['header']); } ?>" required>
        <?php if (!empty($errorFlash = $session->flash('header'))):?>
            <small class="text-danger"><?= $errorFlash ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group pb-2">
        <label for="slug">Slug</label>
        <input type="text" class="form-control mt-2" id="slug" name="slug" value="<?php if(!empty($post['slug'])) { echo($post['slug']); } ?>" required>
        <?php if (!empty($errorFlash = $session->flash('slug'))):?>
            <small class="text-danger"><?= $errorFlash ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group pb-2">
        <label for="content">Contenu</label>
        <textarea class="form-control" id="content" name="content" rows="20"><?php if(!empty($post['content'])) { echo($post['content']); } ?></textarea>
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

    <div class="form-check pb-2">
        <input type="checkbox" class="form-check-input" id="activeInput" name="active" value="1" <?php if(!empty($post['active']) && 1 === $post['active']) { echo('checked'); }?>>
        <label class="form-check-label" for="activeInput">Visible</label>
    </div>

    <div class="form-check pb-2">
        <input type="checkbox" class="form-check-input" id="promoteInput" name="promote" value="1" <?php if(!empty($post['promote']) && 1 === $post['promote']) { echo('checked'); }?>>
        <label class="form-check-label" for="promoteInput">Mise en avant</label>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn-custom">Envoyer</button>
    </div>
</form>

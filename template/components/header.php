<!Doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.87.0">
    <title>Blog Template · Bootstrap v5.1</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <meta name="theme-color" content="#7952b3">

    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/assets/css/blog.css" rel="stylesheet">
    </head>
    <body>

        <div class="container">
            <header class="blog-header py-3">
                <div class="row flex-nowrap justify-content-between align-items-center">
                    <div class="col-4">
                        <a class="blog-header-logo" href="/">DevCoding</a>
                    </div>
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <?php if (!empty($user = $session->get('__user')) AND $user['role'] === "ROLE_ADMIN"): ?>
                            <a class="btn btn-sm btn-outline-secondary mx-2" href="/admin/posts">Dashboard</a>
                        <?php endif; ?>
                        <?php if (!empty($session->get('__user'))): ?>
                            <a class="btn btn-sm btn-outline-secondary mx-2" href="/logout">Déconnexion</a>
                        <?php else: ?>
                            <a class="btn btn-sm btn-outline-secondary mx-2" href="/signup">Inscrivez-vous</a>
                            <a class="btn btn-sm btn-outline-secondary" href="/signin">Connexion</a>
                        <?php endif; ?>
                    </div>
                </div>
            </header>

            <div class="nav-scroller py-1 mb-2 border-bottom-custom">
                <nav class="nav d-flex justify-content-center">
                    <a class="p-2 link-secondary" href="#">PHP</a>
                    <a class="p-2 link-secondary" href="#">Symfony</a>
                    <a class="p-2 link-secondary" href="#">GIT</a>
                    <a class="p-2 link-secondary" href="#">HTML/CSS</a>
                </nav>
            </div>

            <?php if (!empty($errorFlash = $session->flash('accessDenied'))):?>
                <div class="alert alert-warning" role="alert">
                    <?= $errorFlash ?>
                </div>
            <?php endif; ?>
        </div>

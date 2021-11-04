<!-- Header -->
<?php include "../template/components/header.php"; ?>

<main class="container">

    <div class="p-4 p-md-5 mb-4 text-white bg-dark bg-custom">
        <div class="col-md-6 px-0">
            <h1 class="display-4 fst-italic">Le blog d'un développeur junior !</h1>
            <p class="lead my-3">La vie de développeur junior n'est pas toujours facile mais quand ça deviens trop
                compliquer il reste StackOverflow.</p>
        </div>
    </div>
    
    <div class="row mb-2">
        <div class="col-md-6">
            <div class="row g-0 border-rounded flex-md-row mb-4 shadow-custom h-md-250">
                <div class="col p-4 d-flex flex-column position-static">
                    <article>
                        <strong class="d-inline-block mb-2 text-primary">PHP</strong>
                        <a href="#" class="a-custom">
                            <h2 class="mb-0 blog-post-title">Comprendre la ReflectionClass</h2>
                            <div class="mb-1 blog-post-meta">Nov 12</div>
                            <p class="card-text mb-auto">This is a wider card with supporting text below as a natural lead-in to
                                additional content.</p>
                        </a>
                    </article>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row g-0 border-rounded flex-md-row mb-4 shadow-custom h-md-250">
                <div class="col p-4 d-flex flex-column position-static">
                    <article>
                        <strong class="d-inline-block mb-2 text-primary">PHP</strong>
                        <a href="#" class="a-custom">
                            <h2 class="mb-0 blog-post-title">Est-ce-que GIT est un outil essentiel au développeur ?</h2>
                            <div class="mb-1 blog-post-meta">Nov 12</div>
                            <p class="card-text mb-auto">This is a wider card with supporting text below as a natural lead-in to
                                additional content.</p>
                        </a>
                    </article>
                </div>
            </div>
        </div>
    </div>

    <?php include "../template/components/allPosts.php" ?>
    
    <?php include "../template/components/contactForm.php" ?>
    
</main>

<!-- Footer -->
<?php include "../template/components/footer.php" ?>
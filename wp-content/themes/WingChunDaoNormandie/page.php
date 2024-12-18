<?php get_header(); ?>
<main class="page-content">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1 class="page-title"><?php the_title(); ?></h1> <!-- Affiche le titre de la page -->
                <div class="page-body">
                    <?php the_content(); ?> <!-- Affiche le contenu de la page -->
                </div>
            </article>
        <?php
        endwhile;
    else :
        ?>
        <p>Aucun contenu trouvé.</p>
    <?php endif; ?>
</main>
<?php get_footer(); ?>

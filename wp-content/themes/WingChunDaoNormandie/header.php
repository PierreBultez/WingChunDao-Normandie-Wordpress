<!DOCTYPE html>
<html lang=fr>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="<?php echo get_dynamic_meta_description(); ?>">
    <link rel="stylesheet" href="https://use.typekit.net/mhk5rzh.css">
    <?php wp_head(); ?>
</head>
<body>
<div class="hero">
    <header>
        <?php if (has_custom_logo()) : ?>
            <div class="logo">
                <?php the_custom_logo(); ?>
            </div>
        <?php endif; ?>

        <?php wp_nav_menu( array(
            'theme_location' => 'main_menu',
            'menu_class' => 'main-menu',
            'container_class' => 'menu',
        ) );
        ?>
    </header>
    <div class="hero-content">
        <h1 class="hero-title">Wing Chun Dao Normandie</h1>
        <h2 class="hero-subtitle">École d'art martiaux et de défense personnelle</h2>
    </div>
</div>


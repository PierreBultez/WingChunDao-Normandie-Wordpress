<?php

function wingchundao_setup () {
    // Ajoute la prise en charge du titre de la page
    add_theme_support('title-tag');

    // Ajoute la prise en charge des images à la une dans les posts
    add_theme_support('post-thumbnails');

    // Enregistre les menus de navigation
    register_nav_menus(array(
        'main_menu' => __('Menu principal', ''),
        'footer_menu' => __('Menu de footer', ''),
    ));

    // Activer le support du logo personnalisé
    add_theme_support('custom-logo', array(
        'height'      => 50,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Ajoute des tailles d'image personnalisées
    add_image_size('logo', 200, 50);
//    add_image_size('photo-detail-thumb', 80, 80, true);
//    add_image_size('photo-lightbox-landscape', 844, 563, true);
//    add_image_size('photo-lightbox-portrait', 376, 563, true);
//    add_image_size('hero', 1440, 960, true);
}

// Action pour configurer le thème après son activation
add_action('after_setup_theme', 'wingchundao_setup');

function wingchundao_register_assets() {
    // Définir les styles à enregistrer et à inclure
    $styles = [
        'wingchundao' => get_stylesheet_directory_uri() . '/style.css',
        'fontawesome' => get_stylesheet_directory_uri() . '/assets/fontawesome/css/fontawesome.css',
        'fontawesome-all' => get_stylesheet_directory_uri() . '/assets/fontawesome/css/all.css',
    ];

    // Enregistrer et inclure chaque style
    foreach ($styles as $handle => $src) {
        wp_register_style($handle, $src);
        wp_enqueue_style($handle);
    }

    // Définir les scripts à enregistrer et à inclure
    $scripts = [
        'wingchundao-scripts' => get_stylesheet_directory_uri() . '/scripts.js',
    ];

    // Enregistrer et inclure chaque script
    foreach ($scripts as $handle => $src) {
        wp_register_script($handle, $src, ['jquery'], false, true);
        wp_enqueue_script($handle);
    }
}

// Action pour enregistrer et inclure les styles et scripts
add_action('wp_enqueue_scripts', 'wingchundao_register_assets');

function custom_meta_description_box()
{
    add_meta_box(
        'meta_description_id',
        'Meta Description',
        'custom_meta_description_callback',
        'post',
        'side'
    );
    add_meta_box(
        'meta_description_id',
        'Meta Description',
        'custom_meta_description_callback',
        'page',
        'side'
    );
}

add_action('add_meta_boxes', 'custom_meta_description_box');

function custom_meta_description_callback($post)
{
    $value = get_post_meta($post->ID, '_custom_meta_description', true);
    echo '<textarea style="width:100%;" rows="4" name="custom_meta_description">' . esc_attr($value) . '</textarea>';
}

function save_custom_meta_description($post_id)
{
    if (array_key_exists('custom_meta_description', $_POST)) {
        update_post_meta(
            $post_id,
            '_custom_meta_description',
            sanitize_textarea_field($_POST['custom_meta_description'])
        );
    }
}

add_action('save_post', 'save_custom_meta_description');

function get_dynamic_meta_description()
{
    if (is_single() || is_page()) {
        global $post;
        $custom_meta_description = get_post_meta($post->ID, '_custom_meta_description', true);
        if ($custom_meta_description) {
            return esc_attr($custom_meta_description);
        } else {
            // Fallback to excerpt if no custom meta description is set
            return esc_attr(wp_trim_words($post->post_content, 30, '...'));
        }
    } elseif (is_category()) {
        $category_description = category_description();
        return esc_attr($category_description);
    } else {
        return "Découvrez l'école de Wing Chun Dao en Normandie, située à Blainville-Crevon près de Rouen. Cours collectifs, particuliers, stages intensifs et self-défense pour tous niveaux. Rejoignez-nous pour maîtriser cet art martial traditionnel chinois.";
    }
}
// === CPT: Galerías ===
function crear_post_type_galerias() {
    $labels = array(
        'name'               => 'Galerías',
        'singular_name'      => 'Galería',
        'menu_name'          => 'Galerías',
        'name_admin_bar'     => 'Galería',
        'add_new'            => 'Añadir Nueva',
        'add_new_item'       => 'Añadir Nueva Galería',
        'new_item'           => 'Nueva Galería',
        'edit_item'          => 'Editar Galería',
        'view_item'          => 'Ver Galería',
        'all_items'          => 'Todas las Galerías',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'supports'           => array('title', 'editor', 'thumbnail'),
        'menu_icon'          => 'dashicons-format-gallery',
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'galerias'),
        'show_in_rest'       => true, // Compatible con Gutenberg
    );

    register_post_type('galerias', $args);
}
add_action('init', 'crear_post_type_galerias');
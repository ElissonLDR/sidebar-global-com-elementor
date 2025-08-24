<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Layout em posts
function sge_sidebar_layout_posts( $content ) {
    $template_id  = get_option( 'sge_sidebar_template' );
    $show_image   = get_option( 'sge_sidebar_show_image', '1' );
    $enable_posts = get_option( 'sge_sidebar_enable_posts', '1' );

    if ( ! $template_id || ! $enable_posts ) return $content;

    if ( is_singular('post') && in_the_loop() && is_main_query() ) {
        global $post;

        // Aplica border-radius da config
        $style_radius = sge_get_featured_image_style();

        // Imagem destacada (se ativada)
        $featured_img = ( $show_image === '1' && has_post_thumbnail( $post->ID ) )
            ? '<div class="sge-featured-img" style="'.esc_attr($style_radius).' overflow:hidden;">' 
                . get_the_post_thumbnail( $post->ID, 'large', ['class'=>'sge-featured-image'] ) 
              . '</div>'
            : '';

        $sidebar = sge_render_sidebar_template( $template_id );

        return '<div class="sge-post-with-sidebar">
                    <div class="sge-content">'.$featured_img.'<div class="sge-text">'.$content.'</div></div>
                    <div class="sge-sidebar">'.$sidebar.'</div>
                </div>';
    }
    return $content;
}
add_filter( 'the_content', 'sge_sidebar_layout_posts' );

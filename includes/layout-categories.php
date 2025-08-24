<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function sge_sidebar_category_start( $query ) {
    $template_id = get_option( 'sge_sidebar_template' );
    $enable_cat  = get_option( 'sge_sidebar_enable_categories', '0' );

    if ( ! $query->is_main_query() || ! is_category() || ! $enable_cat || ! $template_id ) return;

    echo '<div class="sge-post-with-sidebar"><div class="sge-content">';
}
add_action( 'loop_start', 'sge_sidebar_category_start' );

function sge_sidebar_category_end( $query ) {
    $template_id = get_option( 'sge_sidebar_template' );
    $enable_cat  = get_option( 'sge_sidebar_enable_categories', '0' );

    if ( ! $query->is_main_query() || ! is_category() || ! $enable_cat || ! $template_id ) return;

    $sidebar = sge_render_sidebar_template( $template_id );
    echo '</div><div class="sge-sidebar">'.$sidebar.'</div></div>';
}
add_action( 'loop_end', 'sge_sidebar_category_end' );

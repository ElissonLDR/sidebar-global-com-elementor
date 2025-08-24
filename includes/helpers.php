<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Renderiza o template do Elementor
 */
function sge_render_sidebar_template( $template_id ) {
    if ( class_exists( '\Elementor\Plugin' ) ) {
        return \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id );
    }
    return '<p><em>Elementor não ativo.</em></p>';
}

/**
 * Retorna estilo inline para a imagem destacada
 */
function sge_get_featured_image_style() {
    $radius = get_option('sge_sidebar_img_radius', [
        'top' => 0,
        'right' => 0,
        'bottom' => 0,
        'left' => 0,
    ]);

    // Garantir que é array (retrocompatibilidade com versão antiga que salvava string)
    if ( !is_array($radius) ) {
        $radius = [
            'top'    => intval($radius),
            'right'  => intval($radius),
            'bottom' => intval($radius),
            'left'   => intval($radius),
        ];
    }

    return sprintf(
        'border-radius:%dpx %dpx %dpx %dpx;',
        intval($radius['top']),
        intval($radius['right']),
        intval($radius['bottom']),
        intval($radius['left'])
    );
}

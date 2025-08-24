<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function sge_add_settings_page() {
    add_options_page(
        'Sidebar Elementor',
        'Sidebar Elementor',
        'manage_options',
        'sge-sidebar-elementor',
        'sge_render_settings_page'
    );
}
add_action( 'admin_menu', 'sge_add_settings_page' );

function sge_render_settings_page() {
    if ( isset($_POST['sge_sidebar_template']) && check_admin_referer('sge_sidebar_save', 'sge_sidebar_nonce') ) {
        update_option( 'sge_sidebar_template', intval($_POST['sge_sidebar_template']) );
        update_option( 'sge_sidebar_show_image', isset($_POST['sge_sidebar_show_image']) ? '1' : '0' );
        update_option( 'sge_sidebar_enable_posts', isset($_POST['sge_sidebar_enable_posts']) ? '1' : '0' );
        update_option( 'sge_sidebar_enable_categories', isset($_POST['sge_sidebar_enable_categories']) ? '1' : '0' );

        // Raio da borda individual (em px)
        $radius = [
            'top'    => intval($_POST['sge_sidebar_img_radius']['top'] ?? 0),
            'right'  => intval($_POST['sge_sidebar_img_radius']['right'] ?? 0),
            'bottom' => intval($_POST['sge_sidebar_img_radius']['bottom'] ?? 0),
            'left'   => intval($_POST['sge_sidebar_img_radius']['left'] ?? 0),
        ];
        update_option( 'sge_sidebar_img_radius', $radius );

        echo '<div class="updated"><p>Configurações salvas!</p></div>';
    }

    $template_id  = get_option( 'sge_sidebar_template' );
    $show_image   = get_option( 'sge_sidebar_show_image', '1' );
    $enable_posts = get_option( 'sge_sidebar_enable_posts', '1' );
    $enable_cat   = get_option( 'sge_sidebar_enable_categories', '0' );
    $img_radius   = get_option( 'sge_sidebar_img_radius', [
        'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0
    ]);

    // Garantir que $img_radius é sempre array
    if ( !is_array($img_radius) ) {
        $img_radius = [
            'top' => intval($img_radius),
            'right' => intval($img_radius),
            'bottom' => intval($img_radius),
            'left' => intval($img_radius),
        ];
    }

    $templates = get_posts([
        'post_type' => 'elementor_library',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    ]);
    ?>
    <div class="wrap">
        <h1>Configurações da Sidebar Elementor</h1>
        <form method="post">
            <?php wp_nonce_field( 'sge_sidebar_save', 'sge_sidebar_nonce' ); ?>
            
            <p>
                <label><strong>Template Elementor:</strong></label><br>
                <select name="sge_sidebar_template" style="width:300px;">
                    <option value="">-- Nenhum --</option>
                    <?php foreach ( $templates as $tpl ) : ?>
                        <option value="<?php echo $tpl->ID; ?>" <?php selected( $template_id, $tpl->ID ); ?>>
                            <?php echo esc_html( $tpl->post_title ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if ( $template_id ) : ?>
                    <?php $edit_url = admin_url("post.php?post=$template_id&action=elementor"); ?>
                    <a href="<?php echo esc_url($edit_url); ?>" target="_blank" class="button">Editar no Elementor</a>
                <?php endif; ?>
            </p>

            <h2>Onde exibir</h2>
            <p>
                <label><input type="checkbox" name="sge_sidebar_enable_posts" value="1" <?php checked( $enable_posts, '1' ); ?>> Posts</label><br>
                <label><input type="checkbox" name="sge_sidebar_enable_categories" value="1" <?php checked( $enable_cat, '1' ); ?>> Categorias</label>
            </p>

            <h2>Imagem destacada</h2>
            <p>
                <label><input type="checkbox" name="sge_sidebar_show_image" value="1" <?php checked( $show_image, '1' ); ?>> Exibir imagem destacada</label>
            </p>

            <h3>Raio da borda (px)</h3>
            <p>
                <input type="number" name="sge_sidebar_img_radius[top]" value="<?php echo esc_attr($img_radius['top']); ?>" style="width:70px;"> Superior
                <input type="number" name="sge_sidebar_img_radius[right]" value="<?php echo esc_attr($img_radius['right']); ?>" style="width:70px;"> Direita
                <input type="number" name="sge_sidebar_img_radius[bottom]" value="<?php echo esc_attr($img_radius['bottom']); ?>" style="width:70px;"> Inferior
                <input type="number" name="sge_sidebar_img_radius[left]" value="<?php echo esc_attr($img_radius['left']); ?>" style="width:70px;"> Esquerda
            </p>

            <p><button type="submit" class="button button-primary">Salvar</button></p>
        </form>
    </div>
    <?php
}

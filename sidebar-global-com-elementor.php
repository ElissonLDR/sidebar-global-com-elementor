<?php
/**
 * Plugin Name: Sidebar Global com Elementor
 * Description: Exibe um template do Elementor como sidebar em posts e categorias, com título dentro do conteúdo, imagem destacada e opções personalizadas.
 * Version: 3.4
 * Author: JBTEC
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// === Definir caminhos ===
define( 'SGE_PATH', plugin_dir_path( __FILE__ ) );
define( 'SGE_URL', plugin_dir_url( __FILE__ ) );

// === Incluir arquivos ===
require_once SGE_PATH . 'includes/admin-page.php';
require_once SGE_PATH . 'includes/helpers.php';
require_once SGE_PATH . 'includes/layout-posts.php';
require_once SGE_PATH . 'includes/layout-categories.php';

// === Carregar CSS ===
function sge_enqueue_assets() {
    if ( is_singular('post') || is_category() ) {
        wp_enqueue_style( 'sge-styles', SGE_URL . 'assets/css/style.css', [], '3.4' );
    }
}
add_action( 'wp_enqueue_scripts', 'sge_enqueue_assets' );

// === Adicionar link de Configurações na lista de plugins ===
function sge_plugin_action_links( $links ) {
    $settings_link = '<a href="' . admin_url( 'options-general.php?page=sge-sidebar-elementor' ) . '">Configurações</a>';
    array_unshift( $links, $settings_link );
    return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'sge_plugin_action_links' );


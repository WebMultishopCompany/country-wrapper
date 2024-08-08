<?php
/**
 * Plugin Name: Country Wrapper Block
 * Description: A Gutenberg wrapper block that displays content based on the user's country.
 * Version: 1.0.0
 * Author: WMC Kārlis
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

function cw_register_block() {
    // Register the block editor script.
    wp_register_script(
        'cw-block-editor',
        plugins_url( 'build/index.js', __FILE__ ),
                       array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n' ),
                       filemtime( plugin_dir_path( __FILE__ ) . 'build/index.js' )
    );

    // Register the block editor styles.
    wp_register_style(
        'cw-block-editor',
        plugins_url( 'editor.css', __FILE__ ),
                      array( 'wp-edit-blocks' ),
                      filemtime( plugin_dir_path( __FILE__ ) . 'editor.css' )
    );

    // Register the block.
    register_block_type( 'cw/country-wrapper', array(
        'editor_script' => 'cw-block-editor',
        'editor_style'  => 'cw-block-editor',
        'render_callback' => 'cw_render_callback',
        'attributes' => array(
            'region' => array(
                'type' => 'string',
                'default' => 'global',
            ),
        ),
    ) );
}
add_action( 'init', 'cw_register_block' );

function cw_render_callback( $attributes, $content ) {
    $region = isset($attributes['region']) ? $attributes['region'] : 'global';
    $user_country = isset($_COOKIE['user_country']) ? strtolower(sanitize_text_field($_COOKIE['user_country'])) : '';

    $is_visible = false;

    if ($region === 'lv' && $user_country === 'lv') {
        $is_visible = true;
    } elseif ($region === 'cis' && in_array($user_country, array('am', 'az', 'by', 'ge', 'kz', 'kg', 'md', 'ru', 'tj', 'tm', 'uz'))) {
        $is_visible = true;
    } elseif ($region === 'global' && !in_array($user_country, array('lv', 'am', 'az', 'by', 'ge', 'kz', 'kg', 'md', 'ru', 'tj', 'tm', 'uz'))) {
        $is_visible = true;
    }

    return $is_visible ? $content : '';
}
?>

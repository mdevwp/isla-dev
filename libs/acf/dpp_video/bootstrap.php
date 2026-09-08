<?php
/**
 * DPP Video Section — self-contained bootstrap.
 *
 * Registers the acf/dpp-video block and its field group. Everything the
 * feature needs lives in this folder; the only change required to the rest
 * of the theme is a single require_once in functions.php.
 *
 * Every step is guarded, so a missing/disabled ACF, a partial upload or an
 * older ACF build degrades to "block simply not available" rather than a
 * fatal error on the front end.
 *
 * @package kmnd-child
 * @version 1.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( defined( 'KMND_DPP_VIDEO_VERSION' ) ) {
	return; // Already loaded.
}

define( 'KMND_DPP_VIDEO_VERSION', '1.1.4' );
define( 'KMND_DPP_VIDEO_DIR', __DIR__ );

/**
 * Register the block.
 */
add_action( 'acf/init', function () {

	if ( ! function_exists( 'acf_register_block_type' ) && ! function_exists( 'acf_register_block' ) ) {
		return;
	}

	$render = KMND_DPP_VIDEO_DIR . '/dpp_video.php';
	if ( ! file_exists( $render ) ) {
		return;
	}

	$uri = get_stylesheet_directory_uri() . '/libs/acf/dpp_video';
	$ver = KMND_DPP_VIDEO_VERSION;

	$args = array(
		'name'            => 'dpp_video',
		'title'           => __( 'DPP Video Section', 'kmnd' ),
		'description'     => __( 'Accessible click-to-play video with H2, captions and transcript.', 'kmnd' ),
		'icon'            => 'video-alt3',
		'keywords'        => array( 'video', 'dpp', 'player', 'captions' ),
		'render_template' => '/libs/acf/dpp_video/dpp_video.php',
		'enqueue_style'   => $uri . '/style.css?v=' . $ver,
		'enqueue_script'  => $uri . '/script.js?v=' . $ver,
		'category'        => 'tamplate_kmnd',
		'mode'            => 'edit',
		'align'           => 'full',
		'supports'        => array(
			'align'           => false,
			'anchor'          => true,
			'customClassName' => true,
			'jsx'             => true,
			// Locks the block to the mode above and removes the edit/preview
			// toggle, matching how the other 30 theme blocks are registered.
			// Without this a `mode` saved in the page content would win.
			'mode'            => false,
		),
	);

	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( $args );
	} else {
		acf_register_block( $args );
	}
} );

/**
 * Put this block's stylesheet into the block editor canvas.
 *
 * ACF's own `enqueue_style` covers the front end and the outer admin document,
 * but not the iframed editor canvas. Without it the preview loses
 * `position: absolute` on the video and poster, so they stack vertically and
 * the play button drops below the frame.
 *
 * Safe to load here because every rule in style.css is namespaced under
 * `.dpp-video-section` — unlike the theme's global CSS, which styles the
 * generic `.button` class and would repaint the editor's own controls.
 */
add_action( 'enqueue_block_assets', function () {
	if ( ! is_admin() ) {
		return; // The front end already gets this via the block registration.
	}

	$path = KMND_DPP_VIDEO_DIR . '/style.css';
	if ( ! is_readable( $path ) ) {
		return;
	}

	wp_enqueue_style(
		'dpp-video-editor-canvas',
		get_stylesheet_directory_uri() . '/libs/acf/dpp_video/style.css',
		array(),
		(string) filemtime( $path )
	);
}, 20 );

/**
 * Register the field group (in code — the site has no acf-json sync).
 */
add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$fields = KMND_DPP_VIDEO_DIR . '/fields.php';
	if ( file_exists( $fields ) ) {
		require_once $fields;
	}
} );

/**
 * The block category the theme uses ("tamplate_kmnd") is registered by the
 * parent theme. If it is ever missing, fall back to a core category so the
 * block never disappears from the inserter.
 */
add_filter( 'block_categories_all', function ( $categories ) {
	foreach ( $categories as $category ) {
		if ( isset( $category['slug'] ) && 'tamplate_kmnd' === $category['slug'] ) {
			return $categories;
		}
	}

	$categories[] = array(
		'slug'  => 'tamplate_kmnd',
		'title' => __( 'Komanda blocks', 'kmnd' ),
	);

	return $categories;
}, 20 );

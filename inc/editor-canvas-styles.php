<?php
/**
 * Put ACF's own field styles into the block editor canvas.
 *
 * Since WordPress 6.3 the editor renders blocks inside its own canvas
 * (`.editor-styles-wrapper`). Styles reach it only via `enqueue_block_assets`.
 * ACF enqueues acf-input on `admin_enqueue_scripts`, which covers the outer
 * admin document but not the canvas — so ACF blocks registered in "edit" mode
 * render their field forms as unstyled HTML.
 *
 * Only ACF's stylesheet is added. The theme's front-end CSS is deliberately
 * NOT loaded here: it styles the generic `.button` class, which is also
 * WordPress's own admin button class, and would repaint every control in the
 * editor.
 *
 * @package kmnd-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'enqueue_block_assets', function () {
	if ( ! is_admin() ) {
		return;
	}

	// acf-input styles the basic fields. acf-pro-input carries everything for
	// the Pro field types — Repeater, Flexible Content, Gallery — including the
	// collapsed-row rules, which are absent from acf-input entirely. Without it
	// a repeater's collapse toggle changes the class but nothing moves.
	$loaded = '';

	// wp-color-picker carries the Iris styles. Without it the colour fields
	// render as a bare gradient strip that stretches down the whole page.
	foreach ( array( 'wp-color-picker', 'acf-input', 'acf-pro-input' ) as $handle ) {
		if ( wp_style_is( $handle, 'registered' ) ) {
			wp_enqueue_style( $handle );
			$loaded = $handle;
		}
	}

	if ( ! $loaded ) {
		return;
	}

	/*
	 * Every collapse rule ACF ships is written as
	 *   .acf-repeater .acf-row.-collapsed > …
	 * but inside a block the repeater renders as a bare
	 *   table.acf-table > tbody > tr.acf-row > td.acf-fields
	 * with no `.acf-repeater` wrapper, so not one of those rules can match.
	 * The class gets toggled and nothing moves.
	 *
	 * These are the same declarations with that ancestor requirement dropped.
	 * `.acf-row.-collapsed` only ever exists inside a repeater, so nothing else
	 * on the page can be affected.
	 */
	wp_add_inline_style(
		$loaded,
		'.acf-row.-collapsed > .acf-fields > *,' .
		'.acf-row.-collapsed > .acf-field{display:none!important}' .
		'.acf-row.-collapsed > .acf-fields > .acf-field.-collapsed-target{display:block!important}' .
		'.acf-row.-collapsed > td.acf-field.-collapsed-target{display:table-cell!important}' .
		'.acf-row.-collapsed > .acf-fields > .acf-field.-collapsed-target[data-width]{float:none!important;width:auto!important}'
	);
}, 20 );

/**
 * Restore repeater row collapse inside the iframed canvas.
 *
 * The stylesheets above make the collapsed state visible, but the control that
 * sets it may not be reachable in every editor context. This is a small
 * belt-and-braces listener; if ACF's own handler already runs, it simply never
 * gets the chance to fire, so a row can never be toggled twice.
 *
 * Optional — the CSS above is what actually fixes the visible behaviour. Delete
 * this block and the JS file if collapse already works without them.
 */
add_action( 'enqueue_block_editor_assets', function () {
	$path = get_stylesheet_directory() . '/assets/js/acf-collapse-fallback.js';

	if ( ! is_readable( $path ) ) {
		return;
	}

	wp_enqueue_script(
		'kmnd-acf-collapse-fallback',
		get_stylesheet_directory_uri() . '/assets/js/acf-collapse-fallback.js',
		array(),
		(string) filemtime( $path ),
		true
	);
} );

/**
 * Make the classic editor settings available in the block editor.
 *
 * ACF initialises a WYSIWYG field by calling its own buildQuicktags(), which
 * reads the settings WordPress normally prints for dynamically created editors.
 * On this site those settings are absent from the block editor screen, so the
 * call throws
 *
 *   Uncaught TypeError: Cannot read properties of undefined (reading 'buttons')
 *
 * the moment a block containing a WYSIWYG field is inserted. React catches the
 * throw and replaces the block with "This block has encountered an error".
 * Blocks already on the page are unaffected, which is why only newly inserted
 * ones broke.
 *
 * wp_enqueue_editor() prints exactly those settings. It is the documented way
 * to support editors created after page load, and it fixes every block with a
 * WYSIWYG field, not just ours.
 */
add_action( 'enqueue_block_editor_assets', function () {
	if ( function_exists( 'wp_enqueue_editor' ) ) {
		wp_enqueue_editor();
	}
}, 5 );

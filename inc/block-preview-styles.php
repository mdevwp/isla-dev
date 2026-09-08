<?php
/**
 * Adequate previews for ACF blocks inside the block editor canvas.
 *
 * THE PROBLEM
 * Block previews render the theme's real front-end markup, but the editor
 * canvas never receives the theme's CSS, so every preview looks like unstyled
 * HTML. Loading the theme CSS into the canvas as-is is not an option: it styles
 * the generic `.button` class, which is also WordPress's own admin button
 * class, so every control in the editor turns orange.
 *
 * THE APPROACH
 * Take the theme's stylesheets and rewrite every selector so it only applies
 * inside `.acf-block-preview` — the wrapper ACF puts around a block preview.
 * The result is cached to a single generated file and loaded into the canvas.
 * Nothing outside that wrapper can be affected, so the editor's own chrome,
 * ACF's field forms and the front end are all untouched.
 *
 * The generated file is rebuilt automatically whenever a source file changes.
 *
 * @package kmnd-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'KMND_PREVIEW_SCOPE' ) ) {
	define( 'KMND_PREVIEW_SCOPE', '.acf-block-preview' );
}

/**
 * Source stylesheets, in the same order the front end loads them.
 *
 * @return string[] Absolute paths that exist.
 */
function kmnd_preview_css_sources() {
	$dir = get_stylesheet_directory();

	$files = array(
		$dir . '/assets/css/swiper.css',
		$dir . '/assets/css/style.css',
		$dir . '/assets/css/about-us.css',
		$dir . '/assets/css/solution.css',
		$dir . '/style.css',
	);

	return array_values( array_filter( $files, 'is_readable' ) );
}

/**
 * Rewrite one comma-separated selector list so it only matches inside the scope.
 *
 * @param string $selectors Raw selector text.
 * @return string
 */
function kmnd_preview_scope_selectors( $selectors ) {
	$scope = KMND_PREVIEW_SCOPE;
	$out   = array();

	foreach ( explode( ',', $selectors ) as $sel ) {
		$sel = trim( $sel );

		if ( '' === $sel ) {
			continue;
		}

		// Already scoped, or targets the wrapper itself — leave alone.
		if ( false !== strpos( $sel, $scope ) ) {
			$out[] = $sel;
			continue;
		}

		// Page-level selectors have no meaning inside a div: collapse them onto
		// the wrapper so their declarations (and any custom properties) survive.
		if ( preg_match( '/^(html|body|:root)$/i', $sel ) ) {
			$out[] = $scope;
			continue;
		}

		// Leading html/body qualifier, e.g. "body .btn" → ".acf-block-preview .btn".
		$sel = preg_replace( '/^(?:html|body)\s+/i', '', $sel );

		$out[] = $scope . ' ' . $sel;
	}

	return implode( ', ', array_unique( $out ) );
}

/**
 * Scope a whole stylesheet.
 *
 * A small hand-rolled walker rather than a regex: at-rules nest, and
 * @keyframes / @font-face bodies must never be touched.
 *
 * @param string $css Stylesheet source.
 * @return string
 */
function kmnd_preview_scope_css( $css ) {
	// Strip comments (non-greedy, and tolerant of unterminated ones).
	$css = preg_replace( '#/\*.*?\*/#s', '', $css );

	$len    = strlen( $css );
	$out    = '';
	$buffer = '';
	$i      = 0;

	/** Copy a brace-balanced body verbatim, starting at the opening brace. */
	$copy_block = function ( $start ) use ( $css, $len ) {
		$depth = 0;
		for ( $j = $start; $j < $len; $j++ ) {
			if ( '{' === $css[ $j ] ) {
				$depth++;
			} elseif ( '}' === $css[ $j ] ) {
				$depth--;
				if ( 0 === $depth ) {
					return $j;
				}
			}
		}
		return $len - 1;
	};

	while ( $i < $len ) {
		$ch = $css[ $i ];

		if ( ';' === $ch && '' !== trim( $buffer ) && '@' === trim( $buffer )[0] ) {
			// Statement at-rule: @import, @charset.
			$out   .= trim( $buffer ) . ";\n";
			$buffer = '';
			$i++;
			continue;
		}

		if ( '}' === $ch && '' === trim( $buffer ) ) {
			// Stray closing brace at top level. The theme's own stylesheets
			// contain three of these; browsers skip them, and so do we rather
			// than letting one bleed into the next selector.
			$buffer = '';
			$i++;
			continue;
		}

		if ( '{' !== $ch ) {
			$buffer .= $ch;
			$i++;
			continue;
		}

		$prelude = trim( $buffer );
		$buffer  = '';
		$end     = $copy_block( $i );
		$body    = substr( $css, $i + 1, $end - $i - 1 );

		if ( '' !== $prelude && '@' === $prelude[0] ) {
			$at = strtolower( strtok( substr( $prelude, 1 ), " \t\n({" ) );

			if ( in_array( $at, array( 'media', 'supports', 'container', 'layer' ), true ) ) {
				// Conditional group: recurse so inner selectors get scoped.
				$out .= $prelude . "{\n" . kmnd_preview_scope_css( $body ) . "}\n";
			} else {
				// @keyframes, @font-face, @page, @property … copy verbatim.
				$out .= $prelude . "{" . $body . "}\n";
			}
		} else {
			$out .= kmnd_preview_scope_selectors( $prelude ) . "{" . $body . "}\n";
		}

		$i = $end + 1;
	}

	return $out;
}

/**
 * Build the generated file when missing or stale.
 *
 * @return array|false [ 'path' => string, 'url' => string, 'ver' => string ] or false.
 */
function kmnd_preview_css_file() {
	$sources = kmnd_preview_css_sources();

	if ( ! $sources ) {
		return false;
	}

	$stamp = 0;
	foreach ( $sources as $file ) {
		$stamp = max( $stamp, (int) filemtime( $file ) );
	}

	$uploads = wp_upload_dir();
	if ( ! empty( $uploads['error'] ) ) {
		return false;
	}

	$path = $uploads['basedir'] . '/kmnd-block-preview.css';
	$url  = $uploads['baseurl'] . '/kmnd-block-preview.css';

	if ( ! is_readable( $path ) || filemtime( $path ) < $stamp ) {
		$css = "/* Generated from the theme stylesheets — do not edit. */\n";

		foreach ( $sources as $file ) {
			$css .= kmnd_preview_scope_css( (string) file_get_contents( $file ) );
		}

		/*
		 * Fit the preview to the canvas.
		 *
		 * The front end is built for a full desktop window, so at 1:1 a section
		 * overflows the editor and the headings are enormous. `zoom` shrinks the
		 * rendered result while keeping the layout intact — unlike
		 * `transform: scale()`, which would leave the original footprint behind.
		 *
		 * Tune with: add_filter( 'kmnd_block_preview_zoom', fn() => 0.4 );
		 */
		$zoom = (float) apply_filters( 'kmnd_block_preview_zoom', 0.5 );
		$zoom = max( 0.2, min( 1, $zoom ) );

		$css .= KMND_PREVIEW_SCOPE . '{'
			. 'zoom:' . $zoom . ';'
			// Contain the oversized hero art instead of scrolling the canvas.
			. 'overflow:hidden!important;'
			. 'max-width:none!important;'
			. 'margin:0!important'
			. "}\n";

		$css .= KMND_PREVIEW_SCOPE . " main{overflow:visible!important}\n";

		/*
		 * Only fixed/sticky positioning is a problem here — it would escape the
		 * little preview box. Absolute positioning must be left alone: several
		 * blocks (the DPP video among them) stack their poster, video and
		 * controls with it, and forcing everything static would break them.
		 */
		$css .= KMND_PREVIEW_SCOPE . ' [style*="position:fixed"],'
			. KMND_PREVIEW_SCOPE . ' [style*="position: fixed"]'
			. "{position:absolute!important}\n";

		if ( ! file_put_contents( $path, $css ) ) {
			return false;
		}
	}

	return array(
		'path' => $path,
		'url'  => $url,
		'ver'  => (string) $stamp,
	);
}

/**
 * Load the generated stylesheet into the editor canvas.
 */
add_action( 'enqueue_block_assets', function () {
	if ( ! is_admin() ) {
		return;
	}

	$file = kmnd_preview_css_file();
	if ( ! $file ) {
		return;
	}

	wp_enqueue_style( 'kmnd-block-preview', $file['url'], array(), $file['ver'] );
}, 30 );

/**
 * Drop the generated file when the theme is switched or updated, so the next
 * editor load rebuilds it.
 */
add_action( 'switch_theme', function () {
	$uploads = wp_upload_dir();
	if ( empty( $uploads['error'] ) ) {
		@unlink( $uploads['basedir'] . '/kmnd-block-preview.css' );
	}
} );

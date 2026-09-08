<?php
/**
 * DPP Video Section — content migration.
 *
 * Places the acf/dpp-video block on a page and, optionally, relocates the
 * Pathway graphic to the position named in the brief. Nothing here is required
 * for the block to work: an editor can equally well drag it into place in
 * Gutenberg. This exists so staging and production end up identical.
 *
 * SAFETY
 *  - dry run by default: prints the plan and changes nothing
 *  - operates on the parsed block tree, not on raw string offsets, so wrapper
 *    blocks such as core/group are never entered by accident
 *  - re-running PRESERVES the settings already saved on an existing DPP block
 *    (video, captions, transcript, colours) and only moves it
 *  - backs post_content up to post meta before writing
 *  - writes with wp_slash() and then re-reads and verifies the result
 *  - aborts if the block set changes in any way other than the intended move
 *
 * USAGE  (from the WordPress root)
 *   php wp-content/themes/kmnd-child/libs/acf/dpp_video/install.php
 *   php .../install.php --apply
 *   php .../install.php --rollback --apply
 *
 * Options
 *   --page=10        target page ID (default: the configured front page)
 *   --anchor=NAME    block to position against (default acf/video-block-v3)
 *   --after          place after the anchor instead of before
 *   --move-pathway   also move acf/video-block-v3 to sit before acf/features-block,
 *                    which is where the brief asks for the Pathway graphic
 *
 * @package kmnd-child
 */

if ( PHP_SAPI !== 'cli' ) {
	http_response_code( 403 );
	exit( "This script may only be run from the command line.\n" );
}

/* ------------------------------------------------------------ bootstrap WP */

$root = getcwd();
while ( ! is_file( $root . '/wp-load.php' ) && dirname( $root ) !== $root ) {
	$root = dirname( $root );
}
if ( ! is_file( $root . '/wp-load.php' ) ) {
	$root = dirname( __DIR__, 5 );
}
if ( ! is_file( $root . '/wp-load.php' ) ) {
	fwrite( STDERR, "Could not locate wp-load.php. Run this from the WordPress root.\n" );
	exit( 1 );
}
chdir( $root );

define( 'WP_USE_THEMES', false );
require_once $root . '/wp-load.php';

/* ---------------------------------------------------------------- options */

$opts = array(
	'apply'       => false,
	'rollback'    => false,
	'page'        => 0,
	'anchor'      => 'acf/video-block-v3',
	'after'       => false,
	'movePathway' => false,
);

foreach ( array_slice( $argv, 1 ) as $arg ) {
	if ( '--apply' === $arg ) {
		$opts['apply'] = true;
	} elseif ( '--rollback' === $arg ) {
		$opts['rollback'] = true;
	} elseif ( '--after' === $arg ) {
		$opts['after'] = true;
	} elseif ( '--move-pathway' === $arg ) {
		$opts['movePathway'] = true;
	} elseif ( preg_match( '/^--page=([1-9][0-9]*)$/', $arg, $m ) ) {
		$opts['page'] = (int) $m[1];
	} elseif ( preg_match( '~^--anchor=([a-z0-9-]+/[a-z0-9-]+)$~', $arg, $m ) ) {
		$opts['anchor'] = $m[1];
	} else {
		fwrite( STDERR, "Unknown option: {$arg}\n" );
		exit( 1 );
	}
}

$post_id  = $opts['page'] ?: (int) get_option( 'page_on_front' );
$meta_key = '_dpp_video_content_backup';

function dpp_out( $line = '' ) {
	echo $line . PHP_EOL;
}

function dpp_fail( $line ) {
	fwrite( STDERR, 'ERROR: ' . $line . PHP_EOL );
	exit( 1 );
}

/** Top-level block names, blanks removed. */
function dpp_names( array $blocks ) {
	return array_values( array_filter( wp_list_pluck( $blocks, 'blockName' ) ) );
}

/** Index of the first top-level block with this name, or false. */
function dpp_index_of( array $blocks, $name ) {
	foreach ( $blocks as $i => $b ) {
		if ( isset( $b['blockName'] ) && $name === $b['blockName'] ) {
			return $i;
		}
	}
	return false;
}

dpp_out( '' );
dpp_out( 'DPP Video Section — content migration' );
dpp_out( str_repeat( '=', 56 ) );

if ( ! $post_id ) {
	dpp_fail( 'No target page. Pass --page=ID (this site has no static front page set).' );
}

$post = get_post( $post_id );
if ( ! $post ) {
	dpp_fail( "Page {$post_id} does not exist." );
}

dpp_out( sprintf( 'Target page : #%d — %s', $post_id, get_the_title( $post ) ) );

/* ---------------------------------------------------------------- rollback */

if ( $opts['rollback'] ) {
	$backup = get_post_meta( $post_id, $meta_key, true );
	if ( '' === $backup ) {
		dpp_fail( 'No backup found for this page — nothing to roll back.' );
	}

	dpp_out( 'Mode        : ROLLBACK' );
	dpp_out( sprintf( 'Backup size : %s bytes', number_format( strlen( $backup ) ) ) );

	if ( ! $opts['apply'] ) {
		dpp_out( '' );
		dpp_out( 'Dry run — nothing written. Re-run with --rollback --apply to restore.' );
		exit( 0 );
	}

	$res = wp_update_post( array(
		'ID'           => $post_id,
		'post_content' => wp_slash( $backup ),
	), true );

	if ( is_wp_error( $res ) ) {
		dpp_fail( 'Restore failed: ' . $res->get_error_message() );
	}

	clean_post_cache( $post_id );

	if ( get_post( $post_id )->post_content !== $backup ) {
		dpp_fail( 'Restore wrote, but verification failed. The backup meta has been kept — investigate.' );
	}

	delete_post_meta( $post_id, $meta_key );
	dpp_out( '' );
	dpp_out( 'Restored and verified. The backup has been cleared.' );
	exit( 0 );
}

/* ------------------------------------------------------------------ insert */

$content = $post->post_content;
$blocks  = parse_blocks( $content );
$names   = dpp_names( $blocks );

// Refuse to work on content the block parser cannot reproduce exactly. If this
// fails, string-level damage has happened elsewhere and must be fixed first.
if ( serialize_blocks( $blocks ) !== $content ) {
	dpp_fail( 'This page does not survive a parse/serialize round trip byte-for-byte. Refusing to write.' );
}

dpp_out( 'Anchor      : ' . $opts['anchor'] . ( $opts['after'] ? ' (insert AFTER)' : ' (insert BEFORE)' ) );
dpp_out( 'Pathway move: ' . ( $opts['movePathway'] ? 'yes — before acf/features-block' : 'no' ) );
dpp_out( 'Mode        : ' . ( $opts['apply'] ? 'APPLY' : 'DRY RUN' ) );
dpp_out( '' );
dpp_out( 'Current block order:' );
foreach ( $names as $n ) {
	dpp_out( '  · ' . $n );
}

/* Lift out any DPP block that is already there, keeping every saved setting. */
$existing = null;
foreach ( $blocks as $i => $b ) {
	if ( isset( $b['blockName'] ) && 'acf/dpp-video' === $b['blockName'] ) {
		$existing = $b;
		unset( $blocks[ $i ] );
	}
}
$blocks = array_values( $blocks );

if ( $existing ) {
	dpp_out( '' );
	dpp_out( 'An existing DPP block was found. Its saved settings (video, captions,' );
	dpp_out( 'transcript, colours) are carried over unchanged — only its position moves.' );
	$dpp_block = $existing;
} else {
	// A fresh block is seeded with the full default set so the section is
	// complete and demonstrable straight away — including a placeholder
	// transcript, which is what makes the disclosure below the video appear.
	$dpp_block = array(
		'blockName'    => 'acf/dpp-video',
		'attrs'        => array(
			'name'  => 'acf/dpp-video',
			'data'  => array(
				'dpp_heading'           => 'Introducing Isla: How our digital patient pathways work',
				'_dpp_heading'          => 'field_dpp_video_heading',
				'dpp_poster'            => '',
				'_dpp_poster'           => 'field_dpp_video_poster',
				'dpp_video_mp4'         => '',
				'_dpp_video_mp4'        => 'field_dpp_video_mp4',
				'dpp_video_webm'        => '',
				'_dpp_video_webm'       => 'field_dpp_video_webm',
				'dpp_captions'          => '',
				'_dpp_captions'         => 'field_dpp_video_captions',
				'dpp_transcript'        => '<p>[Transcript to be supplied with the final video.]</p>',
				'_dpp_transcript'       => 'field_dpp_video_transcript',
				'dpp_cta'               => '',
				'_dpp_cta'              => 'field_dpp_video_cta',
				'dpp_bg_preset'         => '#F7F7F7',
				'_dpp_bg_preset'        => 'field_dpp_bg_preset',
				'dpp_heading_preset'    => '#242331',
				'_dpp_heading_preset'   => 'field_dpp_heading_preset',
				'dpp_heading_align'     => 'center',
				'_dpp_heading_align'    => 'field_dpp_heading_align',
				'dpp_card_bg'           => '#FFFFFF',
				'_dpp_card_bg'          => 'field_dpp_card_bg',
				'dpp_card_shadow'       => 'figma',
				'_dpp_card_shadow'      => 'field_dpp_card_shadow',
				'dpp_card_radius'       => 28.8,
				'_dpp_card_radius'      => 'field_dpp_card_radius',
				'dpp_media_radius'      => 20,
				'_dpp_media_radius'     => 'field_dpp_media_radius',
				'dpp_aspect'            => '16 / 9',
				'_dpp_aspect'           => 'field_dpp_aspect',
				'dpp_padding'           => 100,
				'_dpp_padding'          => 'field_dpp_padding',
				'dpp_play_style'        => 'default',
				'_dpp_play_style'       => 'field_dpp_play_style',
				'dpp_play_color'        => '#F56612',
				'_dpp_play_color'       => 'field_dpp_play_color',
				'dpp_play_size'         => 10.7,
				'_dpp_play_size'        => 'field_dpp_play_size',
				'dpp_play_offset'       => 60,
				'_dpp_play_offset'      => 'field_dpp_play_offset',
				'dpp_show_transcript'   => 1,
				'_dpp_show_transcript'  => 'field_dpp_show_transcript',
				'dpp_transcript_open'   => 0,
				'_dpp_transcript_open'  => 'field_dpp_transcript_open',
				'dpp_transcript_label'  => 'Read the transcript',
				'_dpp_transcript_label' => 'field_dpp_transcript_label',
				'dpp_schema'            => 1,
				'_dpp_schema'           => 'field_dpp_schema',
			),
			'align' => 'full',
			'mode'  => 'preview',
		),
		'innerBlocks'  => array(),
		'innerHTML'    => '',
		'innerContent' => array(),
	);
}

/* Optionally move the Pathway graphic to the position named in the brief. */
$pathway = null;
if ( $opts['movePathway'] ) {
	$pi = dpp_index_of( $blocks, 'acf/video-block-v3' );
	if ( false === $pi ) {
		dpp_fail( 'Cannot move the Pathway graphic: acf/video-block-v3 is not on this page.' );
	}
	if ( false === dpp_index_of( $blocks, 'acf/features-block' ) ) {
		dpp_fail( 'Cannot move the Pathway graphic: acf/features-block ("Cut delays, not corners") is not on this page.' );
	}
	$pathway = $blocks[ $pi ];
	unset( $blocks[ $pi ] );
	$blocks = array_values( $blocks );
}

/* Place the DPP block against the anchor. */
$ai = dpp_index_of( $blocks, $opts['anchor'] );
if ( false === $ai ) {
	// The anchor may be the very block that was just lifted out for relocation.
	if ( $pathway && 'acf/video-block-v3' === $opts['anchor'] ) {
		$ai = dpp_index_of( $blocks, 'acf/development-indicators' );
	}
	if ( false === $ai ) {
		dpp_fail( sprintf( 'Anchor block "%s" is not on this page. Pass --anchor=<block> to choose another.', $opts['anchor'] ) );
	}
}
$at = $opts['after'] ? $ai + 1 : $ai;
array_splice( $blocks, $at, 0, array( $dpp_block ) );

/* Re-insert the Pathway graphic before "Cut delays, not corners". */
if ( $pathway ) {
	$fi = dpp_index_of( $blocks, 'acf/features-block' );
	array_splice( $blocks, $fi, 0, array( $pathway ) );
}

$new_content = serialize_blocks( $blocks );
$after_names = dpp_names( parse_blocks( $new_content ) );

/* -------------------------------------------------------------- safety net */

$expected = $names;
if ( ! in_array( 'acf/dpp-video', $expected, true ) ) {
	$expected[] = 'acf/dpp-video';
}
sort( $expected );
$got = $after_names;
sort( $got );

if ( $expected !== $got ) {
	dpp_fail( 'Refusing to write: the set of blocks would change, not just their order.' );
}

// Guard against the class of bug where JSON escapes lose their backslashes.
if ( preg_match( '/(?<!\\\\)u00[0-9a-f]{2}/i', $new_content ) ) {
	dpp_fail( 'Refusing to write: the result contains unescaped \\uXXXX sequences (damaged block attributes).' );
}

dpp_out( '' );
dpp_out( 'Resulting block order:' );
foreach ( $after_names as $n ) {
	if ( 'acf/dpp-video' === $n ) {
		$mark = '  > ';
	} elseif ( $pathway && 'acf/video-block-v3' === $n ) {
		$mark = '  ~ ';
	} else {
		$mark = '  · ';
	}
	dpp_out( $mark . $n );
}

if ( $new_content === $content ) {
	dpp_out( '' );
	dpp_out( 'Already in the requested order. No write needed.' );
	exit( 0 );
}

if ( ! $opts['apply'] ) {
	dpp_out( '' );
	dpp_out( 'Dry run — nothing was written.' );
	dpp_out( 'Re-run with --apply to save. A backup is taken automatically.' );
	exit( 0 );
}

/* ------------------------------------------------------------------- write */

if ( '' === get_post_meta( $post_id, $meta_key, true ) ) {
	add_post_meta( $post_id, $meta_key, wp_slash( $content ), true );
	dpp_out( '' );
	dpp_out( sprintf( 'Backup saved to post meta "%s" (%s bytes).', $meta_key, number_format( strlen( $content ) ) ) );
} else {
	dpp_out( '' );
	dpp_out( 'Existing backup kept (from the first run).' );
}

$res = wp_update_post( array(
	'ID'           => $post_id,
	'post_content' => wp_slash( $new_content ),
), true );

if ( is_wp_error( $res ) ) {
	dpp_fail( 'Update failed: ' . $res->get_error_message() );
}

clean_post_cache( $post_id );

if ( get_post( $post_id )->post_content !== $new_content ) {
	dpp_fail( 'Write completed but verification failed. The backup has been kept — investigate before retrying.' );
}

dpp_out( 'Saved and verified.' );
dpp_out( '' );
dpp_out( 'Clear any page/CDN cache before reviewing.' );
dpp_out( 'To undo:  php ' . basename( __FILE__ ) . ' --rollback --apply' );

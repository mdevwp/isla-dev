<?php
/**
 * DPP Video Section — accessible, click-to-play homepage video.
 *
 * Brief requirements implemented here:
 *  - never auto-plays (desktop or mobile): no `autoplay`, `preload="none"`
 *  - clear, visible Play/Pause + Mute/Unmute (native `controls` once started,
 *    large branded Play button before that)
 *  - does not slow the page down: nothing but a poster image is fetched until
 *    the visitor presses Play
 *  - captions are indexable: <track> for playback + on-page transcript and
 *    VideoObject schema for search engines
 *
 * Every visual choice is driven by CSS custom properties written inline on the
 * section, so the block settings can restyle it without touching the stylesheet.
 */

$media_uri = get_stylesheet_directory_uri() . '/libs/acf/dpp_video/media';

/* ---------------------------------------------------------------- content */

$heading    = get_field( 'dpp_heading' ) ?: 'Introducing Isla: How our digital patient pathways work';

// Heading level is author-controlled but must never become arbitrary markup.
$heading_tag = strtolower( (string) get_field( 'dpp_heading_tag' ) );
if ( ! in_array( $heading_tag, array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ), true ) ) {
	$heading_tag = 'h2';
}

$source       = get_field( 'dpp_source' ) ?: 'file';
$youtube_url  = get_field( 'dpp_youtube_url' );
$youtube_id   = '';

if ( 'youtube' === $source && $youtube_url ) {
	// watch?v=ID · youtu.be/ID · /embed/ID · /shorts/ID · /live/ID
	if ( preg_match( '~(?:youtu\.be/|v=|/embed/|/shorts/|/live/)([A-Za-z0-9_-]{11})~', $youtube_url, $m ) ) {
		$youtube_id = $m[1];
	}
}

$is_youtube = ( 'youtube' === $source && '' !== $youtube_id );
$poster_fld = get_field( 'dpp_poster' );
$mp4        = get_field( 'dpp_video_mp4' );
$mp4_mobile = get_field( 'dpp_video_mp4_mobile' );
$webm       = get_field( 'dpp_video_webm' );
$captions   = get_field( 'dpp_captions' );
$transcript = get_field( 'dpp_transcript' );
$cta        = get_field( 'dpp_cta' );

/* ------------------------------------------------------------- appearance */

/** Resolve a "brand preset or custom" colour pair. */
$pick_colour = static function ( $preset_field, $custom_field, $fallback ) {
	$preset = get_field( $preset_field );
	if ( 'custom' === $preset ) {
		return get_field( $custom_field ) ?: $fallback;
	}
	return $preset ?: $fallback;
};

$bg            = $pick_colour( 'dpp_bg_preset', 'dpp_bg_custom', '#F7F7F7' );
$heading_color = $pick_colour( 'dpp_heading_preset', 'dpp_heading_custom', '#242331' );
$heading_align = get_field( 'dpp_heading_align' ) ?: 'center';
$card_bg       = get_field( 'dpp_card_bg' ) ?: '#FFFFFF';
$card_shadow   = get_field( 'dpp_card_shadow' );
// Back-compat: the field used to be a true/false toggle.
if ( true === $card_shadow || 1 === $card_shadow || '1' === $card_shadow || null === $card_shadow || '' === $card_shadow ) {
	$card_shadow = 'figma';
} elseif ( false === $card_shadow || 0 === $card_shadow || '0' === $card_shadow ) {
	$card_shadow = 'none';
}
$card_shadow = in_array( $card_shadow, array( 'figma', 'testimonials', 'none' ), true ) ? $card_shadow : 'figma';
$card_radius   = get_field( 'dpp_card_radius' );
$card_radius   = ( '' === $card_radius || null === $card_radius ) ? 28.8 : (float) $card_radius;
$media_radius  = get_field( 'dpp_media_radius' );
$media_radius  = ( '' === $media_radius || null === $media_radius ) ? 20 : (float) $media_radius;
$aspect        = get_field( 'dpp_aspect' ) ?: '16 / 9';
$padding       = get_field( 'dpp_padding' );
$padding       = ( '' === $padding || null === $padding ) ? 100 : (int) $padding;

/* ------------------------------------------------------------ play button */

$play_style  = get_field( 'dpp_play_style' ) ?: 'default';
$play_color  = get_field( 'dpp_play_color' ) ?: '#F56612';
$play_custom = get_field( 'dpp_play_custom' );
$play_size   = (float) ( get_field( 'dpp_play_size' ) ?: 10.7 );
$play_size   = max( 4, min( 20, $play_size ) );
$offset      = (int) ( get_field( 'dpp_play_offset' ) ?: 60 );
$offset      = max( 20, min( 85, $offset ) );

/* ---------------------------------------------------- accessibility / SEO */

$show_transcript  = get_field( 'dpp_show_transcript' );
$show_transcript  = ( null === $show_transcript ) ? true : (bool) $show_transcript;
$transcript_open  = (bool) get_field( 'dpp_transcript_open' );
$transcript_label = get_field( 'dpp_transcript_label' ) ?: 'Read the transcript';
$want_schema      = get_field( 'dpp_schema' );
$want_schema      = ( null === $want_schema ) ? true : (bool) $want_schema;
$video_label      = get_field( 'dpp_video_label' ) ?: $heading;

/* -------------------------------------------------- media, with fallbacks */

// Fall back to the bundled placeholder media so the block is previewable
// before the final assets land.
$is_placeholder = ! $is_youtube && empty( $mp4 ) && empty( $webm );
if ( $is_placeholder ) {
	$mp4  = $media_uri . '/dpp-placeholder.mp4';
	$webm = $media_uri . '/dpp-placeholder.webm';

	// The demo captions belong to the demo clip only. Pairing them with a real
	// video would caption it with the wrong words, so this fallback is scoped
	// to the placeholder and never leaks onto client media.
	if ( empty( $captions ) ) {
		$captions = $media_uri . '/dpp-placeholder.vtt';
	}
}

// Real video with no captions yet: emit no <track> at all rather than a wrong one.

// Whichever source exists is what the schema and the no-support fallback point at.
$content_url = $mp4 ?: $webm;

$poster_url    = $media_uri . '/dpp-poster.jpg';
$poster_alt    = 'Isla spokesperson introducing the digital patient pathway platform';
$poster_w      = 1600;
$poster_h      = 900;
$poster_srcset = array();
$poster_sizes  = '(max-width: 768px) 100vw, (max-width: 1600px) 90vw, 1419px';

if ( is_array( $poster_fld ) && ! empty( $poster_fld['url'] ) ) {
	$poster_url = $poster_fld['url'];
	$poster_alt = $poster_fld['alt'] ?: $poster_alt;
	$poster_w   = $poster_fld['width'] ?: $poster_w;
	$poster_h   = $poster_fld['height'] ?: $poster_h;
	$wp_srcset  = ! empty( $poster_fld['ID'] ) ? wp_get_attachment_image_srcset( $poster_fld['ID'], 'full' ) : '';
	if ( $wp_srcset ) {
		$poster_srcset[''] = $wp_srcset;
	}
} elseif ( $is_youtube ) {
	// YouTube's own still, so a YouTube block needs no uploaded poster to look right.
	$poster_url = 'https://i.ytimg.com/vi/' . $youtube_id . '/maxresdefault.jpg';
	$poster_alt = $heading;
	$poster_w   = 1280;
	$poster_h   = 720;
} else {
	$poster_srcset['image/webp'] = $media_uri . '/dpp-poster-800.webp 800w, ' . $media_uri . '/dpp-poster.webp 1600w';
	$poster_srcset['']           = $media_uri . '/dpp-poster-800.jpg 800w, ' . $media_uri . '/dpp-poster.jpg 1600w';
}

/* ------------------------------------------------------------- attributes */

$uid           = 'dpp-video-' . wp_unique_id();
$heading_id    = $uid . '-heading';
$transcript_id = $uid . '-transcript';

$classes = array( 'dpp-video-section' );
if ( ! empty( $block['className'] ) ) {
	$classes[] = $block['className'];
}
if ( $is_placeholder ) {
	$classes[] = 'dpp-video-section--placeholder';
}
if ( 'figma' !== $card_shadow ) {
	$classes[] = 'dpp-video-section--shadow-' . $card_shadow;
}
if ( 'left' === $heading_align ) {
	$classes[] = 'dpp-video-section--heading-left';
}

$anchor = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( $block['anchor'] ) . '"' : '';

$vars = array(
	'--dpp-bg'            => $bg,
	'--dpp-heading-color' => $heading_color,
	'--dpp-card-bg'       => $card_bg,
	'--dpp-card-radius'   => $card_radius . 'px',
	'--dpp-media-radius'  => $media_radius . 'px',
	'--dpp-aspect'        => $aspect,
	'--dpp-padding'       => $padding . 'px',
	'--dpp-play-width'    => $play_size . '%',
	'--dpp-play-offset'   => $offset . '%',
	'--dpp-play-color'    => $play_color,
	'--dpp-heading-align' => $heading_align,
);
$style = '';
foreach ( $vars as $prop => $value ) {
	$style .= $prop . ':' . $value . ';';
}

// Transcript as plain text for the schema payload.
//
// Entities are decoded *before* tags are stripped, not after: the other order
// lets an encoded "&lt;/script&gt;" survive the strip and come back out as live
// markup. Stripping last means anything that decodes into a tag is removed.
$transcript_text = wp_strip_all_tags( html_entity_decode( (string) $transcript, ENT_QUOTES, 'UTF-8' ) );
$transcript_text = trim( preg_replace( '/\s+/u', ' ', $transcript_text ) );
$has_transcript  = $show_transcript && '' !== $transcript_text;
?>
<section<?= $anchor; ?>
	class="<?= esc_attr( implode( ' ', $classes ) ); ?>"
	style="<?= esc_attr( $style ); ?>"
	aria-labelledby="<?= esc_attr( $heading_id ); ?>">

	<div class="container dpp-video-section__container">

		<<?= $heading_tag; ?> id="<?= esc_attr( $heading_id ); ?>" class="main-heading dpp-video-section__heading">
			<?= esc_html( $heading ); ?>
		</<?= $heading_tag; ?>>

		<?php
		// Without JavaScript the poster overlay and the Play button would sit on
		// top of a player the visitor has no way to start. Hiding them hands over
		// to the browser's own controls, which are present in the markup below.
		?>
		<noscript>
			<style>
				.dpp-video-section__stage picture,
				.dpp-video-section__play { display: none !important; }
			</style>
		</noscript>

		<figure class="dpp-video-section__figure">
			<div class="dpp-video-section__card">
				<div class="dpp-video-section__stage">

					<?php if ( $is_youtube ) : ?>
						<?php
						/*
						 * Facade embed. Nothing is requested from Google until the
						 * visitor presses Play, so the homepage keeps its load budget
						 * and no third-party cookie is set on arrival. The <noscript>
						 * fallback below still gives a working player without JS.
						 */
						?>
						<div class="dpp-video-section__yt"
							data-dpp-youtube="<?= esc_attr( $youtube_id ); ?>"
							data-dpp-title="<?= esc_attr( $video_label ); ?>"></div>

						<noscript>
							<iframe class="dpp-video-section__yt-frame"
								src="https://www.youtube-nocookie.com/embed/<?= esc_attr( $youtube_id ); ?>?rel=0"
								title="<?= esc_attr( $video_label ); ?>"
								loading="lazy"
								allow="accelerometer; encrypted-media; gyroscope; picture-in-picture"
								allowfullscreen></iframe>
						</noscript>
					<?php else : ?>
					<?php
					// `controls` ships in the HTML so the player is usable with no
					// JavaScript. The script removes it on init (it would otherwise
					// be focusable underneath the poster) and puts it back on play.
					?>
					<video
						class="dpp-video-section__video"
						id="<?= esc_attr( $uid ); ?>"
						controls
						preload="none"
						playsinline
						webkit-playsinline
						poster="<?= esc_url( $poster_url ); ?>"
						width="<?= esc_attr( $poster_w ); ?>"
						height="<?= esc_attr( $poster_h ); ?>"
						aria-label="<?= esc_attr( $video_label ); ?>"
						<?= $has_transcript ? 'aria-describedby="' . esc_attr( $transcript_id ) . '"' : ''; ?>>
						<?php if ( $mp4_mobile ) : ?>
							<source src="<?= esc_url( $mp4_mobile ); ?>" type="video/mp4" media="(max-width: 767px)">
						<?php endif; ?>
						<?php if ( $webm ) : ?>
							<source src="<?= esc_url( $webm ); ?>" type="video/webm"<?= $mp4_mobile ? ' media="(min-width: 768px)"' : ''; ?>>
						<?php endif; ?>
						<?php if ( $mp4 ) : ?>
							<source src="<?= esc_url( $mp4 ); ?>" type="video/mp4">
						<?php endif; ?>
						<?php if ( $captions ) : ?>
							<track kind="captions" src="<?= esc_url( $captions ); ?>" srclang="en" label="English" default>
						<?php endif; ?>
						<p class="dpp-video-section__fallback">
							Your browser can’t play embedded video.
							<a href="<?= esc_url( $content_url ); ?>">Download the video</a> instead.
						</p>
					</video>
					<?php endif; ?>

					<picture>
						<?php if ( ! empty( $poster_srcset['image/webp'] ) ) : ?>
							<source type="image/webp"
								srcset="<?= esc_attr( $poster_srcset['image/webp'] ); ?>"
								sizes="<?= esc_attr( $poster_sizes ); ?>">
						<?php endif; ?>
						<img
							class="dpp-video-section__poster"
							src="<?= esc_url( $poster_url ); ?>"
							<?php if ( ! empty( $poster_srcset[''] ) ) : ?>
								srcset="<?= esc_attr( $poster_srcset[''] ); ?>"
								sizes="<?= esc_attr( $poster_sizes ); ?>"
							<?php endif; ?>
							alt="<?= esc_attr( $poster_alt ); ?>"
							width="<?= esc_attr( $poster_w ); ?>"
							height="<?= esc_attr( $poster_h ); ?>"
							loading="lazy"
							decoding="async"
							fetchpriority="low">
					</picture>

					<button type="button"
						class="dpp-video-section__play<?= 'custom' === $play_style && ! empty( $play_custom['url'] ) ? ' dpp-video-section__play--custom' : ''; ?>"
						data-dpp-play
						aria-controls="<?= esc_attr( $uid ); ?>">
						<?php if ( 'custom' === $play_style && ! empty( $play_custom['url'] ) ) : ?>
							<img class="dpp-video-section__play-icon"
								src="<?= esc_url( $play_custom['url'] ); ?>"
								alt=""
								aria-hidden="true"
								loading="lazy"
								decoding="async">
						<?php else : ?>
							<?php // Exact play button exported from Figma (Group 1000006520). ?>
							<svg class="dpp-video-section__play-icon" width="145" height="147" viewBox="0 0 145 147" fill="none" xmlns="http://www.w3.org/2000/svg" focusable="false" aria-hidden="true">
								<g opacity="0.9">
									<path d="M72.3446 146.041C58.0362 146.041 44.0491 141.758 32.1521 133.735C20.2551 125.711 10.9825 114.307 5.50693 100.964C0.0313454 87.6215 -1.40132 72.9395 1.39011 58.775C4.18154 44.6104 11.0717 31.5994 21.1893 21.3873C31.3068 11.1752 44.1974 4.22064 58.2309 1.40313C72.2644 -1.41438 86.8104 0.0316688 100.03 5.55842C113.249 11.0852 124.548 20.4444 132.497 32.4525C140.446 44.4607 144.689 58.5785 144.689 73.0205C144.689 92.3868 137.067 110.96 123.5 124.654C109.933 138.348 91.5316 146.041 72.3446 146.041ZM72.3446 12.1701C60.4209 12.1701 48.765 15.739 38.8509 22.4253C28.9367 29.1116 21.2095 38.6151 16.6465 49.7341C12.0836 60.8531 10.8897 73.088 13.2159 84.8919C15.5421 96.6957 21.2838 107.538 29.7152 116.048C38.1465 124.558 48.8886 130.354 60.5832 132.702C72.2777 135.05 84.3995 133.845 95.4155 129.239C106.432 124.633 115.847 116.834 122.472 106.827C129.096 96.8204 132.632 85.0556 132.632 73.0205C132.632 56.882 126.28 41.4045 114.974 29.9928C103.668 18.5811 88.3337 12.1701 72.3446 12.1701Z" fill="currentColor"/>
									<ellipse cx="71.945" cy="72.6177" rx="61.9908" ry="62.5699" fill="currentColor"/>
									<path d="M56.8186 33.702C57.4292 33.4875 58.1124 33.4184 58.7815 33.5106C59.4418 33.6016 60.0325 33.8424 60.4924 34.1785L105.328 71.3377C105.927 71.8345 106.192 72.4412 106.192 72.9988C106.192 73.5565 105.927 74.1631 105.328 74.66L60.4592 111.847C59.8788 112.321 59.0685 112.632 58.1702 112.678C57.7078 112.671 57.2555 112.592 56.8411 112.446L56.8323 112.443L56.8235 112.439L56.5911 112.352C56.0648 112.135 55.646 111.819 55.3586 111.462C55.0342 111.058 54.8894 110.621 54.8928 110.206V35.8504C54.9162 35.4515 55.0738 35.0354 55.3928 34.6522C55.721 34.2579 56.2075 33.9167 56.8186 33.702ZM61.51 103.767L63.967 101.731L97.2405 74.1541L98.634 72.9988L97.2405 71.8445L63.967 44.2664L61.51 42.2303V103.767Z" fill="#fff" stroke="#fff" stroke-width="3"/>
									<path d="M98.7007 74.9753L59.2828 112.099L59.3859 37.7402L98.7007 74.9753Z" fill="#fff"/>
								</g>
							</svg>
						<?php endif; ?>
						<span class="screen-reader-text">Play video: <?= esc_html( $video_label ); ?></span>
					</button>

				</div>
			</div>

			<figcaption class="screen-reader-text">
				<?= esc_html( $video_label ); ?> — video with English captions<?= $has_transcript ? '. A full transcript follows.' : '.'; ?>
			</figcaption>
		</figure>

		<?php if ( $has_transcript ) : ?>
			<details class="dpp-video-section__transcript" id="<?= esc_attr( $transcript_id ); ?>" <?= $transcript_open ? 'open' : ''; ?>>
				<summary class="dpp-video-section__transcript-toggle">
					<span><?= esc_html( $transcript_label ); ?></span>
				</summary>
				<div class="dpp-video-section__transcript-body">
					<?php
					// Values saved by the previous WYSIWYG field already carry
					// paragraph tags; plain text typed into the textarea does not.
					$transcript_html = (string) $transcript;
					if ( false === stripos( $transcript_html, '<p' ) ) {
						$transcript_html = wpautop( $transcript_html );
					}
					echo wp_kses_post( $transcript_html );
					?>
				</div>
			</details>
		<?php endif; ?>

		<?php if ( ! empty( $cta['url'] ) && ! empty( $cta['title'] ) ) : ?>
			<div class="dpp-video-section__cta">
				<a href="<?= esc_url( $cta['url'] ); ?>"
					class="btn button find-out-more primary large"
					<?= ! empty( $cta['target'] ) ? 'target="' . esc_attr( $cta['target'] ) . '" rel="noopener"' : ''; ?>>
					<?= esc_html( $cta['title'] ); ?>
				</a>
			</div>
		<?php endif; ?>

	</div>

	<?php
	// VideoObject schema — helps search engines index the video and its transcript.
	//
	// Deliberately suppressed while the block is still on placeholder media: telling
	// Google that the demo clip is the real DPP video would be worse than no schema
	// at all, and it would have to be un-indexed later.
	if ( $want_schema && ! $is_placeholder && ( $content_url || $is_youtube ) && ! is_admin() ) {
		$schema = array(
			'@context'     => 'https://schema.org',
			'@type'        => 'VideoObject',
			'name'         => $heading,
			'description'  => $transcript_text ? wp_trim_words( $transcript_text, 40, '…' ) : $heading,
			'thumbnailUrl' => $poster_url,
		);

		if ( $is_youtube ) {
			$schema['embedUrl'] = 'https://www.youtube.com/embed/' . $youtube_id;
		} else {
			$schema['contentUrl'] = $content_url;
		}

		// uploadDate should describe the video, not the page. Use the media
		// library upload time when the file lives here; otherwise leave the
		// property out rather than assert a date we cannot support.
		$video_attachment = attachment_url_to_postid( $content_url );
		if ( $video_attachment ) {
			$uploaded = get_post_datetime( $video_attachment );
			if ( $uploaded ) {
				$schema['uploadDate'] = $uploaded->format( 'c' );
			}
		}

		if ( $transcript_text ) {
			$schema['transcript'] = $transcript_text;
		}

		// The HEX flags matter: field values are author-supplied and may contain a
		// literal "</script>", which would otherwise close this tag and let markup
		// through. JSON_UNESCAPED_SLASHES alone does not protect against that.
		$json = wp_json_encode(
			$schema,
			JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
				| JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
		);

		if ( false !== $json ) {
			echo '<script type="application/ld+json">' . $json . '</script>';
		}
	}
	?>
</section>

<?php
/**
 * ACF field group for the "DPP Video Section" block (acf/dpp-video).
 *
 * Registered in code (the site has no acf-json sync) so the block is
 * self-contained and version-controlled.
 */

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

/**
 * Brand palette, taken from brandcolor_palette() in the child theme's
 * functions.php plus the two greys used by the existing homepage sections.
 *
 * Guarded: redeclaring a function is a fatal error, and this file lives in a
 * theme where another plugin could conceivably claim the same name.
 */
if ( ! function_exists( 'kmnd_dpp_brand_colours' ) ) :
function kmnd_dpp_brand_colours() {
	return array(
		'#F7F7F7' => 'Section grey (#F7F7F7) — Figma default',
		'#F8F8F8' => 'Theme grey (#F8F8F8)',
		'#FFFFFF' => 'White (#FFFFFF)',
		'#FDFDFD' => 'Nearly-white (#FDFDFD)',
		'#EEEDEE' => 'Cloudy grey (#EEEDEE)',
		'#15253C' => 'Deep blue (#15253C)',
		'#242331' => 'Isla dark (#242331)',
		'#0E1215' => 'Obsidian (#0E1215)',
		'#F56612' => 'Isla orange (#F56612)',
		'#F47A22' => 'Isla orange light (#F47A22)',
		'#EE7324' => 'Isla orange deep (#EE7324)',
		'#F4B61E' => 'Sunshine yellow (#F4B61E)',
		'#797979' => 'Light grey (#797979)',
	);
}
endif;

acf_add_local_field_group( array(
	'key'      => 'group_dpp_video_section',
	'title'    => 'DPP Video Section',
	'fields'   => array(

		/* ---------------------------------------------------------- Content */
		array(
			'key'       => 'field_dpp_tab_content',
			'label'     => 'Content',
			'type'      => 'tab',
			'placement' => 'top',
		),
		array(
			'key'           => 'field_dpp_video_heading',
			'label'         => 'Heading (H2)',
			'name'          => 'dpp_heading',
			'type'          => 'text',
			'instructions'  => 'Shown as an H2 above the video. Uses the same font and size as the other homepage H2 titles.',
			'default_value' => 'Introducing Isla: How our digital patient pathways work',
		),
		array(
			'key'           => 'field_dpp_heading_tag',
			'label'         => 'Heading level',
			'name'          => 'dpp_heading_tag',
			'type'          => 'select',
			'choices'       => array(
				'h1' => 'H1',
				'h2' => 'H2 (default)',
				'h3' => 'H3',
				'h4' => 'H4',
				'h5' => 'H5',
				'h6' => 'H6',
			),
			'default_value' => 'h2',
			'ui'            => 1,
			'instructions'  => 'The visual style stays the same whichever level you pick. Only change it if the page outline needs it — a page should have exactly one H1, and this block is not usually it.',
		),
		array(
			'key'           => 'field_dpp_video_poster',
			'label'         => 'Poster image',
			'name'          => 'dpp_poster',
			'type'          => 'image',
			'return_format' => 'array',
			'preview_size'  => 'medium',
			'instructions'  => 'Still frame shown before playback — the page stays fast because no video is downloaded until the visitor presses Play. Recommended 1920×1080 JPG or WebP.',
			'mime_types'    => 'jpg,jpeg,png,webp',
		),
		array(
			'key'           => 'field_dpp_source',
			'label'         => 'Video source',
			'name'          => 'dpp_source',
			'type'          => 'button_group',
			'choices'       => array(
				'file'    => 'Uploaded file',
				'youtube' => 'YouTube',
			),
			'default_value' => 'file',
			'instructions'  => 'YouTube is embedded behind a click: nothing loads from Google until the visitor presses Play, so the homepage stays fast and no third-party cookie is set on page load.',
		),
		array(
			'key'               => 'field_dpp_youtube_url',
			'label'             => 'YouTube URL',
			'name'              => 'dpp_youtube_url',
			'type'              => 'url',
			'instructions'      => 'Any normal YouTube address works — watch?v=…, youtu.be/…, /embed/… or /shorts/…',
			'conditional_logic' => array( array( array( 'field' => 'field_dpp_source', 'operator' => '==', 'value' => 'youtube' ) ) ),
		),
		array(
			'key'           => 'field_dpp_video_mp4',
			'conditional_logic' => array( array( array( 'field' => 'field_dpp_source', 'operator' => '==', 'value' => 'file' ) ) ),
			'label'         => 'Video file — MP4 (H.264)',
			'name'          => 'dpp_video_mp4',
			'type'          => 'file',
			'return_format' => 'url',
			'instructions'  => 'Primary source. H.264 / AAC MP4, 16:9, 1920×1080 or 1280×720, web-optimised (faststart). Target ≤ 15&nbsp;MB.',
			'mime_types'    => 'mp4,m4v',
		),
		array(
			'key'               => 'field_dpp_video_mp4_mobile',
			'conditional_logic' => array( array( array( 'field' => 'field_dpp_source', 'operator' => '==', 'value' => 'file' ) ) ),
			'label'             => 'Mobile video — MP4 (optional)',
			'name'              => 'dpp_video_mp4_mobile',
			'type'              => 'file',
			'return_format'     => 'url',
			'instructions'      => 'Optional lighter H.264 / AAC MP4 for screens up to 767px. Keep the same duration and captions as the main video. Recommended 640×360 or 854×480, target 2–5&nbsp;MB.',
			'mime_types'        => 'mp4,m4v',
		),
		array(
			'key'           => 'field_dpp_video_webm',
			'conditional_logic' => array( array( array( 'field' => 'field_dpp_source', 'operator' => '==', 'value' => 'file' ) ) ),
			'label'         => 'Video file — WebM (optional)',
			'name'          => 'dpp_video_webm',
			'type'          => 'file',
			'return_format' => 'url',
			'instructions'  => 'Optional VP9 / Opus WebM. Offered first to browsers that support it, for a smaller download.',
			'mime_types'    => 'webm',
		),
		array(
			'key'           => 'field_dpp_video_captions',
			'conditional_logic' => array( array( array( 'field' => 'field_dpp_source', 'operator' => '==', 'value' => 'file' ) ) ),
			'label'         => 'Captions (WebVTT)',
			'name'          => 'dpp_captions',
			'type'          => 'file',
			'return_format' => 'url',
			'instructions'  => 'Closed captions as a .vtt file. Required for accessibility (WCAG 1.2.2).',
			'mime_types'    => 'vtt',
		),
		array(
			'key'          => 'field_dpp_video_transcript',
			'label'        => 'Transcript',
			'name'         => 'dpp_transcript',
			// Deliberately a plain textarea, not a WYSIWYG. ACF initialises a
			// WYSIWYG through buildQuicktags(), which throws when the field is
			// created after page load — inserting the block crashed the editor
			// with "Cannot read properties of undefined (reading 'buttons')".
			// A transcript is plain paragraphs, so nothing is lost; blank lines
			// become paragraphs on output, and basic HTML still works.
			'type'         => 'textarea',
			'rows'         => 8,
			'new_lines'    => '',
			'instructions' => 'Full text of the video. Rendered on the page so the spoken content is crawlable and indexable. Separate paragraphs with a blank line.',
		),
		array(
			'key'           => 'field_dpp_video_cta',
			'label'         => 'Optional link below the video',
			'name'          => 'dpp_cta',
			'type'          => 'link',
			'return_format' => 'array',
			'instructions'  => 'Leave empty to hide.',
		),

		/* ------------------------------------------------------- Appearance */
		array(
			'key'       => 'field_dpp_tab_appearance',
			'label'     => 'Appearance',
			'type'      => 'tab',
			'placement' => 'top',
		),
		array(
			'key'           => 'field_dpp_bg_preset',
			'label'         => 'Section background',
			'name'          => 'dpp_bg_preset',
			'type'          => 'select',
			'choices'       => kmnd_dpp_brand_colours() + array( 'custom' => 'Custom colour…' ),
			'default_value' => '#F7F7F7',
			'ui'            => 1,
			'instructions'  => 'Brand palette. Pick “Custom colour…” to set any other value.',
		),
		array(
			'key'               => 'field_dpp_bg_custom',
			'label'             => 'Custom section background',
			'name'              => 'dpp_bg_custom',
			'type'              => 'color_picker',
			'enable_opacity'    => 1,
			'default_value'     => '#F7F7F7',
			'conditional_logic' => array( array( array( 'field' => 'field_dpp_bg_preset', 'operator' => '==', 'value' => 'custom' ) ) ),
		),
		array(
			'key'           => 'field_dpp_heading_preset',
			'label'         => 'Heading colour',
			'name'          => 'dpp_heading_preset',
			'type'          => 'select',
			'choices'       => kmnd_dpp_brand_colours() + array( 'custom' => 'Custom colour…' ),
			'default_value' => '#242331',
			'ui'            => 1,
			'instructions'  => 'Default #242331 matches every other H2 on the homepage. #15253C is the brand “Deep blue” token.',
		),
		array(
			'key'               => 'field_dpp_heading_custom',
			'label'             => 'Custom heading colour',
			'name'              => 'dpp_heading_custom',
			'type'              => 'color_picker',
			'default_value'     => '#242331',
			'conditional_logic' => array( array( array( 'field' => 'field_dpp_heading_preset', 'operator' => '==', 'value' => 'custom' ) ) ),
		),
		array(
			'key'           => 'field_dpp_heading_align',
			'label'         => 'Heading alignment',
			'name'          => 'dpp_heading_align',
			'type'          => 'button_group',
			'choices'       => array( 'left' => 'Left', 'center' => 'Centre' ),
			'default_value' => 'center',
		),
		array(
			'key'            => 'field_dpp_card_bg',
			'label'          => 'Card background',
			'name'           => 'dpp_card_bg',
			'type'           => 'color_picker',
			'enable_opacity' => 1,
			'default_value'  => '#FFFFFF',
			'instructions'   => 'The white frame around the video.',
		),
		array(
			'key'           => 'field_dpp_card_shadow',
			'label'         => 'Card drop shadow',
			'name'          => 'dpp_card_shadow',
			'type'          => 'select',
			'ui'            => 1,
			'choices'       => array(
				'figma'        => 'Figma spec — 0 0 40 10, black 10% (default)',
				'testimonials' => 'Match the live testimonial cards — 4 4 40 5, black 10%',
				'none'         => 'No shadow',
			),
			'default_value' => 'figma',
			'instructions'  => 'In Figma the video card and the testimonial card are identical. The testimonial cards currently on the site differ slightly; this option covers either interpretation.',
		),
		array(
			'key'           => 'field_dpp_card_radius',
			'label'         => 'Card corner radius (px)',
			'name'          => 'dpp_card_radius',
			'type'          => 'number',
			'default_value' => 28.8,
			'min'           => 0,
			'max'           => 80,
			'step'          => 0.1,
		),
		array(
			'key'           => 'field_dpp_media_radius',
			'label'         => 'Video corner radius (px)',
			'name'          => 'dpp_media_radius',
			'type'          => 'number',
			'default_value' => 20,
			'min'           => 0,
			'max'           => 60,
			'step'          => 1,
		),
		array(
			'key'           => 'field_dpp_aspect',
			'label'         => 'Video aspect ratio',
			'name'          => 'dpp_aspect',
			'type'          => 'select',
			'choices'       => array(
				'16 / 9' => '16:9 (default)',
				'4 / 3'  => '4:3',
				'1 / 1'  => '1:1 (square)',
				'9 / 16' => '9:16 (vertical)',
			),
			'default_value' => '16 / 9',
			'ui'            => 1,
		),
		array(
			'key'           => 'field_dpp_padding',
			'label'         => 'Section top/bottom padding (px)',
			'name'          => 'dpp_padding',
			'type'          => 'number',
			'default_value' => 100,
			'min'           => 0,
			'max'           => 240,
			'step'          => 10,
			'instructions'  => '100px keeps the block in step with the other homepage sections. Scales down automatically on tablet and mobile.',
		),

		/* ------------------------------------------------------ Play button */
		array(
			'key'       => 'field_dpp_tab_play',
			'label'     => 'Play button',
			'type'      => 'tab',
			'placement' => 'top',
		),
		array(
			'key'           => 'field_dpp_play_style',
			'label'         => 'Button style',
			'name'          => 'dpp_play_style',
			'type'          => 'button_group',
			'choices'       => array( 'default' => 'Default (Figma)', 'custom' => 'Custom image' ),
			'default_value' => 'default',
		),
		array(
			'key'               => 'field_dpp_play_color',
			'label'             => 'Button colour',
			'name'              => 'dpp_play_color',
			'type'              => 'color_picker',
			'default_value'     => '#F56612',
			'instructions'      => 'Applies to the default button. The play triangle stays white.',
			'conditional_logic' => array( array( array( 'field' => 'field_dpp_play_style', 'operator' => '==', 'value' => 'default' ) ) ),
		),
		array(
			'key'               => 'field_dpp_play_custom',
			'label'             => 'Custom button image',
			'name'              => 'dpp_play_custom',
			'type'              => 'image',
			'return_format'     => 'array',
			'preview_size'      => 'thumbnail',
			'instructions'      => 'SVG or PNG with transparency. Replaces the default button entirely.',
			'conditional_logic' => array( array( array( 'field' => 'field_dpp_play_style', 'operator' => '==', 'value' => 'custom' ) ) ),
		),
		array(
			'key'           => 'field_dpp_play_size',
			'label'         => 'Button size (% of video width)',
			'name'          => 'dpp_play_size',
			'type'          => 'range',
			'default_value' => 10.7,
			'min'           => 4,
			'max'           => 20,
			'step'          => 0.1,
			'append'        => '%',
			'instructions'  => 'Figma spec: 10.7% (≈145px on a 1351px-wide video).',
		),
		array(
			'key'           => 'field_dpp_play_offset',
			'label'         => 'Vertical position (%)',
			'name'          => 'dpp_play_offset',
			'type'          => 'range',
			'default_value' => 60,
			'min'           => 20,
			'max'           => 85,
			'step'          => 1,
			'append'        => '%',
			'instructions'  => 'Nudges the button down from the middle so it sits just below the speaker’s chin and never covers their face. Figma spec: 60%.',
		),

		/* -------------------------------------------- Accessibility and SEO */
		array(
			'key'       => 'field_dpp_tab_a11y',
			'label'     => 'Accessibility & SEO',
			'type'      => 'tab',
			'placement' => 'top',
		),
		array(
			'key'           => 'field_dpp_show_transcript',
			'label'         => 'Show transcript on the page',
			'name'          => 'dpp_show_transcript',
			'type'          => 'true_false',
			'ui'            => 1,
			'default_value' => 1,
			'instructions'  => 'Keep this on: an on-page transcript is what actually makes the caption content indexable.',
		),
		array(
			'key'               => 'field_dpp_transcript_open',
			'label'             => 'Expand the transcript by default',
			'name'              => 'dpp_transcript_open',
			'type'              => 'true_false',
			'ui'                => 1,
			'default_value'     => 0,
			'conditional_logic' => array( array( array( 'field' => 'field_dpp_show_transcript', 'operator' => '==', 'value' => '1' ) ) ),
		),
		array(
			'key'           => 'field_dpp_transcript_label',
			'label'         => 'Transcript toggle label',
			'name'          => 'dpp_transcript_label',
			'type'          => 'text',
			'default_value' => 'Read the transcript',
			'conditional_logic' => array( array( array( 'field' => 'field_dpp_show_transcript', 'operator' => '==', 'value' => '1' ) ) ),
		),
		array(
			'key'           => 'field_dpp_schema',
			'label'         => 'Output VideoObject schema',
			'name'          => 'dpp_schema',
			'type'          => 'true_false',
			'ui'            => 1,
			'default_value' => 1,
			'instructions'  => 'Structured data that lets Google read the video, its thumbnail and its transcript. Turn off only if another plugin already outputs VideoObject for this page.',
		),
		array(
			'key'           => 'field_dpp_video_label',
			'label'         => 'Accessible label for the video',
			'name'          => 'dpp_video_label',
			'type'          => 'text',
			'instructions'  => 'Read out by screen readers instead of the heading, if you want something more descriptive. Optional.',
		),
	),
	'location' => array(
		array(
			array(
				'param'    => 'block',
				'operator' => '==',
				'value'    => 'acf/dpp-video',
			),
		),
	),
	'menu_order'  => 0,
	'active'      => true,
	'description' => 'Accessible click-to-play video for the homepage (DPP).',
) );

<?php

/****Block Template ****
 *******************
 **/




$text_block = get_field('text_block');

$title = $text_block['title'];
$description = $text_block['description'];
$btn = $text_block['cta_button'];
if ($btn) {
	$btn_url = $btn['url'];
	$btn_title = $btn['title'];
	//$btn_target = $btn['target'] ?: '_self';
}

$logo_images = get_field('logo_images');
$resolved_logo_images = array();

if (!empty($logo_images)) {
	foreach ($logo_images as $key => $item) {
		$image = $item['logo'] ?? null;
		$image_url = '';
		$image_alt = '';
		$image_title = '';

		// ACF image fields can return an array, attachment ID or URL.
		if (is_array($image)) {
			$image_url = $image['url'] ?? '';
			$image_alt = $image['alt'] ?? '';
			$image_title = $image['title'] ?? '';
		} elseif (is_numeric($image)) {
			$image_id = (int) $image;
			$image_url = wp_get_attachment_image_url($image_id, 'full') ?: '';
			$image_alt = (string) get_post_meta($image_id, '_wp_attachment_image_alt', true);
			$image_title = get_the_title($image_id);
		} elseif (is_string($image)) {
			$image_url = $image;
		}

		if ($image_url) {
			$resolved_logo_images[] = array(
				'url'   => $image_url,
				'alt'   => $image_alt,
				'title' => $image_title,
				'index' => $key,
			);
		}
	}
}

$compact_logos = !empty($resolved_logo_images) && count($resolved_logo_images) <= 4;
$display_logo_images = $resolved_logo_images;

if ($compact_logos) {
	$columns = count($resolved_logo_images) === 1 ? 1 : 2;
	$items_per_cycle = $columns * 2;
	$cycle = array();

	for ($i = 0; $i < $items_per_cycle; $i++) {
		$cycle[] = $resolved_logo_images[$i % count($resolved_logo_images)];
	}

	// Two identical halves allow the track to loop without an empty interval.
	$display_logo_images = array_merge($cycle, $cycle);
}


?>


<section class="integrations<?= $compact_logos ? ' integrations--compact' : ''; ?>">
	<?php if ($compact_logos) : ?>
		<style>
			.integrations--compact .scroll-wrapp {
				width: 100%;
				height: 340px;
				overflow: hidden;
			}
			.integrations--compact .inner-container {
				position: relative;
				z-index: 0;
				margin: 0;
				max-width: none;
				display: grid;
				grid-template-columns: repeat(<?= (int) $columns; ?>, minmax(140px, 195px));
				align-items: center;
				justify-content: center;
				gap: 40px;
				animation: compactLogoLoop 16s linear infinite;
			}
			.integrations--compact .scroll img {
				animation: none !important;
				width: 100% !important;
				height: 150px !important;
				margin: 0 !important;
			}
			@keyframes compactLogoLoop {
				to { transform: translateY(calc(-50% - 20px)); }
			}
			@media (max-width: 991px) {
				.integrations--compact { padding-bottom: 70px !important; }
				.integrations--compact .scroll-wrapp { height: 324px; }
				.integrations--compact .inner-container {
					grid-template-columns: repeat(<?= (int) $columns; ?>, minmax(120px, 170px));
					gap: 24px;
				}
				@keyframes compactLogoLoop {
					to { transform: translateY(calc(-50% - 12px)); }
				}
			}
			@media (prefers-reduced-motion: reduce) {
				.integrations--compact .inner-container { animation: none; }
			}
		</style>
	<?php endif; ?>
	<div class="container integrations-container">

		<div class="content-column">
			<div class="content-wrapper">
				<h2 class="section-title"><?= $title; ?></h2>

				<p class="section-description">
					<?= $description; ?>
				</p>
				<?php if (!empty($btn_title)) { ?>
					<a <?php if(!empty($btn_url)): ?>href="<?= $btn_url; ?>" <?php endif; ?> class="cta-button primary large">
						<?= esc_html($btn_title); ?>
					</a>
				<?php } ?>
			</div>
		</div>

		<div class="image-column  scroll">



			<?php if (!empty($image)) { ?>
				<!--img src="<?= esc_url($image_url); ?>" class="integrations-image" alt="<?= esc_attr($image_alt); ?>" title="<?= esc_attr($image_title); ?>" /-->
			<?php } ?>





			<div class="scroll-wrapp">
				<div class="inner-container">
				
				
					<?php if (!empty($display_logo_images)) {
							$copies = $compact_logos ? 1 : 2;

							for ($i=0; $i<$copies; $i++){
								foreach ($display_logo_images as $image) {
									?>
									<img loading="lazy" src="<?= esc_url($image['url']); ?>" alt="<?= esc_attr($image['alt']); ?>"
										title="<?= esc_attr($image['title']); ?>" class="image-<?= esc_attr($image['index']); ?>" />

								<?php } 
								
							}	?>
					<?php } ?>
<!--
					<?php if (!empty($logo_images)) { ?>
						<?php foreach ($logo_images as $key => $item) {
							$image = $item['logo'];
							if (!empty($image)) {
								$image_url = $image["url"];
								$image_alt = $image['alt'] ?: '';
								$image_title = $image['title'] ?: '';
							}
							?>
							<img loading="lazy" src="<?= $image_url; ?>" alt="Description of image <?= $key; ?>"
								class="image-<?= $key; ?>" />

						<?php } ?>
					<?php } ?>
-->

				</div>
			</div>

		


		</div>


	</div>
</section>

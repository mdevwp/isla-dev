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

$static_logos = count($resolved_logo_images) <= 4;


?>


<section class="integrations<?= $static_logos ? ' integrations--static' : ''; ?>">
	<?php if ($static_logos) : ?>
		<style>
			.integrations--static .scroll-wrapp { width: 100%; }
			.integrations--static .inner-container {
				position: relative;
				z-index: 0;
				margin: 0;
				max-width: none;
				display: grid;
				grid-template-columns: repeat(auto-fit, minmax(140px, 195px));
				align-items: center;
				justify-content: center;
				gap: 40px;
			}
			.integrations--static .scroll img {
				animation: none !important;
				width: 100% !important;
				height: 150px !important;
				margin: 0 !important;
			}
			@media (max-width: 991px) {
				.integrations--static { padding-bottom: 70px !important; }
				.integrations--static .inner-container {
					grid-template-columns: repeat(auto-fit, minmax(120px, 170px));
					gap: 24px;
				}
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
				
				
					<?php if (!empty($resolved_logo_images)) {
							$copies = $static_logos ? 1 : 2;

							for ($i=0; $i<$copies; $i++){
								foreach ($resolved_logo_images as $image) {
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

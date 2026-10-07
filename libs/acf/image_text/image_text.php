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


?>


<section class="integrations">
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
				
				
					<?php if (!empty($logo_images)) { 

							for ($i=0; $i<2; $i++){
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

									if (!$image_url) {
										continue;
									}
									?>
									<img loading="lazy" src="<?= esc_url($image_url); ?>" alt="<?= esc_attr($image_alt); ?>"
										title="<?= esc_attr($image_title); ?>" class="image-<?= esc_attr($key); ?>" />

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

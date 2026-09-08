<?php

/****Block Template ****
*******************
**/


$txt_block = get_field('text_block');
$headline = get_field('headline');
$headline_h1 = get_field('headline_h1');

$image = get_field('image');
if(!empty($image)){
	$image_url = $image["url"];
	$image_alt = $image['alt'] ?: '';
    $image_title = $image['title'] ?: '';
}

?>


	<section class="solutions v2">
		<div class="container solutions-section">
		
			<h1 class="hero-h1">
                <?= $headline_h1; ?>
            </h1>
			<h2 class="solutions-title"><?= $headline; ?></h2>
			
			
			<?php if(!empty($image)){ ?>
				<div class="hero-image-wrapper">
				  <img src="<?= esc_url($image_url); ?>" class="solutions-image" alt="<?= esc_attr($image_alt); ?>" />
				</div>
			<?php } ?>

		</div>
	</section>
		
		
		



<?php

/****Block Template ****
*******************
**/


$txt_block = get_field('text_block');
$headline = $txt_block['headline'];
$headline_h1 = $txt_block['headline_h1'];

$subtitle = $txt_block['subtitle'];

$btn_1 = $txt_block['cta_button_1'];
if($btn_1){ 
    $btn1_url = $btn_1['url'];
    $btn1_title = $btn_1['title'];
    $btn1_target = $btn_1['target'] ?: '_self';
} 

$btn_2 = $txt_block['cta_button_2'];
if($btn_2){ 
    $btn2_url = $btn_2['url'];
    $btn2_title = $btn_2['title'];
    $btn2_target = $btn_2['target'] ?: '_self';
} 
$image = get_field('image');
if(!empty($image)){
	$image_url = $image["url"];
	$image_alt = $image['alt'] ?: '';
    $image_title = $image['title'] ?: '';
}

?>


	<section class="solutions">
		<div class="container solutions-section">
			<h1 class="hero-h1">
                <?= $headline_h1; ?>
            </h1>
			<h2 class="solutions-title"><?= $headline; ?></h2>
			<p class="solutions-description"><?= $subtitle; ?></p>
			<div class="cta-wrapper">
				<?php if(!empty($btn_1)){ ?>
				  <a href="<?= esc_url($btn1_url); ?>" class="btn book-demo-btn primary" target="<?= esc_attr($btn1_target); ?>"><?= esc_html($btn1_title); ?></a>
				<?php } ?>
				<?php if(!empty($btn_2)){ ?>
				  <a href="<?= esc_url($btn2_url); ?>" class="btn how-it-works-btn secondary" target="<?= esc_attr($btn2_target); ?>"><?= esc_html($btn2_title); ?></a>
				<?php } ?>
			</div>
			
			<?php if(!empty($image)){ ?>
				<div class="hero-image-wrapper">
				  <img src="<?= esc_url($image_url); ?>" class="solutions-image" alt="<?= esc_attr($image_alt); ?>" />
				</div>
			<?php } ?>

		</div>
	</section>
		
		
		



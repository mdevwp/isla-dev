<?php

/****Block Template ****
*******************
**/


$txt_block = get_field('text_block');
$headline = $txt_block['headline'];
$headline_h1 = $txt_block['headline_h1'];
$subtitle = $txt_block['subtitle'];
$description = $txt_block['description'];
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


    <section class="hero">

      <div class="container">
        <div class="hero-content">
          <div class="hero-text-column">
            <div class="hero-text-wrapp">

			  <h1 class="hero-h1">
                <?= $headline_h1; ?>
              </h1>
              <h2 class="hero-heading">
                <?= $headline; ?>
              </h2>

            </div>
			<?php if($subtitle){ ?>
				<p class="sub-b"><?php echo $subtitle; ?></p>
			<?php } ?>
            <p class="hero-description">
              <?php echo wp_kses_post($description); ?>
            </p>
            <div class="hero-cta-buttons">
			<?php if(!empty($btn_1)){ ?>
              <a href="<?= esc_url($btn1_url); ?>" class="btn book-demo-btn primary"><?= esc_html($btn1_title); ?></a>
			<?php } ?>
			<?php if(!empty($btn_2)){ ?>
              <a href="<?= esc_url($btn2_url); ?>" class="btn how-it-works-btn secondary"><?= esc_html($btn2_title); ?></a>
			<?php } ?>
            </div>
          </div>
          <div class="hero-image-column">
		  <?php if(!empty($image)){ ?>
            <div class="hero-image-wrapper">
              <img src="<?= esc_url($image_url); ?>" class="hero-img" alt="<?= esc_attr($image_alt); ?>" />
			</div>
		  <?php } ?>
		  
			  <div class="hero_bg_wrapp">
				<!--img src="wp-content/themes/kmnd-child/assets/images/hero_bg.svg" class="hero_img" alt="" /-->
				<!--img src="wp-content/themes/kmnd-child/assets/images/vector3.svg" class="hero_img" alt="" /-->
			  </div>  
			  
          </div>
        </div>
      </div>

    </section>
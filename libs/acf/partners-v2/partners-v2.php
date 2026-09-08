<?php

/****Block Template ****
*******************
**/



$headline = get_field('headline');
$partner_logos = get_field('partner_logos');
$grey_bg = get_field('grey_bg');
$image = get_field('image');
if(!empty($image)){
	$image_url = $image["url"];
	$image_alt = $image['alt'] ?: '';
    $image_title = $image['title'] ?: '';
}

?>


<section class="partner-logos <?php if($grey_bg):?>grey_bg<?php endif; ?>">
      <div class="container">
	  <?php if($headline){ ?>
			<h2 class="trusted-partner"><?= $headline; ?></h2>
	  <?php } ?>
	  
	  <?php if(!empty($partner_logos)){ ?>
        <div class="logo-container swiper">
          <div class="blur-overlay"></div>
          <div class="swiper-wrapper">
		  
			<?php foreach($partner_logos as $key=>$item){ ?>
				<div class="swiper-slide">
				  <img src="<?= $item['logo']['url']; ?>" class="p-logo img-<?= $key; ?>" alt="<?= esc_attr($item['logo']['alt']); ?>" title="<?= esc_attr($item['logo']['title']); ?>" />
				</div>
			<?php } ?>
		   
          </div>
          <div class="swiper-pagination"></div>
        </div>
	  <?php } ?>
      </div>
</section>
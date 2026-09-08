<?php

/****Block Template ****
*******************
**/



$event_banner = get_field('use_general_block') ? get_field('event_banner', 'option') : get_field('event_banner') ;
$date = $event_banner['date'];
$title = $event_banner['title'];
$image = $event_banner['image'];
if(!empty($image)){
	$image_url = $image["url"];
	$image_alt = $image['alt'] ?: '';
    $image_title = $image['title'] ?: '';
}
$read_more = $event_banner['read_more'];
if($read_more){ 
    $read_url = $read_more['url'];
    $read_title = $read_more['title'];
    $more_target = $read_more['target'] ?: '_self';
}

$second_title = $event_banner['second_title'];
$description = $event_banner['description'];
$btn = $event_banner['cta_button'];
$img_url = $event_banner['img_url'];
if($btn){ 
    $btn_url = $btn['url'];
    $btn_title = $btn['title'];
    $btn_target = $btn['target'] ?: '_self';
} 

?>



<div class="container webinar-container get-inspired">

  <div class="banner__wrapper">
    <div class="main-content">
      <article class="inspired">
        <div class="card-content" <?php if($read_url): ?>onclick="location.href='<?= $read_url; ?>';"<?php endif; ?>>
		
			<?php if(!empty($img_url)): ?><a href="<?= $img_url; ?>"><?php endif; ?>
		
				<img src="<?= $image_url; ?>" class=""  <?php if(!empty($image_alt)): ?>alt="<?= $image_alt; ?>"<?php endif; ?> />
			
		    <?php if(!empty($img_url)): ?></a><?php endif; ?>
		  
        </div>
      </article>
    </div>
    <div class="sidebar">
      <div class="sidebar-content">
        <h2 class="sidebar-title"><?= $second_title; ?></h2>
        <p class="sidebar-description"><?= $description; ?></p>
		<?php if(!empty($btn)){ ?>
		<a href="<?= $btn_url; ?>" class="cta__button" <?php if(!empty($btn_target)): ?>target="<?= esc_attr($btn_target); ?>"<?php endif; ?> role="button"><?= $btn_title; ?></a>
		<?php } ?>
      </div>
    </div>
  </div>

</div>

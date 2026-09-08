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
if($btn){ 
    $btn_url = $btn['url'];
    $btn_title = $btn['title'];
    $btn_target = $btn['target'] ?: '_self';
} 

?>


<div class="container">
<div class="webinar-container">

  <div class="banner__wrapper">
    <div class="main-content">
      <article class="webinar-card">
        <div class="card-content" onclick="location.href='<?= $read_url; ?>';">
          <div class="card-text">
            <div class="banner_content">
              <p class="webinar-date"><?= $date; ?></p>
              <h2 class="webinar-title"><?= $title; ?></h2>
              <div class="read-more">
                <a href="<?= $read_url; ?>" class="read-more-text"><?= $read_title; ?>
				
					<img loading="lazy" src="<?= get_stylesheet_directory_uri(); ?>/assets/images/arrow.svg" alt="" class="arrow-icon" />
				
				</a>
              </div>
            </div>
          </div>
          <div class="card-image">
            <img src="<?= $image_url; ?>" alt="Webinar illustration" class="webinar-image" />
          </div>
        </div>
      </article>
    </div>
    <div class="sidebar">
      <div class="sidebar-content">
        <h2 class="sidebar-title"><?= $second_title; ?></h2>
        <p class="sidebar-description"><?= $description; ?></p>
        <a href="<?= $btn_url; ?>" class="cta__button" role="button"><?= $btn_title; ?></a>
      </div>
    </div>
  </div>

</div>
</div>
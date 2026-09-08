<?php

 /* Template Name: 404 Page (Front) 
 */ 


get_header();

?>



<main class="kmnd-main page-404">


		

<?php

$headline = get_field('headline_404', 'option');
$description_1 = get_field('description_404', 'option' );
$message = get_field('message_404', 'option' );

$btn = get_field('cta_button_404', 'option');
if($btn){ 
    $btn_url = $btn['url'];
    $btn_title = $btn['title'];
    $btn_target = $btn['target'] ?: '_self';
}



$use_general_banner = get_field('use_general_banner_404', 'option');
$event_banner = $use_general_banner ? get_field('event_banner', 'option') : get_field('event_banner_404', 'option');

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
$btn2 = $event_banner['cta_button'];
if($btn2){ 
    $btn2_url = $btn2['url'];
    $btn2_title = $btn2['title'];
    $btn2_target = $btn2['target'] ?: '_self';
} 

?>


<section class="error-container">


  <h1 class="error-heading"><?= $headline; ?></h1>
  <div class="error-content">
    <p class="error-message"><?= $description_1; ?></p>
    <p class="error-code"><?= $message; ?></p>
    <a href="<?= $btn_url; ?>" class="home-button" tabindex="0"><?= $btn_title; ?></a>
  </div>
  
</section>
	
		
<div class="container">
<div class="webinar-container">

  <div class="banner__wrapper">
    <div class="main-content">
      <article class="webinar-card">
        <div class="card-content" onclick="location.href='<?= $read_url; ?>';">
          <div class="card-text">
            <div class="banner_content">
              <p class="webinar-date"><?= $date; ?></p>
              <h3 class="webinar-title"><?= $title; ?></h3>
              <div class="read-more">
                <a href="<?= $read_url; ?>" class="read-more-text"><?= $read_title; ?><img loading="lazy" src="<?= get_stylesheet_directory_uri(); ?>/assets/images/arrow.svg" alt="" class="arrow-icon" />
				
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
        <h3 class="sidebar-title"><?= $second_title; ?></h3>
        <p class="sidebar-description"><?= $description; ?></p>
        <a href="<?= $btn2_url; ?>" class="cta__button" role="button"><?= $btn2_title; ?></a>
      </div>
    </div>
  </div>

</div>
</div>
		
		


	</main><!-- #main -->
<?php

get_footer();
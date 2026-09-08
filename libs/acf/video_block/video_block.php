<?php

/****Block Template ****
*******************
**/



$text_block = get_field('text_block');

  
if($text_block){
	$title = $text_block['title'];
	$description = $text_block['description'];



	$btn_1 = $text_block['cta_button_1'];
	if($btn_1){ 
		$btn1_url = $btn_1['url'];
		$btn1_title = $btn_1['title'];
		$btn1_target = $btn_1['target'] ?: '_self';
	} 
	$btn_2 = $text_block['cta_button_2'];
	if($btn_2){ 
		$btn2_url = $btn_2['url'];
		$btn2_title = $btn_2['title'];
		$btn2_target = $btn_2['target'] ?: '_self';
	} 
}



$video_url = get_field('video_url');
$youtube_video = get_field('youtube_video') ?: false;
$video_file = get_field('video_file');
$videoId = getYouTubeVideoId($video_url);

$image = get_field('image');
if(!empty($image)){
	$image_url = $image["url"];
	$image_alt = $image['alt'] ?: '';
    $image_title = $image['title'] ?: '';
}

?>


	
    <section class="video-section">
      <div class="container">
        <div class="video">
		
			<?php if(!empty($image)){ ?>
				<img src="<?= esc_url($image_url); ?>" class="video__preloader video-image" alt="<?= esc_attr($image_alt); ?>" title="<?= esc_attr($image_title); ?>" <?php if($videoId): ?> data-video="<?= $videoId; ?>" <?php endif; ?>/>
				<img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/Button.png?v2" alt="preview icon" class="prev-icon" />
			<?php } ?>
			
          <div class="video__element">
		  
			<?php 
			if(!empty($video_file) && !$youtube_video){ ?>
				<video class="myVideo" controls>
					<source src="<?= $video_file; ?>" type="video/mp4">
				</video>
			<?php }
			
			if($youtube_video && !empty($videoId)){ ?>					
					<iframe src="https://www.youtube.com/embed/***?rel=0&amp;showinfo=0" width="300" height="150"
						frameborder="0" allowfullscreen="allowfullscreen"></iframe>
			<?php } ?>	
			
          </div>
        </div>
        <div class="video-content">
          
		 
			<div class="content-column">
			  <div class="content-wrapper">
				<h2 class="section-title"><?= $title; ?></h2>
				<?php if(!empty($subtitle)){ ?>
					<p class="section-subtitle"><?= $subtitle; ?></p>
				<?php } ?>
				<p class="section-description">
				  <?= $description; ?>
				</p>
				<div class="video-cta-wrapper">
				  
					<?php if(!empty($btn_1)){ ?>
					  <a href="<?= esc_url($btn1_url); ?>" class="btn cta-button primary" target="<?= esc_attr($btn1_target); ?>"><?= esc_html($btn1_title); ?></a>
					<?php } ?>
					<?php if(!empty($btn_2)){ ?>
					  <a  class="btn login-button secondary" target="<?= esc_attr($btn2_target); ?>">
						<?= esc_html($btn2_title); ?>
					  </a>
					<?php } ?>
				  
				</div>
			
			  </div>
			</div>
 
		  
        </div>
      </div>
    </section>
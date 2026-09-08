<?php

/****Block Template ****
*******************
**/



$headline = get_field('headline');
$description = get_field('description');
$bg_image = get_field('bg_image');
if(!empty($bg_image)){
	$bg_image_url = $bg_image['url'];
	$bg_image_alt = $bg_image['alt'] ?: '';
    $bg_image_title = $bg_image['title'] ?: '';
}
$image = get_field('image');
if(!empty($image)){
	$image_url = $image["url"];
	$image_alt = $image['alt'] ?: '';
    $image_title = $image['title'] ?: '';
}

$features = get_field('features');

?>

    <section class="features-section">

	  <?php if(!empty($image)){ ?>
		  <img src="<?= esc_url($bg_image_url); ?>" class="features-background" alt="<?= esc_attr($image_alt); ?>" />
	  <?php } ?>
			  
      <div class="container features-content">
        <h2 class="features-title"><?= $headline; ?></h2>
       
        <div class="features-grid">
          <div class="features-row">
				<div class="features-column">
			
			
				<p class="features-description">
					<?= $description; ?>
				</p>
		
		
					<?php if(!empty($features)){ ?>
					  <div class="feature-container">
						<div class="feature-wrapp feature-list">
						
						<?php 
								foreach($features as $key=>$item){ ?>
								  <div class="feature-item" >
									<div class="feature-card">
									  <img src="<?= $item['icon']['url']; ?>" alt="" class="feature-icon" />
									  <div class="feature-content">
										<h3 class="feature-title"><?= $item['title']; ?></h3>
										<p class="feature-description"><?= $item['description']; ?></p>
									  </div>
									</div>
								  </div>
								<?php } ?>

							</div>
						</div>
					<?php } ?>  
				</div>
           
			
				<div class="features-image-column">
				 <?php if(!empty($image)){ ?>
					  <img src="<?= esc_url($image_url); ?>" class="features-image" alt="<?= esc_attr($image_alt); ?>" />
				  <?php } ?>
				</div>
			
		   </div>
        </div>
      </div>
    </section>
	

	
	
	

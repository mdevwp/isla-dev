<?php

/****Block Template ****
*******************
**/



$text_block = get_field('text_block');
$boxes = get_field('dev_boxes');

$title = $text_block['title'];
$description = $text_block['description'];
$btn = $text_block['cta_button'];
if($btn){ 
    $btn_url = $btn['url'];
    $btn_title = $btn['title'];
    $btn_target = $btn['target'] ?: '_self';
} 
?>


<section class="excellence-section">
 <div class="container">
  <div class="txt-column">
    <div class="text-content">
      <h2 class="main-heading"><?= $title; ?></h2>
      <p class="sub-text"><?= $description; ?></p>
	  <?php if(!empty($btn)){ ?>
          <a href="<?= esc_url($btn_url); ?>" class="btn cta-button primary large" <?php if(!empty($link_target)): ?>target="<?= esc_attr($link_target); ?>"<?php endif; ?>><?= esc_html($btn_title); ?></a>
		<?php } ?>
    </div>
  </div>
  <div class="stats-column">
    <div class="stats-excellence-section">
	
      <div class="stat-card-container count_up">
	  
	  
	  
			<?php if( !empty($boxes) ){ ?>
			  <?php foreach($boxes as $key => $item){ ?>
				<?php if($key==0||$key==2){ ?>
					<div class="stat-card-row row-<?= $key; ?>">
				<?php } ?>
						 <div class="stat-card card-<?= $key; ?>">
							<div class="stat-card-number"><span class="num large-text"><?= $item['value']; ?></span><span class="highlighted-text"><?= $item['symbol']; ?></span></div>
							<p class="stat-description"><?= $item['description']; ?></p>
						</div>
				<?php if($key==1||$key==3){ ?>
					</div>
				<?php } ?>
				
			  <?php } ?>
			<?php } ?>
			
			
    </div>
	
	
	</div>
  </div>
</section>
<?php

/****Block Template ****
*******************
**/



$headline = get_field('headline');
$team_cards = get_field('team_cards');
$cta_button = get_field('cta_button');
if(!empty($cta_button)){ 
    $btn_url = $cta_button['url'];
    $btn_title = $cta_button['title'];
    $btn_target = $cta_button['target'] ?: '_self';
} 

$image = get_field('image');
if(!empty($image)){
	$image_url = $image["url"];
	$image_alt = $image['alt'] ?: '';
    $image_title = $image['title'] ?: '';
}

?>



	<section class="team-section">
			<div id="our-team" class="container">
				<h2 class="heading"><?= $headline; ?></h2>
				
				<?php if(!empty($team_cards)){ ?>
			
					<?php foreach ($team_cards as $key => $card){ 
							$last = count($team_cards)-1;
							if($key==0){ ?>
							<div class="team-container">
								<div class="team-row">
							<?php }
							
							if($key==3){?>
							
							<div class="full-width">
								<div class="team-row">
							
							<?php } ?>
							
								<div class="team-member <?php if($key>2): ?>row-2<?php endif; ?>">
									<div class="card">
										<div class="t_bg img__<?= $key; ?>">
											<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/t_bg.png" alt=""
												class="t-bg" />
											<img src="<?= $card['photo']['url']; ?>" alt=""
												class="profile-img" />
										</div>
										<div class="profile-info">
											<div class="name"><?= $card['name']; ?></div>
											<div class="title"><?= $card['info']; ?></div>
										</div>
									</div>
								</div>

						
							<?php if($key==2 || $key==$last){ ?>
								</div>
							</div>
							<?php } ?>
							
							
					<?php } 
					
					} ?>
				
					<?php if(!empty($cta_button)){ ?>
						<a href="<?= esc_url($btn_url); ?>" class="btn button call-to-action primary" <?php if(!empty($btn_target)): ?>target="<?php echo $btn_target; ?>"<?php endif; ?>>
						  <?= esc_html($btn_title); ?>
						</a>
					<?php } ?>

			</div>
		</section>
<?php

/****Block Template ****
*******************
**/



$headline = get_field('headline');
$photos = get_field('photos');
$values = get_field('values');

$image = get_field('image');
if(!empty($image)){
	$image_url = $image["url"];
	$image_alt = $image['alt'] ?: '';
    $image_title = $image['title'] ?: '';
}

?>


<section id="our-values" class="our-values">
	<div class="container">
		<div class="col-flex">
		
			<?php if(!empty($photos)){ ?>
			
					<div class="column">
						<div class="image-group">
						<?php foreach($photos as $key => $item){ 
							if($key<2){ 
						?>
							<img loading="lazy" src="<?= $item['image']['url']; ?>" alt=""
								class="image-<?= $key; ?>">

							<?php } ?>
						 <?php } ?>
						</div>
					</div>
					
					<div class="column">
						<div class="image-group-right">
						<?php foreach($photos as $key => $item){ 
							if($key>=2){ 
						?>
							<img loading="lazy" src="<?= $item['image']['url']; ?>" alt=""
								class="image-<?= $key; ?>">
							<?php } ?>
						<?php } ?>
						</div>
					</div>
				
			<?php } ?>
			
			
		</div>

		<div class="values-section">
			<h2 class="values-title"><?= $headline; ?></h2>
			<div class="values-content values-grid">

				<div class="text-column">
				
				<?php if(!empty($values)){ 
				
						foreach($values as $key => $value){ 
				?>
					<div class="value-text">
					<?php if($value['image_or_letter']=='letter' && !empty($value['letter'])){ ?>
						<div class="value-letter"><?= $value['letter']; ?></div>	
					<?php } ?>	
					<?php if($value['image_or_letter']=='image' && !empty($value['image'])){ ?>
						<div class="value-letter">
							<img loading="lazy" src="<?= $value['image']['url']; ?>" alt="" class="image-pic">
						</div>	
					<?php } ?>
						<div class="value-content">
							<h3 class="highlighted"><?= $value['title']; ?></h3>
							<p class="value-description"><?= $value['description']; ?></p>
						</div>
					</div>
				
					<?php } 
					
					} ?>

				</div>
			</div>

		</div>

	</div>
</section>
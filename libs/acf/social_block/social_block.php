<?php

/****Block Template ****
*******************
**/


$headline = get_field('headline');
$description = get_field('description');
$social_icons = get_field('social_icons');
$widget_shortcode = get_field('widget_shortcode');
$widget_code = get_field('widget_code');

$grey_bg = get_field('grey_bg');
$image = get_field('image');
if(!empty($image)){
	$image_url = $image["url"];
	$image_alt = $image['alt'] ?: '';
    $image_title = $image['title'] ?: '';
}
$bg = get_field('section_bg') ?? '#F56612';

?>
<style>
.posts-column .swiper-slide>div>div>div {
    height: 450px !important;
}
</style>

<section class="posts-slider bg__orange" style="background: <?php echo $bg; ?>">
	<div class="container content">

		<div class="flex-gap">
			<div class="text-column">
				<div class="text-container" aria-labelledby="social-title">
					<h2 id="social-title" class="social-title"><?= $headline; ?></h2>
					<p class="social-description">
						<?= $description; ?>
					</p>
					
					<?php if($social_icons){ ?>
						<div class="social-icons">
							<?php foreach($social_icons as $item){ ?>
						
							<a href="<?= $item['url']; ?>">
								<img src="<?= $item['icon']['url']; ?>" alt="" class="social-icon"/>
							</a>
						
							<?php } ?>
						</div>
					<?php } ?>
					
					
				</div>
			</div>
			<div class="posts-column">


<!--script src="https://cdn.commoninja.com/sdk/latest/commonninja.js" defer></script>
<div class="commonninja_component pid-3045e77d-c816-4e9c-9730-005273dfe3db"></div-->

<?php echo do_shortcode("$widget_shortcode"); ?>

<?php if($widget_code){ 
          echo $widget_code;
} ?>



				<div class="t-pagination"></div>

			</div>


		</div>

	</div>
</section>
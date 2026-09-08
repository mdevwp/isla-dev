<?php

/****Block Template ****
*******************
**/




$headline = get_field('headline');
$description = get_field('description');
$resource_posts = get_field('resource_posts');
$text_more = get_field('read_more_text') ?: 'More';


?>

<section class="featured-section">

	<div class="container">
	  <h1 class="featured-heading"><?= $headline; ?></h1>
	  <p class="featured-description"><?= $description; ?></p>
  
	<?php if(!empty($resource_posts)){ ?>
		
	  <div class="featured-articles">
		<div class="article-container">
		  
		
		<?php 
		
		$main_banner_post = get_field('main_banner_post');
		
		if(!empty($main_banner_post)){ 
		
			$post_id = $main_banner_post['post'];
			
			$permalink = get_field('outer_resource_url', $post_id) ?: get_permalink($post_id);
			$tags = get_the_tags($post_id);
		
		
			$image = $main_banner_post['image'];
			if(!empty($image)){
				$image_url = $image["url"];
				$image_alt = $image['alt'] ?: '';
				$image_title = $image['title'] ?: '';
			}
		
		?>
		
			<div class="column" onclick="location.href='<?= $permalink; ?>';">
			  <?php if(!empty($image_url)){ ?>
				<img loading="lazy" src="<?= esc_url($image_url); ?>" <?php if(!empty($image_alt)): ?>alt="<?= $image_alt; ?>"<?php endif; ?> <?php if(!empty($image_title)): ?>title="<?= $image_title; ?>"<?php endif; ?> />
			  <?php } ?>
			<div class="flex-item">
			  <time class="date" ><?= esc_html(get_the_date('F j, Y', $post_id)); ?></time>
			  <h2 class="flex-heading"><?= get_the_title($post_id); ?></h2>
			  <div class="read-more-container">
				<a href="<?= $permalink; ?>" class="read-more"><?= $text_more; ?></a>
				<img loading="lazy" src="<?= get_stylesheet_directory_uri(); ?>/assets/images/arrow.svg" alt="" class="arrow-icon" />
			  </div>
			</div>
			</div>
	
		 
		<?php } ?> 
		  
		  
		  
		  <div class="column-text">
			<div class="text-content">
			
			
			<?php 
			
			if(!empty($resource_posts)){ 
			
				foreach($resource_posts as $key => $post_id){ 

					$permalink = get_field('outer_resource_url', $post_id) ?: get_permalink($post_id);
					$tags = get_the_tags($post_id);
					
					$thumbnail_url = get_the_post_thumbnail_url( $post_id);
					$thumbnail_id = get_post_thumbnail_id( $post_id ); 
					if ( $thumbnail_id ) {
						$thumbnail_alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
						$thumbnail_title = isset( get_post($thumbnail_id)->post_title ) ? get_post($thumbnail_id)->post_title : '';
					}
			
			
			?>
			
					  <a href="<?= $permalink; ?>" class="text-wrapper">
						<div class="text-inner-container">
						  <div class="column-content">
							<div class="content-meta">
							  <time class="date"><?= esc_html(get_the_date('F j, Y', $post_id)); ?></time>
							  <h2 class="heading"><?= get_the_title($post_id); ?></h2>
							  <div class="read-more-container">
								<span class="read-more"><?= $text_more; ?></span>
								<img loading="lazy" src="<?= get_stylesheet_directory_uri(); ?>/assets/images/arrow.svg" alt="" class="arrow-icon" />
							  </div>
							</div>
						  </div>
						  
						  <div class="column-image">
							<img loading="lazy" class="image_prev" src="<?= esc_url($thumbnail_url); ?>" <?php if(!empty($thumbnail_alt)): ?>alt="<?= $thumbnail_alt; ?>"<?php endif; ?> <?php if(!empty($thumbnail_title)): ?>title="<?= $thumbnail_title; ?>"<?php endif; ?> />
						  </div>
						</div>
					  </a>
					  
			  <?php } ?>
			  
			  
			<?php } ?>  


			  
			</div>
		  </div>
		  
		 
		  
		</div>

	  </div> 
	  
	<?php } ?>  
	  
	  
  </div>
</section>
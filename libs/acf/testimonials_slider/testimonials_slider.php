<?php

/****Block Template ****
*******************
**/



$headline = get_field('headline');
$testimonials = get_field('testimonial_cases');

?>


<?php if(!empty($testimonials)){ ?>
    <section class="testimonials">
      <div class="container swiper_wrap">
	  
	  <?php if(!empty($headline)){ ?>
		<h2 class="healthcare-delivery"><?= $headline; ?></h2>
	  <?php } ?>
	  
	  
	  
        <div class="t-swiper swiper">
          <div class="swiper-wrapper">

			<?php foreach($testimonials as $key => $post_id){ 
			
					$thumbnail_url = get_the_post_thumbnail_url( $post_id);

					$thumbnail_id = get_post_thumbnail_id( $post_id ); 
					if ( $thumbnail_id ) {
						$thumbnail_alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
						$thumbnail_title = isset( get_post($thumbnail_id)->post_title ) ? get_post($thumbnail_id)->post_title : '';
					}
					$post_excerpt = get_the_excerpt($post_id)?: get_the_content($post_id);
					$customer_info = get_field('customer_info', $post_id);
					$case_link = get_field('case_link', $post_id);
					$large_icon = get_field('large_icon', $post_id);

					
					if($case_link){ 
						$case_url = $case_link['url'];
						$case_title = $case_link['title'];
						$case_target = $case_link['target'] ?: '_self';
					} 
			
			?>

					<div class="customer-testimonial swiper-slide item-<?= $key; ?>">
					  <div class="slide-item <?php if($large_icon): ?>large_icon<?php endif; ?>">
						<?php if(!empty($thumbnail_url)){ ?>
							<img class="customer-avatar" src="<?= esc_url($thumbnail_url); ?>" <?php if(!empty($thumbnail_alt)): ?>alt="<?= $thumbnail_alt; ?>"<?php endif; ?> <?php if(!empty($thumbnail_title)): ?>title="<?= $thumbnail_title; ?>"<?php endif; ?>>
						<?php } ?>
						<p class="testimonial-text">
						  <?= $post_excerpt; ?>
						</p>
						<div class="customer-info">
						
						
						
						  <div class="customer-details">
							<div class="customer-details-wrapper">
							  <div class="customer-name-title">
								<div class="customer-name-wrapper">
								  <span class="customer-name-text"><?= esc_html(get_the_title($post_id)); ?></span>
								  <p class="customer-title">
									<?= $customer_info; ?>
								  </p>
								</div>
							  </div>
							  <?php if(!empty($case_url)){ ?>
								  <!--div class="case-study-button">
									<a href="<?= esc_url($case_url ); ?>" class="case-study-link"><?= esc_html($case_title); ?></a>
								  </div-->
							  <?php } ?>
							</div>
						  </div>

						</div>
					  </div>
					</div>
			
			<?php } ?>
			
			

          </div>

          <div class="swiper-pagination"></div>

        </div>

        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        <div class="t-pagination"></div>


      </div>
    </section>
	
<?php } ?>
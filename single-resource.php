<?php
/**
 * The template for displaying single resource posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package komanda
 */
get_header();

$post_id = get_the_ID();

?>
	<main class="kmnd-main">


		<div class="container">
			<div class="head__breadcrumbs">
				<?php 
					if (function_exists('yoast_breadcrumb')) {
						echo '<div class="breadcrumbs">';
							yoast_breadcrumb();
						echo '</div>';
					} 
				?>
			</div>		
		</div>
		<div class="container article__wrapp">

	
	
			<div class="content">
				<div class="article-content">
					<div class="top_wrapper">
						<div class="image-container">
							<?php if ( has_post_thumbnail() ) : ?>
								<img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title_attribute(); ?>">
							<?php endif; ?>
							<?php
								$tags = get_the_tags();
								if ( ! empty( $tags ) ):
								$main_tag = $tags[0]->name;
							?>
							<div class="label">
								<?php echo esc_html( $main_tag ); ?>
							</div>
							<?php endif; ?>
						</div>
						<div class="top_article">
							<span class="date"><?php echo get_the_date(); ?></span>
							<h1 class="h3"><?php the_title(); ?></h1>
						</div>
					</div>
					
					
					<?php
					while ( have_posts() ) :

						the_post();
						the_content();
					
					endwhile; // End of the loop.
					?>
			
					<div class="divider"></div>
					
				</div>
		
			</div>


			<aside class="sidebar">
				<div class="share">
					<p><?= get_field('social_banner_title', 'option'); ?></p>
					
						
					<?php 
											
					$sharing_btns = get_field('sharing_btns', 'option');

					if ($sharing_btns) {
						$post_url = get_permalink();
						$post_title = get_the_title();

						echo '<div class="social_icons">';


						foreach ($sharing_btns as $btn) {
							
							//var_dump($btn);
							
							
							$resource = $btn['social_resource'];
							$icon = $btn['icon'];
							$icon_url = $icon['url'];
							$icon_alt = $icon['alt'];

							switch ($resource) {
								case 'fb':
									echo '<a href="https://www.facebook.com/sharer/sharer.php?u=' . urlencode($post_url) . '" target="_blank"><img src="' . esc_url($icon_url) . '" alt="' . esc_attr($icon_alt) . '"></a>';
									break;
								case 'tw':
									echo '<a href="https://twitter.com/intent/tweet?text=' . urlencode($post_title) . '&url=' . urlencode($post_url) . '" target="_blank"><img src="' . esc_url($icon_url) . '" alt="' . esc_attr($icon_alt) . '"></a>';
									break;
								case 'ln':
									echo '<a href="https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode($post_url) . '&title=' . urlencode($post_title) . '" target="_blank"><img src="' . esc_url($icon_url) . '" alt="' . esc_attr($icon_alt) . '"></a>';
									break;
							}
						}

						echo '</div>';
					}
					?>

				</div>
				
				<?php

					$show_latest = get_field('show_latest', 'option');
					if ($show_latest) {
				?>		
						<div class="latest">
							<h2><?= get_field('lp_block_title', 'option'); ?></h2>
						
						<?php

							$number_recent_posts = get_field('number_recent_posts', 'option');
							$args = array(
								'post_type' => 'resource',
								'posts_per_page' => $number_recent_posts,
								'orderby' => 'date',
								'order' => 'DESC',
							);

							$query = new WP_Query($args);
							if ($query->have_posts()) {
								echo '<ul>';
								while ($query->have_posts()) {
									$query->the_post();
									echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
								}

								echo '</ul>';
								wp_reset_postdata();
							} 
							
							?>

					
						</div>
						
					<?php }  ?>
				<h2 class="tag-label">Tags</h2>
				<div class="tags">
					
					<?php 

					$search_resource_tags =  get_acf_block_data(682, 'acf/resources-filter')['search_resource_tags'];
					
					//var_dump($search_resource_tags);
					
					if($search_resource_tags){ 
								foreach($search_resource_tags as $tag_id){ 
						  
									$tag = get_tag($tag_id, 'resource');
									if (!is_wp_error($tag) && $tag) {
						  ?>
										<a href="/resources#latest?<?= $tag_id; ?>" id="<?= $tag_id; ?>" class="article-tag <?php if($main_tag==$tag->name): ?>active<?php endif; ?>" data-page="1"><?= $tag->name; ?></a>
										
								<?php }
								} 
							} ?>
	  
	  
				</div>
			</aside>
		
			
			

    </div>



<?php if(get_field('related_posts')){ ?>

	<section class="related latest-section">

	 <div class="container">
	 
	  <h3 class="related-title"><?= get_field('title_rp'); ?></h3>


		<?php 
			
		?>
	  
		<div class="content-section">
	  
			<div class="row_columns">
		 
			<?php 
			
				if(get_field('selected_rp')){ 
					$selected = get_field('selected_rp') ?: '';
					$args = array(
						'post_type' => 'resource',
						'post_status' => 'publish',
						'posts_per_page' => 3,
						'post__in' => $selected,
					);
				}else{
					
					$tag = get_the_tags($post_id)[0]->term_taxonomy_id;
					
					//var_dump($tags);
					
					$args = array(
						'post_type' => 'resource',
						'post_status' => 'publish',
						'posts_per_page' => 3,
						'tag__in' => $tag,
					);
				}

			 
				$query = new WP_Query($args);
				
				//var_dump($query); 
				if ( $query->have_posts() ) {
					foreach ( $query->posts as $post ) {
						$post_id = $post->ID;	
						get_template_part('template-parts/resource', 'card', ['id'=> $post_id]); 
					}
				} 
				
				wp_reset_postdata();

			?>
		  
			</div>
		
		

		</div>
	  

	  
	  </div>
	</section>	
	
<?php } ?>







	</main><!-- #main -->
	

<?php 

get_footer();
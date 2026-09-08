<?php

/****Block Template ****
*******************
**/




$headline = get_field('headline');
$search_input = get_field('search_input');
$search_resource_tags = get_field('search_resource_tags');
$load_more_text = get_field('load_more_text');


?>




<section id="latest" class="latest-section">

 <div class="container">
 <div class="divider"></div>
  <h2 class="latest-title"><?= $headline; ?></h2>

<div class="tags-row">

	
	  <nav class="categories">
	  <?php if($search_resource_tags){ ?>
		  <?php foreach($search_resource_tags as $tag_id){ 
		  
					$tag = get_tag($tag_id, 'resource');
					if (!is_wp_error($tag) && $tag) {
						
						
						$tab_id =  mb_strtolower(str_replace(" ", "-", $tag->name)) ?: 'tab-' .$key_tab; 
		  ?>
						<span id="<?= $tag_id; ?>"  data-id="<?= $tab_id; ?>" class="tag nav__item" data-page="1"><?= $tag->name; ?></span>
						
					<?php }
				} ?>
	  <?php } ?>
	  </nav>
	

    <div class="search-box">
      <img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/lupa.svg" alt="" class="search-icon" />
	   <form class="search">
			<input class="key_words" type="text" placeholder="<?= $search_input; ?>" aria-label="Search keywords" />
	   </form>
    </div>

</div>



<?php 

$args = array(
    'post_type' => 'resource',
    'post_status' => 'publish',
    'posts_per_page' => 6,
    'tag__in' => $search_resource_tags,
);

//var_dump($args);

$query = new WP_Query($args);

$count_all = $query->found_posts;
$load_more = $count_all>6;

if ( $query->have_posts() ) {

	
    
?>

	<div class="content-section posts-filter">

		<?php 
		
			foreach ( $query->posts as $post ) {
				$post_id = $post->ID;	

				get_template_part('template-parts/resource', 'card', ['id'=> $post_id]); 
			
			}
	
		?>
	
	
	</div>
	
	<?php if($load_more){ ?>
		<div class="btn_wrapp">
			<a href="#" class="btn cta-button load-more primary"><?= $load_more_text; ?></a>
		</div>
	<?php } ?>
		
<?php } ?> 

  </div>
</section>	
<?php

 /* Template Name: Info Text Template
 */ 

get_header();

$post_id = get_the_ID();

?>
	<main class="kmnd-main">

		
			<div class="container article__wrapp txt-tpl">

	
	
				<div class="content">
					<div class="article-content">
		
		
		
					<?php
						while ( have_posts() ) :

							the_post();
							the_content();
						
						endwhile; // End of the loop.
					?>
		
		
				</div>
		
			</div>
		
		</div>
		
		
	</main><!-- #main -->
	

<?php 

get_footer();



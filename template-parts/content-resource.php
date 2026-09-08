<?php 

/**
 * The template for displaying all single posts Article
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package komanda
 */


	
?>

	<section class="section article__section">
		<div class="container">
		
		<?php  
		
			the_post();
			the_content();
		
		?>
		
		
		</div>
	</section>
	
	
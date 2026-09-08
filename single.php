<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package komanda
 */
get_header();

$post_id = get_the_ID();

?>
	<main class="kmnd-main">

		<?php
		while ( have_posts() ) :

				get_template_part( 'template-parts/content', get_post_type() );
		
		endwhile; // End of the loop.
		?>

	</main><!-- #main -->
	

<?php 

get_footer();
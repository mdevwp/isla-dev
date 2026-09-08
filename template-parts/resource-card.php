<?php

$post_id = $args['id'];


$post_excerpt = get_the_excerpt($post_id);
$excerpt_words = explode(' ', $post_excerpt);
if (count($excerpt_words) > 15) {
    $excerpt_words = array_slice($excerpt_words, 0, 14);
    $post_excerpt = implode(' ', $excerpt_words) . '...';
}
					
$thumbnail_url = get_the_post_thumbnail_url( $post_id);

$thumbnail_id = get_post_thumbnail_id( $post_id ); 
if ( $thumbnail_id ) {
    $thumbnail_alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
    $thumbnail_title = isset( get_post($thumbnail_id)->post_title ) ? get_post($thumbnail_id)->post_title : '';
}

//$permalink = get_permalink($post_id);
$permalink = get_field('outer_resource_url', $post_id) ?: get_permalink($post_id);


$tags = get_the_tags($post_id);



?>



	<article class="article_wrapp" onclick="location.href='<?= $permalink; ?>';">
        <div class="article">
          <div class="img_wrapper">
            <img src="<?= esc_url($thumbnail_url); ?>" <?php if(!empty($thumbnail_alt)): ?>alt="<?= $thumbnail_alt; ?>"<?php endif; ?> <?php if(!empty($thumbnail_title)): ?>title="<?= $thumbnail_title; ?>"<?php endif; ?> class="article-image" />
			<?php if($tags){ ?>
				<div class="tag_wrapp">
				<?php foreach($tags as $tag){ ?>
					<div class="article-tag"><?= esc_html($tag->name); ?></div>
				<?php }?>
				</div>
			<?php }?>
          </div>
          <div class="article-content">
            <time class="article-date"><?= esc_html(get_the_date('F j, Y', $post_id)); ?></time>
            <h2 class="article-title"><?= get_the_title($post_id); ?></h2>
            <p class="article-description"><?= esc_html($post_excerpt); ?></p>
            <a href="<?= esc_url($permalink); ?>" class="read-more">
              <span class="read-more-text">Read more</span>
              <img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/arrow.svg" alt="" class="read-more-icon" />
            </a>
          </div>
        </div>
    </article>
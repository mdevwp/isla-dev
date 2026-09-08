<?php

/****Block Template ****
*******************
**/


$headline = get_field('headline');
$quote = get_field('quote');
if(!empty($quote)){
	$quote_text = $quote['text'];
	$quote_author = $quote['author'];
}


$image = get_field('image');
if(!empty($image)){
	$image_url = $image["url"];
	$image_alt = $image['alt'] ?: '';
    $image_title = $image['title'] ?: '';
}

$logo = get_field('logo');
if(!empty($logo)){
	$logo_url = $logo["url"];
	$logo_alt = $logo['alt'] ?: '';
    $logo_title = $logo['title'] ?: '';
}

?>




<section class="blockquote bq_v1">
	<div class="container">
		<div class="image-column">
			<div class="image-wrapper">
			<?php if(!empty($logo_url)){ ?>
				<img loading="lazy"
					src="<?= $logo_url; ?>"
					class="image" alt="" />
			<?php } ?>
			</div>
		</div>
		<div class="content-column">
			<div class="b-content-wrapper">
				<h2 class="quote-heading"><?= $headline; ?></h2>
				<?php if(!empty($image_url)){ ?>
					<img loading="lazy"
						src="<?= $image_url; ?>"
						class="main-image" alt="Igniting change illustration" />
				<?php } ?>
				<?php if(!empty($quote)){ ?>
					<blockquote class="quote-wrapper">
						<p class="quote-text"><?= $quote_text; ?></p>
						<cite class="quote-author"><?= $quote_author; ?></cite>
					</blockquote>
				<?php } ?>
			</div>
		</div>
	</div>
</section>
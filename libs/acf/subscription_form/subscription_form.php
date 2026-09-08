<?php

/****Block Template ****
*******************
**/




$headline = get_field('headline');
$description = get_field('description');

$logo = get_field('logo');
if(!empty($logo)){
	$logo_url = $logo["url"];
	$logo_alt = $logo['alt'] ?: '';
    $logo_title = $logo['title'] ?: '';
}

$section_bg = get_field('section_bg');

$hubspot_form = get_field('hubspot_form');

?>


<section style="background: url(<?= $section_bg['url']; ?>);" class="cta_form">
  <div class="container content-section">
   
    <div class="inner-content">
	<?php if(!empty($logo_url)){ ?>
		<img loading="lazy" src="<?= $logo_url; ?>" <?php if(!empty($thumbnail_alt)): ?>alt="<?= $thumbnail_alt; ?>"<?php endif; ?> <?php if(!empty($thumbnail_title)): ?>title="<?= $thumbnail_title; ?>"<?php endif; ?> class="logo_img" />
	<?php } ?>
	<?php if(!empty($headline)){ ?>
      <h2 class="title"><?= $headline; ?></h2>
	<?php } ?>
	<?php if(!empty($headline)){ ?>
      <p class="description">
        <?= $description; ?>
      </p>
	<?php } ?>
      <form class="form-container">
        
		
		
		<?php if(!empty($hubspot_form)){ ?>
			<?php echo $hubspot_form; ?>
		<?php }else{ ?>
		
		<div class="form-group">
          <label for="email_input" class="visually-hidden">Enter your email</label>
          <input class="email" type="email" id="email_input" placeholder="Enter your email" aria-label="Enter your email" />
          <button type="submit" class="submit-button">Join the Isla community</button>
		</div>
		<?php } ?>
		
		  
        
      </form>
    </div>
  </div>
</section>
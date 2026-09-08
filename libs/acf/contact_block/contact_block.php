<?php

/****Block Template ****
*******************
**/




$headline = get_field('headline');
$description = get_field('description');
$location = get_field('location');
$email = get_field('email');

$hubspot_form = get_field('hubspot_form');

?>


<section class="contact-section">
	<div class="container">
	  <div class="contact-info">
		<div class="contact-content">
		  <div class="contact-text">
			<h1 class="contact-heading">
			  <?= $headline; ?>
			</h1>
			<p class="contact-description">
			  <?= $description; ?> &nbsp;<img class="str" src="/wp-content/uploads/2024/06/str.svg" />
			</p>
		  </div>
		  
		
		  
		  <div class="contact-details">
			<div class="contact-item">
			  <div class="icon-wrapper">
				<img loading="lazy" src="<?= $location['icon']['url']; ?>" class="icon" alt="<?= $location['icon']['alt']; ?>" />
			  </div>
			  <p class="contact-info-text">
			   <?= $location['text']; ?>
			  </p>
			</div>
			<div class="contact-email">
			  <div class="icon-wrapper">
				<img src="<?= $email['icon']['url']; ?>" class="icon" alt="<?= $email['icon']['url']; ?>" />
			  </div>
			  <a href="mailto:<?= $email['text']; ?>" class="email-text"><?= $email['text']; ?></a>
			</div>
		  </div>
		  

		  
		</div>
	  </div>
	  <div class="contact-image"> 
	   
			<?= $hubspot_form; ?>

	  </div>
	  
  </div>
</section>
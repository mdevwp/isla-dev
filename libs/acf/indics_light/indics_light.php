<?php

/****Block Template ****
*******************
**/


$headline = get_field('headline');
$boxes = get_field('dev_boxes');
$bg = get_field('section_bg') ?? '#F56612';

?>

 
	<section class="empowering-healthcare bg__orange" style="background: <?php echo $bg; ?>">
      <div class="container healthcare-excellence">
        <h2 class="excellence-heading"><?= $headline; ?></h2>
        <div class="specialities-container">
		
          <div class="specialities-grid count_up">
		  
			<?php if( !empty($boxes) ){ ?>
			  <?php foreach($boxes as $item){ ?>
				<div class="speciality-column">
				  <div class="speciality-card">
					<p class="speciality-number">
					  <span class="num"><?= $item['value']; ?></span><?= $item['symbol']; ?>
					</p>
					<p class="speciality-text"><?= $item['description']; ?></p>
				  </div>
				</div>
			  <?php } ?>
			<?php } ?>

          </div>

        </div>
      </div>
    </section>
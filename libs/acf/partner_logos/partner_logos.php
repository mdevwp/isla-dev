<?php

/****Block Template ****
*******************
**/


$headline = get_field('headline') ?? '';
$partner_logos = get_field('partner_logos');
$bg = get_field('section_bg') ?? '#F56612';

?>

 
	<section class="empowering-healthcare bg__orange partners_v2" style="background: <?php echo esc_attr($bg); ?>">
  <div class="container healthcare-excellence">
    <h2 class="excellence-heading"><?php echo $headline; ?></h2>

    <div class="specialities-container">
      <div class="swiper specialities-swiper">
        <div class="swiper-wrapper">
          <?php if (!empty($partner_logos )) : ?>
            <?php foreach ($partner_logos  as $item) :
              $src = isset($item['logo']['url']) ? $item['logo']['url'] : '';
              $alt = isset($item['logo']['alt']) ? $item['logo']['alt'] : 'Logo';
            ?>
              <div class="swiper-slide">
				<div class="card-container"> 
					<div class="speciality-card" >
					  <img class="logo" src="<?= esc_url($src); ?>" alt="<?= esc_attr($alt); ?>" />
					</div>
				</div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <div class="swiper-pagination"></div>

      </div>
    </div>
  </div>
</section>



<?php

/****Block Template ****
*******************
**/




$headline = get_field('headline');
$description = get_field('description');
$cta_button = get_field('cta_button');
if(!empty($cta_button)){ 
    $btn_url = $cta_button['url'];
    $btn_title = $cta_button['title'];
    $btn_target = $cta_button['target'] ?: '_self';
} 

$cards = get_field('cards');


?>


	 <section class="elevate">

      <div class="container flex-row-e">
        <h2 class="healthcare-delivery"><?= $headline; ?></h2>

        <div class="vector"></div>
			<p class="boost-productivity">
				<?= $description; ?>
			</p>


		<?php if(!empty($cta_button)){ ?>
			<a href="<?= esc_url($btn_url); ?>" class="btn button find-out-more primary large">
			  <?= esc_html($btn_title); ?>
			</a>
		<?php } ?>
		
		<?php if(!empty($cards)){ ?>
			<?php foreach($cards as $key=>$item){ 
					$k = $key + 1;
			?>
				<div class="card background-<?= $k; ?>">
				  <div class="card-inner">

					<div class="box__shadow card-front">
					  <span class="number first"></span>
					  <h3 class="txt-orange"><?= $item['title']; ?></h3>
					  <span class="txt-b"><?= $item['subtitle']; ?></span>
					</div>

					<div class="box__shadow card-back">
					  <span class="number first"></span>
					  <h3 class="txt-orange"><?= $item['title']; ?></h3>
					  <span class="txt-b"><?= $item['subtitle']; ?></span>
					  <p><?= $item['description']; ?></p>
					  <?php if(!empty($item['links'])){ 
							   $count = count($item['links'])-1;
					  ?>
							  <span class="txt-orange links">
								  <?php foreach($item['links'] as $key=>$item){ ?>
									<?php if($item['url']): ?><a href="<?= $item['url']; ?>"><?php endif; ?>
										<?= $item['title']; ?>
									<?php if($item['url']): ?></a><?php endif; ?> 
									<?php if($key < $count): ?>|<?php endif; ?>
								<?php } ?>
							  </span>
					  <?php } ?>
					</div>

				  </div>
				</div>
			<?php } ?>
		<?php } ?>
		
		

      </div>

    </section>
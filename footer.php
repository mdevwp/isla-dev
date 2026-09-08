<?php

/******Footer Front ***/


$footer_logo = get_field('footer_logo', 'option');
if(!empty($footer_logo)){
	$logo_url = $footer_logo['url'];
	$logo_alt = $footer_logo['alt'] ?: '';
    $logo_title = $footer_logo['title'] ?: '';
}
$footer_logo2 = get_field('footer_logo2', 'option');
if(!empty($footer_logo2)){
	$logo_url2 = $footer_logo2['url'];
	$logo_alt2 = $footer_logo2['alt'] ?: '';
    $logo_title2 = $footer_logo2['title'] ?: '';
}

$footer_menu = get_field('footer_menu', 'option');
$footer_social = get_field('footer_social', 'option');
$footer_text = get_field('footer_text', 'option');
$copiright_text = get_field('copiright_text', 'option');

?>

<footer class="footer">

     <div class="footer-divider"></div>

    <div class="container">

    <div class="footer-content">
      <div class="footer-columns">
        <div class="footer-column">
          <div class="footer-description">
		  <?php if(!empty($footer_logo)){ ?>
				<img src="<?= esc_url($logo_url); ?>" class="footer-logo" alt="<?= esc_attr($logo_alt); ?>" title="<?= esc_attr($logo_title); ?>" />
		  <?php } ?>
            <p class="footer-text">
				<?= $footer_text; ?>
            </p>
			<?php if( !empty($footer_social) ){ ?>
            <div class="footer-social-icons">
			<?php foreach($footer_social as $item){ ?>
              <?php if( !empty($item['url']) ): ?><a href="<?= $item['url']; ?>"><?php endif; ?>
                <img src="<?= esc_url($item['icon']['url']); ?>" class="social-icon" alt="<?= esc_attr($item['icon']['alt']); ?>" title="<?= esc_attr($item['icon']['title']); ?>"/>
              <?php if( !empty($item['url']) ): ?></a><?php endif; ?>
			<?php } ?>
            </div>
			<?php } ?>

			<?php if(!empty($footer_logo2)){ ?>
				<img src="<?= esc_url($logo_url2); ?>" class="footer-logo2" alt="<?= esc_attr($logo_alt2); ?>" title="<?= esc_attr($logo_title2); ?>" />
			<?php } ?>
          </div>
        </div>
	<?php if( !empty($footer_menu) ){ ?>

		<?php foreach($footer_menu as $column){ ?>

			<div class="footer-links-column">
			  <div class="footer-links">
				<?php if(!empty($column['label'])){ ?>
					<h3 class="footer-links-title"><?= $column['label']; ?></h3>
				<?php } ?>
				<?php if(!empty($column['menu_items'])){ ?>
				<ul class="footer-links-list">
					<?php foreach($column['menu_items'] as $item){ ?>
						<?php if( !empty($item['link']['url']) ): ?>
							<li>
								<a href="<?= esc_url($item['link']['url']); ?>">
								<?= esc_html($item['link']['title']); ?>
								</a>
							</li>
						<?php endif; ?>
					<?php } ?>
				</ul>
				<?php } ?>

			  </div>
			</div>

		  <?php } ?>


	<?php } ?>


      </div>
    </div>

	</div>
    <div class="footer-bottom-divider"></div>
	<div class="container">
		<?php if($copiright_text){ ?>
			<div class="footer-copyright"><?= $copiright_text; ?></div>
		<?php } ?>
	</div>

  </footer>

<?php wp_footer(); ?>


<div class="popup-overlay" id="popup">
    <div class="popup-content">
        <button class="close-btn" id="closePopup">&times;</button>
        <div id="hubspot-form"></div>
    </div>
</div>



</body>

</html>

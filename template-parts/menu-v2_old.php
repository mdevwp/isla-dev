<?php

/*** Menu ***/

$header_logo = get_field('header_logo', 'option');
if(!empty($header_logo)){
	
}
$image_url = !empty($header_logo["url"]) ? $header_logo["url"] : $image;

if(!empty($header_logo)){
	$logo_url = $header_logo["url"];
	$logo_alt = $header_logo['alt'] ?: '';
    $logo_title = $header_logo['title'] ?: '';
}

$header_menu = get_field('header_menu', 'option');
$light_header = get_field('light_header'); 

$menu_items = wp_get_nav_menu_items($header_menu->term_id);

$login_url = '';
$login_btn = get_field('login_button_uk', 'option');
if(!empty($login_btn)){ 
	$login_url = $login_btn['url'];
	$login_title = $login_btn['title'];
	$login_target = $login_btn['target'] ?: '_self';
}

$book_btn = get_field('book_button', 'option');
if(!empty($book_btn)){ 
    $book_url = $book_btn['url'];
    $book_title = $book_btn['title'];
    $book_target = $book_btn['target'] ?: '_self';
} 

?>


<header class="header v2">
      <div class="container">
        <div class="header__row">


		<?php if(!empty($logo_url)){ ?>
          <a href="/" class="header__logo">
            <img src="<?= esc_url($logo_url); ?>" alt="<?= esc_attr($logo_alt); ?>" title="<?= esc_attr($logo_title); ?>" class="logo-img" />
          </a>
		<?php } ?>
          <div class="nav__row">

		<?php
            if ($menu_items) {
				echo '<div class="header__menu">';
				foreach ($menu_items as $menu_item) {
					$active_class = '';
					if ($menu_item->object_id == get_queried_object_id()) {
						$active_class = ' active'; 
					}
					echo '<a class="menu-item' . $active_class . '" href="' . $menu_item->url . '">' . $menu_item->title . '</a>';
				}
				echo '</div>';
			}
		
		?>
            <div class="mobile-menu-icon">
              <div class="bar"></div>
              <div class="bar"></div>
              <div class="bar"></div>
            </div>

            <a id="track-login-click" class="btn login-btn" href="<?php echo $login_url; ?>" target="_blank"><?php echo $login_title; ?></a>
            <a class="btn book-nav-btn" href="<?= esc_url($book_url); ?>" target="<?= esc_attr($book_target); ?>"><?= esc_html($book_title); ?></a>
          </div>
        </div>
      </div>

<?php

	if( is_singular('resource') || is_page('resource-selected-page') ){

?>


	
<?php } ?>	
	
</header>
	
	
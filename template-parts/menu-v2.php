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
if (!empty($menu_items)) {
    echo '<ul class="header__menu" role="menubar">';

    foreach ($menu_items as $menu_item) {
        if ((int)$menu_item->menu_item_parent !== 0) continue; // тільки корінь

        $active = ($menu_item->object_id == get_queried_object_id()) ? ' active' : '';

        // діти поточного пункту
        $children = array_filter($menu_items, function($item) use ($menu_item) {
            return (int)$item->menu_item_parent === (int)$menu_item->ID;
        });

        $has_children = !empty($children);
        $li_classes = 'menu-item' . $active . ($has_children ? ' has-submenu' : '');

        echo '<li class="'. esc_attr($li_classes) .'" role="none">';
        //echo '<a class="menu-link" role="menuitem" href="'. esc_url($menu_item->url) .'">'. esc_html($menu_item->title) .'</a>';
		
		$target = get_field('menu_link_target', $menu_item->ID) ?: ($menu_item->target ?: '');
		$rel    = trim(($menu_item->xfn ?: '') . ($target === '_blank' ? ' noopener' : ''));

		echo '<a class="menu-link" role="menuitem" href="' . esc_url($menu_item->url) . '"'
		   . ($target ? ' target="' . esc_attr($target) . '"' : '')
		   . ($rel ? ' rel="' . esc_attr($rel) . '"' : '')
		   . '>' . esc_html($menu_item->title) . '</a>';

     
        if ($has_children) {
            echo '<span class="submenu-toggle" aria-expanded="false" aria-label="Open submenu" tabindex="0">&raquo;</span>';

            echo '<ul class="submenu" role="menu">';
            foreach ($children as $child) {
                $child_active = ($child->object_id == get_queried_object_id()) ? ' active' : '';
                echo '<li class="submenu-item'. esc_attr($child_active) .'" role="none">';
                //echo '<a class="submenu-link" role="menuitem" href="'. esc_url($child->url) .'">'. esc_html($child->title) .'</a>';
				
				$child_target = get_field('menu_link_target', $child->ID) ?: ($child->target ?: '');
				$child_rel    = trim(($child->xfn ?: '') . ($child_target === '_blank' ? ' noopener' : ''));

				echo '<a class="submenu-link" role="menuitem" href="' . esc_url($child->url) . '"'
				   . ($child_target ? ' target="' . esc_attr($child_target) . '"' : '')
				   . ($child_rel ? ' rel="' . esc_attr($child_rel) . '"' : '')
				   . '>' . esc_html($child->title) . '</a>';
   
   
                echo '</li>';
            }
            echo '</ul>';
        }

        echo '</li>';
    }

    echo '</ul>';
}
?>




            <div class="mobile-menu-icon">
              <div class="bar"></div>
              <div class="bar"></div>
              <div class="bar"></div>
            </div>

			
			<?php if ( ! empty( $book_url ) && ! empty( $book_title ) ) : ?>
				<a class="btn book-nav-btn primary"
				   href="<?= esc_url( $book_url ); ?>"
				   <?php if ( ! empty( $book_target ) ) : ?>
					   target="<?= esc_attr( $book_target ); ?>"
				   <?php endif; ?>>
					<?= esc_html( $book_title ); ?>
				</a>
			<?php endif; ?>

			<?php if ( ! empty( $login_url ) && ! empty( $login_title ) ) : ?>
				<a id="track-login-click"
				   class="btn login-btn secondary"
				   href="<?= esc_url( $login_url ); ?>"
				   target="_blank">
					<?= esc_html( $login_title ); ?>
				</a>
			<?php endif; ?>
           
          </div>
        </div>
      </div>

<?php

	if( is_singular('resource') || is_page('resource-selected-page') ){

?>


	
<?php } ?>	
	
</header>
	
	
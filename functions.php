<?php


/* $user_ip = $_SERVER['REMOTE_ADDR'];
$redirect_ip = '91.219.52.150';
if ($user_ip !== $redirect_ip) {
    header('Location: https://islahealth.komanda.dev/front/');
    exit;
} */

include('inc/gutenbergAcfFunction.php');

/* Scoped theme CSS for ACF block previews in the editor */
if ( is_readable( get_stylesheet_directory() . '/inc/block-preview-styles.php' ) ) {
	require_once get_stylesheet_directory() . '/inc/block-preview-styles.php';
}

/* ACF field styles inside the block editor canvas */
if ( is_readable( get_stylesheet_directory() . '/inc/editor-canvas-styles.php' ) ) {
	require_once get_stylesheet_directory() . '/inc/editor-canvas-styles.php';
}

/* DPP Video Section block (self-contained: libs/acf/dpp_video/) */
if ( is_readable( get_stylesheet_directory() . '/libs/acf/dpp_video/bootstrap.php' ) ) {
	require_once get_stylesheet_directory() . '/libs/acf/dpp_video/bootstrap.php';
}

add_action('wp_enqueue_scripts', 'remove_parent_theme_scripts', 99);
function remove_parent_theme_scripts() {
    remove_action('wp_enqueue_scripts', 'komanda_theme_scripts', 11);
}


add_action('wp_enqueue_scripts', 'child_theme_scripts', 99);
function child_theme_scripts() {

	$rand = rand(1,999999);
	wp_dequeue_style('komanda-style-fancybox');
    wp_deregister_style('komanda-style-fancybox');
 	wp_dequeue_style('komanda-style');
    wp_deregister_style('komanda-style');
	wp_dequeue_style('child-style');
    wp_deregister_style('child-style');
	wp_dequeue_style('child-second-style');
    wp_deregister_style('child-second-style');
	wp_deregister_script('child-main-js');
	wp_dequeue_script('child-main-js');
	wp_deregister_script('swiper-js');
	wp_dequeue_script('swiper-js');

	wp_enqueue_style('swiper-css', get_stylesheet_directory_uri() . '/assets/css/swiper.css');
	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/assets/css/style.css?12'.$rand);
	wp_enqueue_style('about-style', get_stylesheet_directory_uri() . '/assets/css/about-us.css?v=32'.$rand);
	wp_enqueue_style('solution-css', get_stylesheet_directory_uri() . '/assets/css/solution.css?v='.$rand);
	wp_enqueue_style('child-style-main', get_stylesheet_directory_uri() . '/style.css?'.$rand);
	wp_enqueue_script('swiper-script', get_stylesheet_directory_uri() . '/assets/js/swiper.js?v2', array('jquery'), false);

	wp_enqueue_script('main-js', get_stylesheet_directory_uri() . '/assets/js/main.js?v12'.$rand, array('jquery', 'swiper-script'), false);

	wp_localize_script( 'main-js', 'admin_ajax', array( 'url' => admin_url( 'admin-ajax.php' ) ) );

    wp_enqueue_script( 'hubspot-forms', '//js.hsforms.net/forms/embed/v2.js', array(), null, true );

}

add_action( 'wp_head', function () {
	echo '<script src="https://analytics.ahrefs.com/analytics.js" data-key="zDW50zyfSA8YklWUERr3Vw" async></script>' . "\n";
}, 1 );


add_action( 'after_setup_theme', 'brandcolor_palette' );

function brandcolor_palette(){
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'	=> 'Isla dark',
				'slug'	=> 'black',
				'color'	=> '#242331',
			),
			array(
				'name'  => 'light grey',
				'slug'  => 'grey',
				'color' => '#797979',
			),
			array(
				'name'  => 'Isla orange',
				'slug'  => 'orange',
				'color'	=> '#EE7324',
			),

			array(
				'name'	=> 'Cloudy grey',
				'slug'	=> 'cloudy-grey',
				'color'	=> '#EEEDEE',
			),
			array(
				'name'	=> 'Deep blue',
				'slug'	=> 'deep-blue',
				'color'	=> '#15253C',
			),
			array(
				'name'	=> 'Isla orange',
				'slug'	=> 'isla-orange',
				'color'	=> '#F47A22',
			),
			array(
				'name'	=> 'Sunshine yellow',
				'slug'	=> 'sunshine-yellow',
				'color'	=> '#F4B61E',
			),
			array(
				'name'	=> 'Nearly-white',
				'slug'	=> 'nearly-white',
				'color'	=> '#FDFDFD',
			),
			array(
				'name'	=> 'Obsidian',
				'slug'	=> 'obsidian',
				'color'	=> '#0E1215',
			)
		)
	);
}

add_theme_support(
	'editor-gradient-presets',
	array(
		array(
			'name'     => __( 'Isla gradient', 'tabor' ),
			'gradient' => 'linear-gradient(90deg, #E96126 0%, #F3851E 100%)',
			'slug'     => 'primary-to-secondary',
		),
	)
);



function get_acf_block_data($post_id, $block_name = 'acf/default-block-name'){
    $content = "";
    $post = get_post($post_id);
    if ($post && has_blocks($post->post_content) ) {
        $blocks = parse_blocks($post->post_content);
        foreach ($blocks as $block) {
            if ($block['blockName'] === $block_name) {
                if (isset($block["attrs"]["data"])) {
                    $content = $block["attrs"]["data"];
                }
            }
        }
    }
    return $content;
}

add_filter('wpseo_breadcrumb_links', 'yoast_seo_breadcrumb_links');
function yoast_seo_breadcrumb_links($links) {
    if (is_singular('resource')) {
        $breadcrumb[] = array(
            'url' => home_url('/resources/'),
            'text' => 'Resources',
        );
        array_splice($links, 1, 0, $breadcrumb);
    }

    return $links;
}

function getYouTubeVideoId($url) {
    $parts = explode('?v=', $url);
    if (count($parts) === 2) {
        $videoIdParts = explode('&', $parts[1]);
        return $videoIdParts[0];
    } else {
        return false;
    }
}

add_action("admin_menu", "remove_menus");
function remove_menus() {
	remove_menu_page("edit.php");
	remove_menu_page("edit-comments.php");
    remove_menu_page("edit.php?post_type=header");
	remove_menu_page("edit.php?post_type=footer");
}



function create_post_type_testimonials() {
    register_post_type('testimonials',
        array(
            'labels' => array(
                'name' => __( 'Testimonials' ),
                'singular_name' => __( 'Testimonial' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'testimonials'),
            'supports'  => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields', 'page-attributes', 'post-formats'),
        )
    );
}
add_action('init', 'create_post_type_testimonials');




if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> __('Theme General Settings','komanda'),
		'menu_title'	=> __('Theme Settings','komanda'),
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
        'icon_url'      => get_template_directory_uri() . '/kmnd-theme_settings/admin/assets/images/k.jpg',
		'redirect'		=> false
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> __('Theme Header Settings','komanda'),
		'menu_title'	=> __('Header','komanda'),
		'parent_slug'	=> 'theme-general-settings',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> __('Theme Footer Settings','komanda'),
		'menu_title'	=> __('Footer','komanda'),
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> __('404','komanda'),
		'menu_title'	=> __('404','komanda'),
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> __('GLOBAL Resources','komanda'),
		'menu_title'	=> __('GLOBAL Resources','komanda'),
		'parent_slug'	=> 'theme-general-settings',
	));

}



function create_resource_post_type() {
    $labels = array(
        'name'                  => _x('Resources', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Resource', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Resources', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Resource', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'add_new_item'          => __('Add New Resource', 'textdomain'),
        'new_item'              => __('New Resource', 'textdomain'),
        'edit_item'             => __('Edit Resource', 'textdomain'),
        'view_item'             => __('View Resource', 'textdomain'),
        'all_items'             => __('All Resources', 'textdomain'),
        'search_items'          => __('Search Resources', 'textdomain'),
        'parent_item_colon'     => __('Parent Resources:', 'textdomain'),
        'not_found'             => __('No resources found.', 'textdomain'),
        'not_found_in_trash'    => __('No resources found in Trash.', 'textdomain'),
        'featured_image'        => _x('Resource Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain'),
        'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'archives'              => _x('Resource archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain'),
        'insert_into_item'      => _x('Insert into resource', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain'),
        'uploaded_to_this_item' => _x('Uploaded to this resource', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain'),
        'filter_items_list'     => _x('Filter resources list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain'),
        'items_list_navigation' => _x('Resources list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain'),
        'items_list'            => _x('Resources list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'resource'),

		//'rewrite' => array('slug' => '/', 'with_front' => false),

        'capability_type'    => 'post',
        //'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields', 'page-attributes', 'post-formats'),
        'show_in_rest'       => true,  // Enable Gutenberg editor
        'taxonomies'         => array('category', 'post_tag'),  // Enable categories and tags
    );

    register_post_type('resource', $args);
}

add_action('init', 'create_resource_post_type');


function get_post_date($post_id) {
    $post_date = get_post_field('post_date', $post_id, 'raw');
    $formatted_date = date_i18n('d.m.Y', strtotime($post_date));
    return $formatted_date;
}

function my_theme_custom_upload_mimes( $existing_mimes ) {
	// Add webm to the list of mime types.
	$existing_mimes['webm'] = 'video/webm';
	// Return the array back to the function with our added mime type.
	return $existing_mimes;
}
add_filter( 'upload_mimes', 'my_theme_custom_upload_mimes' );

/******Filter Articles****************/

function filter_posts() {

	$tag_ids = isset($_POST['tag']) ? (is_array($_POST['tag']) ? array_map('intval', array_map('sanitize_text_field', $_POST['tag'])) : [intval(sanitize_text_field($_POST['tag']))]) : [];	$keywords = isset($_POST['keywords']) ? sanitize_text_field($_POST['keywords']) : '';
	$page = isset($_POST['page']) ? sanitize_text_field($_POST['page']) : 1;
	$keywords = isset($_POST['keywords']) ? sanitize_text_field($_POST['keywords']) : '';
	$count_before = isset($_POST['count']) ? sanitize_text_field($_POST['count']) : 0;



	$args = array(
		'post_type' => 'resource',
		'post_status'    => 'publish',
		'tag__in' => $tag_ids,
		's' => $keywords,
		'posts_per_page' => 6,
		'paged' => $page,
		'offset' => $count_before,
	);




	$query = new WP_Query($args);
	$count_all = $query->found_posts;
	$load_more = (intval($count_before)+6)<$count_all;

	//var_dump($args); exit;

	$articles = get_posts($args);



	$posts_data = [];
	if( !empty($articles) && is_array($articles) ){
		foreach ($articles as $post) {
				$post_id = $post->ID;

				ob_start();

				get_template_part('template-parts/resource', 'card', ['id'=> $post_id]);

				$post_html = ob_get_clean();
				$posts_data[] = $post_html;
		 }
	}

	if(empty($posts_data)){
		$posts_data = '<span class="not_found">The resource entries were not found.</span>';
	}

    wp_reset_postdata();

	wp_send_json([
        'load_more' => $load_more,
        'posts' => $posts_data
    ]);

    wp_die();
}


add_action('wp_ajax_filter_posts', 'filter_posts');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts');



function get_line_spacing_bullets() {
    $line_spacing = get_field('line_spacing_bullets', 'option');
    return $line_spacing ? $line_spacing : '15';
}

function custom_line_height_css() {
    $line_spacing = get_line_spacing_bullets();
    echo "<style>
        ul.wp-block-list li {
			margin-bottom: {$line_spacing}px!important;
			.acute_community {
				background: url(/wp-content/themes/kmnd-child/assets/images/tab_frame_bg.png);
				background-size: cover;
				background-size: 100% 2500px;
				padding-top: 540px;
				margin-top: -530px;
				background-repeat: no-repeat;
			}
        }
    </style>";
}
add_action('wp_head', 'custom_line_height_css');
add_action('admin_head', 'custom_line_height_css');


/*********** Admin Login Button Tracker**************************/
add_action('wp_ajax_track_menu_click', 'track_menu_click');
add_action('wp_ajax_nopriv_track_menu_click', 'track_menu_click');

function track_menu_click() {
    $clicks = get_option('menu_click_count', 0);
    update_option('menu_click_count', $clicks + 1);

    wp_send_json_success(['clicks' => $clicks + 1]);
}


add_action('wp_dashboard_setup', 'register_login_button_click_tracker_widget', 10);

function register_login_button_click_tracker_widget() {
    wp_add_dashboard_widget(
        'login_button_click_tracker',
        'Login Button Click Tracker',
        'display_login_button_click_tracker_widget'
    );
    global $wp_meta_boxes;
    $widget = $wp_meta_boxes['dashboard']['normal']['core']['login_button_click_tracker'];
    unset($wp_meta_boxes['dashboard']['normal']['core']['login_button_click_tracker']);
    $wp_meta_boxes['dashboard']['normal']['high']['login_button_click_tracker'] = $widget;
}

function display_login_button_click_tracker_widget() {
    $click_count = get_option('menu_click_count', 0);
    ?>
    <div id="login-button-click-tracker-widget">
        <p><strong>Number of clicks on the CTA "Login" button on Homepage:</strong></p>
        <p id="login-button-click-count" style="font-size: 20px; font-weight: bold;"><?php echo $click_count; ?></p>
        <button id="reset-login-click-counter" class="button button-primary">Reset Counter</button>
        <p id="reset-login-status" style="color: green; display: none;">Counter has been reset!</p>
    </div>
    <script type="text/javascript">
        document.getElementById('reset-login-click-counter').addEventListener('click', function() {
            const status = document.getElementById('reset-login-status');
            const countDisplay = document.getElementById('login-button-click-count');
            status.style.display = 'none';
            fetch(ajaxurl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'action=reset_menu_click_count',
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    countDisplay.textContent = data.clicks;
                    status.style.display = 'block';
                }
            });
        });
    </script>
    <?php
}

add_action('wp_ajax_reset_menu_click_count', 'reset_menu_click_count');

function reset_menu_click_count() {
    update_option('menu_click_count', 0);
    wp_send_json_success(['clicks' => 0]);
}

/********************************************/
add_action('wp_ajax_get_dynamic_login_url', 'get_dynamic_login_url');
add_action('wp_ajax_nopriv_get_dynamic_login_url', 'get_dynamic_login_url');

function get_dynamic_login_url() {
		$api_key = defined('KMND_IPINFO_API_TOKEN') ? KMND_IPINFO_API_TOKEN : '';
		if (!$api_key) {
			$login_btn = get_field('login_button_global', 'option') ?: get_field('login_button', 'option');
			wp_send_json_success(['login_btn' => $login_btn]);
		}
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$json = file_get_contents("https://ipinfo.io/{$ip_address}/json?token={$api_key}");
		$api_result = json_decode($json, true);
		$country = isset($api_result['country']) ? $api_result['country'] : '';
		if ($country === 'GB') {
			$login_btn = get_field('login_button_uk', 'option');
		} else {
			$login_btn = get_field('login_button_global', 'option') ?: get_field('login_button', 'option');
		}
		wp_send_json_success(['login_btn' => $login_btn]);
}

add_action('wp_enqueue_scripts', 'enqueue_dynamic_link_script');
function enqueue_dynamic_link_script() {
	if (is_front_page()) {
		wp_enqueue_script(
			'dynamic-login-url',
			get_stylesheet_directory_uri() . '/assets/js/dynamic-login-url.js',
			['jquery'],
			null,
			true
		);
		wp_localize_script('dynamic-login-url', 'ajax_object', [
			'ajax_url' => admin_url('admin-ajax.php')
		]);
	}
}


/**
 * WP footer hook - add custom scripts
 */
/*function hook_footer() {
    if ( is_front_page() || is_page('solutions-page') || is_page('contact')) : ?>
        <!-- BEGIN PLERDY CODE -->
        <script type="text/javascript" defer data-plerdy_code='1'>
            var _protocol = "https:" == document.location.protocol ? "https://" : "http://";
            _site_hash_code = "f6b0843a1e634289425b00aea587f904";
            _suid = 67843;
            var plerdyScript = document.createElement("script");
            plerdyScript.setAttribute("defer", "");
            plerdyScript.dataset.plerdymainscript = "plerdymainscript";
            plerdyScript.src = "https://a.plerdy.com/public/js/click/main.js?v=" + Math.random();
            var plerdymainscript = document.querySelector("[data-plerdymainscript='plerdymainscript']");
            if (plerdymainscript) plerdymainscript.parentNode.removeChild(plerdymainscript);
            try {
                document.head.appendChild(plerdyScript);
            } catch (t) {
                console.log(t, "unable add script tag");
            }
        </script>
        <!-- END PLERDY CODE -->
    <?php
    endif;
}
add_action('wp_footer','hook_footer');*/

function clarity_header() {?>
	<script type="text/javascript">
	(function(c,l,a,r,i,t,y){
	c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
	t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
	y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
	})(window, document, "clarity", "script", "xcgls19kr7");
	</script>
	<?php

}
add_action('wp_head','clarity_header');

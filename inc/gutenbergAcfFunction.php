<?php
/**
 * register acf blocks 
 * 
 * colection icons https://inverser.pro/135-dashicons
 *
 *  dashicons-slides  - > slides
 * 'icon' => slides
 * 
 */
 
 
function childKmnd_register_blocks_acf() {
    $template_path = '/libs/acf/';
    $stylesheet_path = get_stylesheet_directory_uri() . $template_path;

    if( function_exists( 'acf_register_block' ) ) {
		
        acf_register_block(array(
            'name'              => 'hero_banner',
            'title'             => __('Hero Banner'),
            'description'       => __('Hero Page Banner'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('hero', 'banner'),
            'render_template'   => $template_path . 'hero_banner/hero_banner.php',
            //'enqueue_style'     => $stylesheet_path . 'hero_banner/style.css',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		acf_register_block(array(
            'name'              => 'partner_logos',
            'title'             => __('Partner Logos Slider'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('partner', 'logo', 'slider'),
            'render_template'   => $template_path . 'partner_logos/partner_logos.php',
            //'enqueue_style'     => $stylesheet_path . 'partner_logos/style.css',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		
		acf_register_block(array(
            'name'              => 'testimonials_slider',
            'title'             => __('Testimonials Slider'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('testimonials', 'slider'),
            'render_template'   => $template_path . 'testimonials_slider/testimonials_slider.php',
            //'enqueue_style'     => $stylesheet_path . 'testimonials_slider/style.css',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		

		acf_register_block(array(
            'name'              => 'development_indicators',
            'title'             => __('Development Indicators'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('testimonials', 'slider'),
            'render_template'   => $template_path . 'development_indicators/development_indicators.php',
            //'enqueue_style'     => $stylesheet_path . 'testimonials_slider/style.css',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
            'name'              => 'elevate_block',
            'title'             => __('Elevate Block'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('testimonials', 'slider'),
            'render_template'   => $template_path . 'elevate_block/elevate_block.php',
            //'enqueue_style'     => $stylesheet_path . 'testimonials_slider/style.css',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		

		acf_register_block(array(
            'name'              => 'features_block',
            'title'             => __('Features Block'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('features', 'block'),
            'render_template'   => $template_path . 'features_block/features_block.php',
            //'enqueue_style'     => $stylesheet_path . 'testimonials_slider/style.css',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
            'name'              => 'image_text',
            'title'             => __('Image And Text Block'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('image', 'text'),
            'render_template'   => $template_path . 'image_text/image_text.php',
            //'enqueue_style'     => $stylesheet_path . 'testimonials_slider/style.css',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
            'name'              => 'video_block',
            'title'             => __('Video Block'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('video', 'text'),
            'render_template'   => $template_path . 'video_block/video_block.php',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
            'name'              => 'video_block_v2',
            'title'             => __('Video Block V2'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('video', 'text'),
            'render_template'   => $template_path . 'video_block_v2/video_block_v2.php',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        ));
		
		
		acf_register_block(array(
            'name'              => 'info_tabs',
            'title'             => __('Info Tabs Block'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('info', 'tabs'),
            'render_template'   => $template_path . 'info_tabs/info_tabs.php',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
            'name'              => 'indics_light',
            'title'             => __('Indicators (Light Version) Block'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('indicators', 'info'),
            'render_template'   => $template_path . 'indics_light/indics_light.php',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
            'name'              => 'collage_quote',
            'title'             => __('Collage Quote Block'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('collage', 'info'),
            'render_template'   => $template_path . 'collage_quote/collage_quote.php',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
            'name'              => 'collage_quote_v2',
            'title'             => __('Collage Quote V2 Block'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('collage', 'info'),
            'render_template'   => $template_path . 'collage_quote_v2/collage_quote_v2.php',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
            'name'              => 'our_values',
            'title'             => __('Our Values Block'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('values', 'info'),
            'render_template'   => $template_path . 'our_values/our_values.php',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
            'name'              => 'our_team',
            'title'             => __('Our Team Block'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('team', 'info'),
            'render_template'   => $template_path . 'our_team/our_team.php',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
            'name'              => 'social_block',
            'title'             => __('Social Block'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('social', 'info'),
            'render_template'   => $template_path . 'social_block/social_block.php',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
            'name'              => 'resources_banner',
            'title'             => __('Resources Banner (Featured)'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',  
            'keywords'          => array('posts', 'banner'),
            'render_template'   => $template_path . 'resources_banner/resources_banner.php',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [ 
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		
		acf_register_block(array(
            'name'              => 'resources_filter',
            'title'             => __('Resources Filter'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('filter', 'resource'),
            'render_template'   => $template_path . 'resources_filter/resources_filter.php',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [ 
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
            'name'              => 'subscription_form',
            'title'             => __('Subscription Form'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('subscription', 'form'),
            'render_template'   => $template_path . 'subscription_form/subscription_form.php',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [ 
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
            'name'              => 'contact_block',
            'title'             => __('Contact Block'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('subscription', 'form'),
            'render_template'   => $template_path . 'contact_block/contact_block.php',
			'enqueue_style'     => $stylesheet_path . 'contact_block/style.css?1.3',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [ 
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
            'name'              => 'banner_block',
            'title'             => __('Banner Block'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('subscription', 'form'),
            'render_template'   => $template_path . 'banner_block/banner_block.php',
			'enqueue_style'     => $stylesheet_path . 'banner_block/style.css?1.12',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [ 
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
            'name'              => 'article_divider',
            'title'             => __('Article Custom Divider'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('divider', 'separator'),
            'render_template'   => $template_path . 'article_divider/article_divider.php',
			//'enqueue_style'     => $stylesheet_path . 'banner_block/style.css?1.1',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [ 
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		
		acf_register_block(array(
            'name'              => 'solutions_hero',
            'title'             => __('Solutions Hero'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('solutions', 'hero'),
            'render_template'   => $template_path . 'solutions_hero/solutions_hero.php',
			//'enqueue_style'     => $stylesheet_path . 'banner_block/style.css?1.1',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [ 
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
            'name'              => 'acute_community',
            'title'             => __('Acute & Community Block'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('acute', 'community'),
            'render_template'   => $template_path . 'acute_community/acute_community.php',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [ 
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
            'name'              => 'solutions_hero_v2',
            'title'             => __('Solutions Hero V2'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('solutions', 'hero'),
            'render_template'   => $template_path . 'solutions_hero_v2/solutions_hero_v2.php',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [ 
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
            'name'              => 'solutions_feature',
            'title'             => __('Solutions Feature'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('acute', 'community'),
            'render_template'   => $template_path . 'solutions_feature/solutions_feature.php',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [ 
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
            'name'              => 'solutions_feature_v2',
            'title'             => __('Solutions Feature V2'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('acute', 'community'),
            'render_template'   => $template_path . 'solutions_feature_v2/solutions_feature_v2.php',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [ 
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		
		acf_register_block(array(
            'name'              => 'get_inspired',
            'title'             => __('Get inspired Block'),
            'description'       => __('Block Template'),
            'icon'              => 'welcome-widgets-menus',
            'keywords'          => array('acute', 'community'),
            'render_template'   => $template_path . 'get_inspired/get_inspired.php',
            'category'          => 'tamplate_kmnd',
            'mode'              => 'edit',
            'align'             => 'full',
            'supports'        => [ 
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ]
        )); 
		
		acf_register_block(array(
          'name'              => 'video_block_v3',
          'title'             => __('Video Block V3'),
          'description'       => __('Block Template'),
          'icon'              => 'welcome-widgets-menus',
          'keywords'          => array('video', 'block'),
          'render_template'   => $template_path . 'video_block_v3/video_block_v3.php',
          'category'          => 'tamplate_kmnd',
          'mode'              => 'edit',
          'align'             => 'full',
          'supports'        => [
            'align'           => false,
            'anchor'          => true,
            'customClassName' => true,
            'jsx'             => true,
          ]
        ));

	}
}

add_action( 'acf/init', 'childKmnd_register_blocks_acf' );

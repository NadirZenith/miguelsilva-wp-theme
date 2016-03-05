<?php
include 'nzdebug.php';
add_action('wp_enqueue_scripts', 'wordpress_bootstrap_parent_theme_enqueue_styles');

function wordpress_bootstrap_parent_theme_enqueue_styles()
{
    /* wp_enqueue_style('wordpress-bootstrap-style', get_template_directory_uri() . '/style.css'); */
    /* wp_enqueue_style('amagency-style', get_stylesheet_directory_uri() . '/style.css', array('wordpress-bootstrap-style')); */
}

function wp_bootstrap_theme_styles()
{
    // This is the compiled css file from LESS - this means you compile the LESS file locally and put it in the appropriate directory
    //  if you want to make any changes to the master bootstrap.css.
    wp_register_style('wpbs', get_stylesheet_directory_uri() . '/library/dist/css/styles.f5ae27ca.min.css', array(), '1.0', 'all');
    wp_enqueue_style('wpbs');

    // For child themes
    wp_register_style('wpbs-style', get_stylesheet_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('wpbs-style');
}

// enqueue javascript

function wp_bootstrap_theme_js()
{
    /* d('sdf'); */
    // This is the full Bootstrap js distribution file. If you only use a few components that require the js files consider loading them individually instead
    wp_register_script('bootstrap', get_template_directory_uri() . '/bower_components/bootstrap/dist/js/bootstrap.js', array('jquery'), '1.2');

    wp_register_script('wpbs-js', get_stylesheet_directory_uri() . '/library/dist/js/scripts.23dc88eb.min.js', array('bootstrap'), '1.2');
    wp_register_script('wpbs-js-dev', get_stylesheet_directory_uri() . '/library/dist/js/scripts.min.js', array('bootstrap'), '1.2');

    wp_register_script('modernizr', get_template_directory_uri() . '/bower_components/modernizer/modernizr.js', array('jquery'), '1.2');

    wp_enqueue_script('bootstrap');
    wp_enqueue_script('wpbs-js-dev');
    wp_enqueue_script('modernizr');
}

/**
 * show pages in main query
 */
function exclude_category($query)
{
    if (!$query->is_main_query() || is_admin()) {
        return;
    }
    $query->set('showposts', -1);
    $query->set('post_type', array('page'));
    $query->set('orderby', array('menu_order' => 'ASC'));
    /* $query->set('order', 'ASC'); */
    /* dd($query); */
}
add_action('pre_get_posts', 'exclude_category');



/*
 * widget
 */

// Sidebars & Widgetizes Areas
function nzwp_bootstrap_register_sidebars()
{

    register_sidebar(array(
        'id' => 'sidebar2',
        'name' => 'Homepage Sidebar',
        'description' => 'Used only on the homepage page template.',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widgettitle">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'id' => 'smaller',
        'name' => 'Smaller Footer',
        'before_widget' => '<div id="%1$s" class="widget col-xs-12 col-lg-4 %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widgettitle">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'id' => 'bigger',
        'name' => 'Bigger Footer',
        'before_widget' => '<div id="%1$s" class="widget col-lg-7 %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widgettitle">',
        'after_title' => '</h4>',
    ));
}
// don't remove this bracket!
add_action('widgets_init', 'nzwp_bootstrap_register_sidebars');
/* add_action('after_setup_theme', 'nzwp_bootstrap_register_sidebars'); */

/*
 * theme settings
 */

function nzbs_theme_settings_page()
{
    ?>
    <div class="wrap">
        <h1>Theme Panel</h1>
        <form method="post" action="options.php" enctype='multipart/form-data'>
            <?php
            settings_fields("section");
            do_settings_sections("theme-options");
            submit_button();
            ?>          
        </form>
    </div>
    <?php
}

function display_twitter_element()
{
    ?>
    <input type="text" name="twitter_url" id="twitter_url" value="<?php echo get_option('twitter_url'); ?>" />
    <?php
}

function display_facebook_element()
{
    ?>
    <input type="text" name="facebook_url" id="facebook_url" value="<?php echo get_option('facebook_url'); ?>" />
    <?php
}

function display_layout_element()
{
    ?>
    <input type="checkbox" name="theme_layout" value="1" <?php checked(1, get_option('theme_layout'), true); ?> /> 
    <?php
}

function nzbs_img_display($option_key)
{
    if (!empty(get_option($option_key))) {
        echo sprintf('<img src="%s" width="150px" />', get_option($option_key));
    }
    echo sprintf('<input type="file" name="%s"/>', $option_key);
}

function nzbs_img_upload($option_key)
{

    if (!empty($_FILES[$option_key]['name'])) {
        $urls = wp_handle_upload($_FILES[$option_key], array(
            'test_form' => FALSE,
            'mimes' => array(
                'svg' => 'image/svg+xml',
                'png' => 'image/png',
            )
        ));
        $temp = $urls["url"];
        return $temp;
    }

    return get_option($option_key);
}

function logo_display()
{
    nzbs_img_display('logo');
}

function handle_logo_upload()
{
    return nzbs_img_upload('logo');
}

function normal_img_display()
{
    nzbs_img_display('normal_img');
}

function handle_normal_img_upload()
{
    return nzbs_img_upload('normal_img');
}

function twist_img_display()
{
    nzbs_img_display('twist_img');
}

function handle_twist_img_upload()
{
    return nzbs_img_upload('twist_img');
}

function display_theme_panel_fields()
{
    add_settings_section("section", "All Settings", null, "theme-options");

    add_settings_field("twitter_url", "Twitter Profile Url", "display_twitter_element", "theme-options", "section");
    add_settings_field("facebook_url", "Facebook Profile Url", "display_facebook_element", "theme-options", "section");
    add_settings_field("theme_layout", "Do you want the layout to be responsive?", "display_layout_element", "theme-options", "section");
    add_settings_field("logo", "Logo", "logo_display", "theme-options", "section");
    add_settings_field("normal_img", "Normal Img", "normal_img_display", "theme-options", "section");
    add_settings_field("twist_img", "Twist Img", "twist_img_display", "theme-options", "section");

    register_setting("section", "twitter_url");
    register_setting("section", "facebook_url");
    register_setting("section", "theme_layout");
    register_setting("section", "logo", "handle_logo_upload");
    register_setting("section", "normal_img", "handle_normal_img_upload");
    register_setting("section", "twist_img", "handle_twist_img_upload");
}
add_action("admin_init", "display_theme_panel_fields");

function add_theme_menu_item()
{
    add_menu_page("Theme Panel", "Theme Panel", "manage_options", "theme-panel", "nzbs_theme_settings_page", null, 99);
}
add_action("admin_menu", "add_theme_menu_item");

/*
 * Post types
 */

function event_init()
{
    register_post_type('event', array(
        'labels' => array(
            'name' => __('Events', 'YOUR-TEXTDOMAIN'),
            'singular_name' => __('Event', 'YOUR-TEXTDOMAIN'),
            'all_items' => __('All Events', 'YOUR-TEXTDOMAIN'),
            'new_item' => __('New event', 'YOUR-TEXTDOMAIN'),
            'add_new' => __('Add New', 'YOUR-TEXTDOMAIN'),
            'add_new_item' => __('Add New event', 'YOUR-TEXTDOMAIN'),
            'edit_item' => __('Edit event', 'YOUR-TEXTDOMAIN'),
            'view_item' => __('View event', 'YOUR-TEXTDOMAIN'),
            'search_items' => __('Search events', 'YOUR-TEXTDOMAIN'),
            'not_found' => __('No events found', 'YOUR-TEXTDOMAIN'),
            'not_found_in_trash' => __('No events found in trash', 'YOUR-TEXTDOMAIN'),
            'parent_item_colon' => __('Parent event', 'YOUR-TEXTDOMAIN'),
            'menu_name' => __('Events', 'YOUR-TEXTDOMAIN'),
        ),
        'public' => FALSE,
        'hierarchical' => false,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'supports' => array('title', 'editor'),
        'has_archive' => true,
        'rewrite' => true,
        'query_var' => true,
        'menu_icon' => 'dashicons-admin-post',
    ));
}
add_action('init', 'event_init');

function event_updated_messages($messages)
{
    global $post;

    $permalink = get_permalink($post);

    $messages['event'] = array(
        0 => '', // Unused. Messages start at index 1.
        1 => sprintf(__('Event updated. <a target="_blank" href="%s">View event</a>', 'YOUR-TEXTDOMAIN'), esc_url($permalink)),
        2 => __('Custom field updated.', 'YOUR-TEXTDOMAIN'),
        3 => __('Custom field deleted.', 'YOUR-TEXTDOMAIN'),
        4 => __('Event updated.', 'YOUR-TEXTDOMAIN'),
        /* translators: %s: date and time of the revision */
        5 => isset($_GET['revision']) ? sprintf(__('Event restored to revision from %s', 'YOUR-TEXTDOMAIN'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
        6 => sprintf(__('Event published. <a href="%s">View event</a>', 'YOUR-TEXTDOMAIN'), esc_url($permalink)),
        7 => __('Event saved.', 'YOUR-TEXTDOMAIN'),
        8 => sprintf(__('Event submitted. <a target="_blank" href="%s">Preview event</a>', 'YOUR-TEXTDOMAIN'), esc_url(add_query_arg('preview', 'true', $permalink))),
        9 => sprintf(__('Event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview event</a>', 'YOUR-TEXTDOMAIN'),
            // translators: Publish box date format, see http://php.net/date
            date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url($permalink)),
        10 => sprintf(__('Event draft updated. <a target="_blank" href="%s">Preview event</a>', 'YOUR-TEXTDOMAIN'), esc_url(add_query_arg('preview', 'true', $permalink))),
    );

    return $messages;
}
add_filter('post_updated_messages', 'event_updated_messages');

if (function_exists("register_field_group")) {
    register_field_group(array(
        'id' => 'acf_event',
        'title' => 'event',
        'fields' => array(
            array(
                'key' => 'field_56d974b4b278b',
                'label' => 'date',
                'name' => 'date',
                'type' => 'date_picker',
                'date_format' => 'yymmdd',
                'display_format' => 'dd/mm/yy',
                'first_day' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'event',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array(
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array(
                0 => 'permalink',
                1 => 'the_content',
                2 => 'excerpt',
                3 => 'custom_fields',
                4 => 'discussion',
                5 => 'comments',
                6 => 'revisions',
                7 => 'slug',
                8 => 'author',
                9 => 'format',
                10 => 'featured_image',
                11 => 'categories',
                12 => 'tags',
                13 => 'send-trackbacks',
            ),
        ),
        'menu_order' => 0,
    ));
}

add_shortcode('app_events_table', 'app_events_table');

function app_events_table($options, $content)
{

    include locate_template(['app_events_table.php']);
}

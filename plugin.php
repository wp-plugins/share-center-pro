<?php
/*
	Plugin Name: Share Center Pro
	Plugin URI: http://bit51.com/software/share-center-pro/
	Description: Add common social sharing services in a widget to be used anywhere on your page or at the bottom of your posts or other content.
	Version: 1.1
	Text Domain: share-center-pro
	Domain Path: /languages
	Author: Bit51.com
	Author URI: http://bit51.com
	License: GPLv2
	Copyright 2011  Bit51.com  (email : chris@bit51.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU tweaks Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU tweaks Public License for more details.

	You should have received a copy of the GNU tweaks Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//Register Options
function SSP_options_init() { 
	register_setting('SSP_options', 'SSP_options');
}

//add options
add_action('admin_init', 'SSP_options_init');
	
/**
  * Validate the input
  * @return Array
  **/
function ssp_valid_input($input) {
	return $intput;
}

/**
 * Adds the admin menu pages
 * @return null 
 */
function SSP_admin_menu() {
	add_options_page('Share Center Pro',  __('Share Center Pro','share-center-pro'), 'manage_options',  'share-center-pro', 'SSP_admin');
}

/**
 * Define the admin options page
 * @return null 
 */
function SSP_admin() {
	include(trailingslashit(WP_PLUGIN_DIR) . 'share-center-pro/admin.php');
}

//load admin menu
add_action('admin_menu', 'SSP_admin_menu');

/**
 * Defines the plugin action link to appear on the plugin menu
 *
 * @param link array
 * @param file array
 * @return link array
 */
function SSP_plugin_action_links($links, $file) {
	static $this_plugin;
			
	if (!$this_plugin ) { //make sure plugin is active
		$this_plugin = plugin_basename(__FILE__);
	 }
	 
	if ($file == $this_plugin) { //if plugin is active add a link
		$settings_link = '<a href="/wp-admin/admin.php?page=share-center-pro">' . __('Settings', 'share-center-pro') . '</a>';
		array_unshift($links, $settings_link);
	}
	
	return $links;
}

//Add filter for options choice on plugin page
add_filter('plugin_action_links','SSP_plugin_action_links', 10, 2 );

/**
  * activate translations
  * @return null
  */
function SSP_languages() {
	if ( function_exists('load_plugin_textdomain') ) {
		if ( !defined('WP_PLUGIN_DIR') ) {
			load_plugin_textdomain('share-center-pro', str_replace( ABSPATH, '', dirname(__FILE__) ) . '/languages');
		} else {
			load_plugin_textdomain('share-center-pro', false, dirname( plugin_basename(__FILE__) ) . '/languages');
		}
	}
}

//load languages
add_action('init', 'SSP_languages');

/**
  * Load required scripts in the footer
  * @return null
  */
function SSP_footer_scripts() {
	global $sspWidget;

	//Retrieve Share Center Pro Options
	$SSP_options = get_option('SSP_options');
	
	//Define the scripts
	$diggScript = "<script type=\"text/javascript\" src=\"http://widgets.digg.com/buttons.js\"></script>\n";
	$fbScript = "<script src=\"http://connect.facebook.net/en_US/all.js#xfbml=1\"></script>\n";
	$gpScript = "<script type=\"text/javascript\" src=\"https://apis.google.com/js/plusone.js\"></script>\n";
	$liScript = "<script type=\"text/javascript\" src=\"http://platform.linkedin.com/in.js\"></script>\n";
	//$twitterScript = "<script type=\"text/javascript\" src=\"http://platform.twitter.com/widgets.js\"></script>\n";
	
	//Only load scripts where necessary
	if ($sspWidget || (is_archive() && $SSP_options['show_archive'] == 1) || (is_page() && $SSP_options['show_page'] == 1) || (is_front_page() && $SSP_options['show_front'] == 1) || (is_home() && $SSP_options['show_home'] == 1) || (is_search() &&  $SSP_options['show_search'] == 1) || (is_single() && $SSP_options['show_single'] == 1)) {
		echo "\n<!--## Begin Share Center Pro Scripts ## -->\n";	
		if ($SSP_options['show_digg'] == 1) {
			echo $diggScript;
		}
		if ($SSP_options['show_facebook'] == 1) {
			echo $fbScript;
		}
		if ($SSP_options['show_google'] == 1) {
			echo $gpScript;
		}	
		if ($SSP_options['show_linkedin'] == 1) {
			echo $liScript;
		}	
		if ($SSP_options['show_twitter'] == 1) {
			echo $twitterScript;
		}
		echo "<!--## End Share Center Pro Scripts ## -->\n";	
	}
}

//Register footer scripts
add_action('wp_footer', 'SSP_footer_scripts');

/**
  * Add social buttons in standard content (posts, pages, etc)
  * @return null
  **/
function SSP_social_buttons() {

	//Retrieve Share Center Pro Options
	$SSP_options = get_option('SSP_options');
	
	//Get the URLs
	$full_url = urlencode(get_permalink($post->ID));
	
	//get the twitter username
	$twitteruser = stripslashes ($SSP_options['twitter_user']);

	//initialize the buttons
	$buttons = '';
	
	$buttons .= "\n<!--## Begin Share Center Pro Scripts ## -->\n";	
	$buttons .= "<div class=\"sspcleartop\"></div>\n";
	$buttons .= "<ul id=\"share-center-pro\">\n";
	if (strlen($SSP_options['heading']) > 1) {
		$buttons .= "<h2 id=\"sspHeading\">" . $SSP_options['heading'] . "</h2>\n";
	}
	if ($SSP_options['show_digg'] == 1) {
		$buttons .= "<li id=\"sspDigg\"><a class=\"DiggThisButton DiggMedium\"></a></li>\n";
	}
	if ($SSP_options['show_facebook'] == 1) {
		$buttons .= "<li id=\"sspFacebook\"><fb:like href=\"" . $full_url . "\" send=\"false\" layout=\"box_count\" width=\"\" show_faces=\"false\" font=\"arial\"></fb:like></li>\n";
	}
	if ($SSP_options['show_google'] == 1) {
		$buttons .= "<li id=\"sspGp\"><g:plusone size=\"tall\"></g:plusone></li>\n";
	}	
	if ($SSP_options['show_linkedin'] == 1) {
		$buttons .= "<li id=\"sspLi\"><script type=\"in/share\" data-counter=\"top\"></script></li>\n";
	}	
	if ($SSP_options['show_su'] == 1) {
		$buttons .= "<li id=\"sspSu\"><script src=\"http://www.stumbleupon.com/hostedbadge.php?s=5\"></script></li>\n";
	}	
	if ($SSP_options['show_twitter'] == 1) {
		$buttons .= "<script type=\"text/javascript\" src=\"http://platform.twitter.com/widgets.js\"></script>\n";
		$buttons .= "<li id=\"sspTwitter\"><a href=\"http://twitter.com/share\" class=\"twitter-share-button\"  data-url=\"" . get_permalink() . "\" data-counturl=\"" . get_permalink() . "\" data-text=\"" . get_the_title() . "\" data-count=\"vertical\" data-via=\"" . $twitteruser . "\">Tweet</a></li>\n";
	}
	$buttons .= "</ul>\n";
	$buttons .= "<div class=\"sspclear\"></div>\n";
	$buttons .= "<!--## End Share Center Pro Scripts ## -->\n";	
	
	return $buttons;
}

/**
  * Create the filter to add buttons to content
  * @return Object
  * @param Object
  **/
function SSP_buttons_in_content($content) {
	//Retrieve Share Center Pro Options
	$SSP_options = get_option('SSP_options');
	
	if ((is_archive() && $SSP_options['show_archive'] == 1) || (is_page() && $SSP_options['show_page'] == 1) || (is_front_page() && $SSP_options['show_front'] == 1) || (is_home() && $SSP_options['show_home'] == 1) || (is_search() &&  $SSP_options['show_search'] == 1) || (is_single() && $SSP_options['show_single'] == 1)) {
		return $content . SSP_social_buttons();
	} else {
		return $content;
	}
}

//Apply the content buttons filter
add_filter('the_content', 'SSP_buttons_in_content', 25);

//Add buttons to a widget
class SSP_Widget extends WP_Widget {
	function SSP_Widget() {
		$widget_ops = array('classname' => 'SSP_Widget', 'description' => 'A widget for social sharing using the Share Center Pro Settings' );
		$this->WP_Widget('SSP_Widget', 'Share Center Pro', $widget_ops);
	}
	
	function widget($args, $instance) {
		global $sspWidget;
		$sspWidget = true;
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		echo SSP_social_buttons();
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'entry_title' => '', 'comments_title' => '' ) );
		$title = strip_tags($instance['title']);
		$entry_title = strip_tags($instance['entry_title']);
		$comments_title = strip_tags($instance['comments_title']);
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
			<p><?php _e('For more configuration visit the ','share-center-pro'); ?><a href="/wp-admin/admin.php?page=share-center-pro"><?php _e('Options','share-center-pro'); ?></a><?php _e(' page.','share-center-pro'); ?></p>
<?php
	}
}



/**
  * Load the widget
  * @return Null
  **/
function ssp_load_widget() {
	register_widget( 'SSP_Widget' );
}

//register the widget
add_action( 'widgets_init', 'ssp_load_widget' );

/**
   * Create a thumbnail for facebook links
   * @return null
   **/
function ssp_fb_thumbnail() {
	global $posts;
	
	$SSP_options = get_option('SSP_options');
	
	$content = $posts[0]->post_content; 
	$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
	if ( $output > 0 )
		$thumbnail = $matches[1][0];
	else
		$thumbnail = '';

	if ($SSP_options['show_facebook'] == 1) {
		echo "<!--## Begin Share Center Pro Scripts ## -->\n" .
			"<meta property=\"og:title\" content=\"" . get_the_title($post->ID) . "\"/>\n" .
			"<meta property=\"og:type\" content=\"article\"/>\n" .
			"<meta property=\"og:url\" content=\"" . get_permalink($post->ID) . "\"/>\n" .
			"<meta property=\"og:image\" content=\"http://" . $thumbnail . "\"/>\n" .
			"<meta property=\"og:site_name\" content=\"" . get_bloginfo() . "\"/>\n" .
			"<meta property=\"og:author\" content=\"" . get_the_author() . "\" />\n" . 
			"<meta property=\"og:description\"content=\"" . get_bloginfo('description') . "\"/>\n" .
			"<!--## End Share Center Pro Scripts ## -->\n";	
	}
}

//Add facebook thumbnail to header
add_action( 'wp_head', 'ssp_fb_thumbnail' );

/**
  * Enqueue style sheet
  * @return null
  **/
function ssp_add_stylesheet() {
	wp_register_style('share-center-pro', WP_PLUGIN_URL . '/share-center-pro/style.css');
	wp_enqueue_style( 'share-center-pro');
}

//Register the stylesheet
add_action('wp_print_styles', 'ssp_add_stylesheet');

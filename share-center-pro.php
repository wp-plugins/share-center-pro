<?php
/*
	Plugin Name: Share Center Pro
	Plugin URI: http://bit51.com/software/share-center-pro/
	Description: Add common social sharing services in a widget to be used anywhere on your page or at the bottom of your posts or other content.
	Version: Dev
	Text Domain: share-center-pro
	Domain Path: /languages
	Author: Bit51.com
	Author URI: http://bit51.com
	License: GPLv2
	Copyright 2012  Bit51.com  (email : info@bit51.com)
*/


//Require common Bit51 library
require_once( plugin_dir_path( __FILE__ ) . 'lib/bit51/bit51.php' );

if ( ! class_exists( 'bit51_scp' )) {

	class bit51_scp extends Bit51 {
	
		public $pluginversion 	= '0002'; //current plugin version
	
		//important plugin information
		public $hook 			= 'share-center-pro';
		public $pluginbase		= 'share-center-pro/share-center-pro.php';
		public $pluginname		= 'Share Center Pro';
		public $homepage		= 'http://bit51.com/software/share-center-pro/';
		public $supportpage 	= 'http://wordpress.org/support/plugin/share-center-pro';
		public $wppage 			= 'http://wordpress.org/extend/plugins/share-center-pro/';
		public $accesslvl		= 'manage_options';
		public $paypalcode		= 'QKDGZFLN3QG68';
		public $plugindata 		= 'bit51_scp_data';
		public $primarysettings	= 'bit51_scp';
		public $settings		= array(
			'bit51_scp_options' 	=> array(
				'bit51_scp' 			=> array(
					'callback' 				=> 'scp_val_options',
					'header' 				=> '',
					'digg' 					=> '0',
					'facebook' 				=> '0',
					'google' 				=> '0',
					'linkedin' 				=> '0',
					'twitter'				=> '0',
					'buffer'				=> '0',
					'archive'				=> '0',
					'page'					=> '0',
					'front'					=> '0',
					'home'					=> '0',
					'search'				=> '0',
					'single'				=> '0',
					'twitteruser'			=> ''
				)
			)
		);

		function __construct() {

			global $scpoptions, $scpdata;
		
			//set path information
			
			if ( ! defined( 'SCP_PP' ) ) {
				define( 'SCP_PP', plugin_dir_path( __FILE__ ) );
			}
			
			if ( ! defined( 'SCP_PU' ) ) {
				define( 'SCP_PU', plugin_dir_url( $this->pluginbase, __FILE__ ) );
			}
		
			//require admin page
			require_once( plugin_dir_path( __FILE__ ) . 'inc/admin.php' );
			new scp_admin( $this );
			
			//require setup information
			require_once( plugin_dir_path( __FILE__ ) . 'inc/setup.php' );
			register_activation_hook( __FILE__, array( 'scp_setup', 'on_activate' ) );
			register_deactivation_hook( __FILE__, array( 'scp_setup', 'on_deactivate' ) );
			register_uninstall_hook( __FILE__, array( 'scp_setup', 'on_uninstall' ) );

			$scpoptions = get_option( $this->primarysettings );
			$scpdata = get_option( $this->plugindata );
			
			if ( $scpdata['version'] != $this->pluginversion  || get_option( 'scpoptions' ) != false ) {
				new scp_setup( 'activate' );
			}

			//require widget info
			require_once( plugin_dir_path( __FILE__ ) . 'inc/widget.php' );

			//register the widget
			add_action( 'widgets_init', array( &$this, 'scp_loadwidget' ) );

			//Enqueue javascripts
			add_action( 'wp_enqueue_scripts', array( &$this, 'scp_footerscripts' ) );

			//add to button output to content that isn't a widget
			add_filter( 'the_content', array( &$this, 'scp_addtocontent' ), 25 );

			//Enqueue the stylesheet
			add_action( 'wp_print_styles', array( &$this, 'scp_addstylesheet' ) );

			//Add facebook thumbnail to header
			add_action( 'wp_head', array( &$this, 'scp_addfbmeta' ) );

		}

		/**
		  * Add the facebook META data to the head
		  *
		  * @return null
		  **/
		function scp_addfbmeta() {
			
			global $scpoptions, $posts, $post;
			

			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );

			if ( is_array( $thumbnail ) && strlen( $thumbnail[0] ) > 1 ) {

				$thumbnail = $thumbnail[0];

			} else {

				//get a thumbnail
				$content = $posts[0]->post_content; 
				
				$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches );

				if ( $output > 0 ) {
					$thumbnail = $matches[1][0];
				} else {
					$thumbnail = '';
				}

			}

			//only add if FB is active and it is a signle or page

			if ( $scpoptions['facebook'] == 1 && ( is_single() || is_page() ) ) {
				
				echo "<!--## Begin Share Center Pro Scripts ## -->\n" .
					"<meta property=\"og:title\" content=\"" . get_the_title( $post->ID ) . "\"/>\n" .
					"<meta property=\"og:type\" content=\"article\"/>\n" .
					"<meta property=\"og:url\" content=\"" . get_permalink( $post->ID ) . "\"/>\n";
					
				if ( strlen( $thumbnail ) > 1 ) { //only display thumbnail if an image is used
					echo "<meta property=\"og:image\" content=\"http://" . $thumbnail . "\"/>\n";
				}

				echo "<meta property=\"og:site_name\" content=\"" . get_bloginfo() . "\"/>\n";
				
				if ( strlen( get_the_author() > 1 ) ) { //only display author if needed
					echo "<meta property=\"og:author\" content=\"" . get_the_author() . "\" />\n";
				}
				
				echo "<meta property=\"og:description\" content=\"" . get_bloginfo( 'description' ) . "\"/>\n" .
					"<!--## End Share Center Pro Scripts ## -->\n";	

			}

		}

		/**
		 * Enqueue style sheet
		 *
		 * @return null
		 **/
		function scp_addstylesheet() {

			wp_register_style( 'share-center-pro', SCP_PU . 'inc/style.css' );
			wp_enqueue_style( 'share-center-pro' );
			
		}

		/**
		  * Create a filter to add buttons to the content if not in a widget
		  *
		  * @return Object
		  * @param Object
		  **/
		function scp_addtocontent( $content ) {
			
			global $scpoptions;
			
			//if the buttons should be on the current content then add them to the end of it
			if ( ( is_archive() && $scpoptions['archive'] == 1 ) || ( is_page() && $scpoptions['page'] == 1 ) || ( is_front_page() && $scpoptions['front'] == 1 ) || ( is_home() && $scpoptions['home'] == 1 ) || ( is_search() &&  $scpoptions['search'] == 1 ) || ( is_single() && $scpoptions['single'] == 1 ) ) {
				return $content . $this->scp_social_buttons();
			} else {
				return $content;
			}

		}

		/**
		  * Load required javascripts in the footer
		  *
		  * @return null
		  */
		function scp_footerscripts() {

			global $scpoptions;
			
			//load the footer script
			wp_enqueue_script( 'facebook', SCP_PU . 'inc/share.js', array( 'jquery' ), false, true );

		}

		/**
		 * Load the widget
		 * @return Null
		 **/
		function scp_loadwidget() {

			register_widget( 'SCP_Widget' );

		}

		/**
		 * Create the social button output
		 *
		 * @return null
		 **/
		function scp_social_buttons() {

			global $scpoptions, $post;
			
			//Get the URLs
			$full_url = urlencode( get_permalink( $post->ID ) );
			
			//get the twitter username
			$twitteruser = stripslashes( $scpoptions['twitteruser'] );

			//initialize the buttons
			$buttons = '';
			
			$buttons .= "\n<!--## Begin Share Center Pro Scripts ## -->\n";	
			$buttons .= "<div class=\"scpclear\"></div>\n";
			$buttons .= "<div id=\"share-center-pro\">\n";

			if ( strlen( $scpoptions['header'] ) > 1 ) {
				$buttons .= "<div class=\"scpHeading\">" . $scpoptions['header'] . "</div>\n";
			}

			if ( $scpoptions['buffer'] == 1 ) {
				$buttons .= "<div class=\"scpBuffer\"><a href=\"http://bufferapp.com/add\" class=\"buffer-add-button\" data-count=\"vertical\"></a></div>\n";
			}

			if ( $scpoptions['digg'] == 1 ) {
				$buttons .= "<div class=\"scpDigg\"><a class=\"DiggThisButton DiggMedium\"></a></div>\n";
			}

			if ( $scpoptions['facebook'] == 1 ) {
				$buttons .= "<div class=\"scpFacebook\"><fb:like href=\"" . $full_url . "\" send=\"false\" layout=\"box_count\" width=\"450\" show_faces=\"false\" font=\"arial\"></fb:like></div>\n";
			}

			if ( $scpoptions['google'] == 1 ) {
				$buttons .= "<div class=\"scpGoogle\"><g:plusone size=\"tall\"></g:plusone></div>\n";
			}	

			if ( $scpoptions['linkedin'] == 1 ) {
				$buttons .= "<div class=\"scpLinkedin\"><script type=\"in/share\" data-counter=\"top\"></script></div>\n";
			}	

			if ( $scpoptions['twitter'] == 1 ) {
				$buttons .= "<div class=\"scpTwitter\"><a href=\"http://twitter.com/share\" class=\"twitter-share-button\"  data-url=\"" . get_permalink() . "\" data-counturl=\"" . get_permalink() . "\" data-text=\"" . get_the_title() . "\" data-count=\"vertical\" data-via=\"" . $twitteruser . "\"></a></div>\n";
			}

			$buttons .= "<span class=\"stretch\"></span>\n";
			$buttons .= "</div>\n";
			$buttons .= "<div class=\"scpclear\"></div>\n";
			$buttons .= "<!--## End Share Center Pro Scripts ## -->\n";	
			
			return $buttons;

		}
		
	}

}

//create plugin object
global $bit51scp; 
$bit51scp = new bit51_scp();

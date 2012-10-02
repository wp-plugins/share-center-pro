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
	
		public $pluginversion 	= '0001'; //current plugin version
	
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
					'archives'				=> '0',
					'pages'					=> '0',
					'front'					=> '0',
					'home'					=> '0',
					'search'				=> '0',
					'single'				=> '0',
					'belowpost'				=> '0',
					'twitteruser'			=> ''
				)
			)
		);
		public $tabs;

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

			//Register footer scripts
			add_action( 'wp_enqueue_scripts', array( &$this, 'scp_footerscripts' ) );

			//add to content
			add_filter( 'the_content', array( &$this, 'scp_addtocontent' ), 25 );

			//Register the stylesheet
			add_action( 'wp_print_styles', array( &$this, 'scp_addstylesheet' ) );

		}

		/**
		  * Load required scripts in the footer
		  * @return null
		  */
		function scp_footerscripts() {

			global $scpoptions, $scpwidget;
			
			//Only load scripts where necessary
			if ( $scpWidget || ( is_archive() && $scpoptions['archive'] == 1 ) || ( is_page() && $scpoptions['page'] == 1 ) || ( is_front_page() && $scpoptions['front'] == 1 ) || ( is_home() && $scpoptions['home'] == 1 ) || ( is_search() &&  $scpoptions['search'] == 1 ) || ( is_single() && $scpoptions['single'] == 1 ) ) {

				if ( $scpoptions['digg'] == 1 ) {
					wp_enqueue_script( 'digg', 'http://widgets.digg.com/buttons.js', false, false, true );
				}

				if ( $scpoptions['facebook'] == 1 ) {
					wp_enqueue_script( 'facebook', 'http://connect.facebook.net/en_US/all.js#xfbml=1', false, false, true );
				}

				if ( $scpoptions['google'] == 1 ) {
					wp_enqueue_script( 'google', 'https://apis.google.com/js/plusone.js', false, false, true );
				}	

				if ( $scpoptions['linkedin'] == 1 ) {
					wp_enqueue_script( 'linkedin', 'http://platform.linkedin.com/in.js', false, false, true );
				}	

				if ( $scpoptions['twitter'] == 1 ) {
					wp_enqueue_script( 'twitter', 'http://platform.twitter.com/widgets.js', false, false, true );
				}

				if ( $scpoptions['buffer'] == 1 ) {
					wp_enqueue_script( 'buffer', 'http://static.bufferapp.com/js/button.js', false, false, true );
				}

			}

		}

		/**
		 * Enqueue style sheet
		 * @return null
		 **/
		function scp_addstylesheet() {
			wp_register_style( 'share-center-pro', SCP_PU . 'inc/style.css' );
			wp_enqueue_style( 'share-center-pro' );
		}

		/**
		 * Add social buttons in standard content (posts, pages, etc)
		 * @return null
		 **/
		function scp_social_buttons() {

			global $scpoptions;
			
			//Get the URLs
			$full_url = urlencode( get_permalink( $post->ID ) );
			
			//get the twitter username
			$twitteruser = stripslashes( $scpoptions['twitteruser'] );

			//initialize the buttons
			$buttons = '';
			
			$buttons .= "\n<!--## Begin Share Center Pro Scripts ## -->\n";	
			$buttons .= "<div class=\"scpcleartop\"></div>\n";
			$buttons .= "<ul id=\"share-center-pro\">\n";

			if ( strlen( $scpoptions['header'] ) > 1 ) {
				$buttons .= "<h2 id=\"scpHeading\">" . $scpoptions['header'] . "</h2>\n";
			}

			if ( $scpoptions['buffer'] == 1 ) {
				$buttons .= "<li id=\"scpBuffer\"><a href=\"http://bufferapp.com/add\" class=\"buffer-add-button\" data-count=\"vertical\"></a></li>\n";
			}

			if ( $scpoptions['digg'] == 1 ) {
				$buttons .= "<li id=\"scpDigg\"><a class=\"DiggThisButton DiggMedium\"></a></li>\n";
			}

			if ( $scpoptions['facebook'] == 1 ) {
				$buttons .= "<li id=\"scpFacebook\"><fb:like href=\"" . $full_url . "\" send=\"false\" layout=\"box_count\" width=\"\" show_faces=\"false\" font=\"arial\"></fb:like></li>\n";
			}

			if ( $scpoptions['google'] == 1 ) {
				$buttons .= "<li id=\"scpGp\"><g:plusone size=\"tall\"></g:plusone></li>\n";
			}	

			if ( $scpoptions['linkedin'] == 1 ) {
				$buttons .= "<li id=\"scpLi\"><script type=\"in/share\" data-counter=\"top\"></script></li>\n";
			}	

			if ( $scpoptions['twitter'] == 1 ) {
				$buttons .= "<script type=\"text/javascript\" src=\"http://platform.twitter.com/widgets.js\"></script>\n";
				$buttons .= "<li id=\"scpTwitter\"><a href=\"http://twitter.com/share\" class=\"twitter-share-button\"  data-url=\"" . get_permalink() . "\" data-counturl=\"" . get_permalink() . "\" data-text=\"" . get_the_title() . "\" data-count=\"vertical\" data-via=\"" . $twitteruser . "\"></a></li>\n";
			}

			$buttons .= "</ul>\n";
			$buttons .= "<div class=\"scpclear\"></div>\n";
			$buttons .= "<!--## End Share Center Pro Scripts ## -->\n";	
			
			return $buttons;

		}

		/**
		  * Create the filter to add buttons to content
		  * @return Object
		  * @param Object
		  **/
		function scp_addtocontent( $content ) {
			
			global $scpoptions;
			
			if (  $scpoptions['belowpost'] == 1 && ( ( is_archive() && $scpoptions['archive'] == 1 ) || ( is_page() && $scpoptions['page'] == 1 ) || ( is_front_page() && $scpoptions['front'] == 1 ) || ( is_home() && $scpoptions['home'] == 1 ) || ( is_search() &&  $scpoptions['search'] == 1 ) || ( is_single() && $scpoptions['single'] == 1 ) ) ) {
				return $content . $this->scp_social_buttons();
			} else {
				return $content;
			}

		}
		
	}

}

//create plugin object
new bit51_scp();

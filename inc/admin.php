<?php

if (!class_exists( 'scp_admin' ) ) {

	class scp_admin extends bit51_scp {
		
		/**
		 * Initialize admin function
		 */
		function __construct() {
			
			//add scripts and css
			add_action( 'admin_print_scripts', array( &$this, 'config_page_scripts' ) );
			add_action( 'admin_print_styles', array( &$this, 'config_page_styles' ) );
		
			//add menu items
			add_action( 'admin_menu', array( &$this, 'register_settings_page' ) );
		
			//add settings
			add_action( 'admin_init', array( &$this, 'register_settings' ) );
		
			//add action link
			add_filter( 'plugin_action_links', array( &$this, 'add_action_link' ), 10, 2 );
		
			//add donation reminder
			add_action( 'admin_init', array( &$this, 'ask' ) );
			
		}
	
		/**
		 * Register page settings
		 */
		function register_settings_page() {

			add_options_page( __( $this->pluginname, $this->hook ), __( $this->pluginname, $this->hook ), $this->accesslvl, $this->hook, array( &$this,'scp_admin_init' ) );

		}	
		
		/**
		 * Register admin page main content
		 * To add more boxes to the admin page add a 2nd inner array item with title and callback function or content
		 */
		function scp_admin_init() {

			$this->admin_page( $this->pluginname . ' ' . __( 'Options', $this->hook ), 

				array(

					array( __( 'Instructions', $this->hook), 'install_instructions' ), //primary admin page content
					array( __( 'General Options', $this->hook), 'general_options' ), //primary admin page content

				)

			);

		}
		
		/**
		 * Create instructions block
		 */
		function install_instructions() {
			
		}
		
		/**
		 * Create admin page main content
		 */
		function general_options() {
			global $scpoptions;
			?>
			<form method="post" action="options.php">
			<?php settings_fields( 'bit51_scp_options' ); //use main settings group ?>
				<table class="form-table">
					<tr valign="top">
						<td width="50%">
							<h4><?php _e( 'Buttons to show', $this->hook ); ?></h4>
							<p><?php __( 'Pick which buttons you would like to have appear on your site', $this->hook ); ?></p>
							<input type="checkbox" name="bit51_scp[buffer]" id="buffer" value="1" <?php if ( $scpoptions['buffer'] == 1 ) echo "checked"; ?> /> <label for="buffer"><a href="http://www.bufferapp.com" target="_blank">Buffer</a></label><br />
							<input type="checkbox" name="bit51_scp[digg]" id="digg" value="1" <?php if ( $scpoptions['digg'] == 1 ) echo "checked"; ?> /> <label for="digg"><a href="http://www.digg.com" target="_blank">Digg</a></label><br />
							<input type="checkbox" name="bit51_scp[facebook]" id="facebook" value="1" <?php if ( $scpoptions['facebook'] == 1 ) echo "checked"; ?> /> <label for="facebook"><a href="http://www.facebook.com" target="_blank">Facebook</a></label><br />
							<input type="checkbox" name="bit51_scp[google]" id="google" value="1" <?php if ( $scpoptions['google'] == 1 ) echo "checked"; ?> /> <label for="google"><a href="http://plus.google.com" target="_blank">Google +1</a></label><br />
							<input type="checkbox" name="bit51_scp[linkedin]" id="linkedin" value="1" <?php if ( $scpoptions['linkedin'] == 1 ) echo "checked"; ?> /> <label for="linkedin"><a href="http://www.linkedin.com" target="_blank">LinkedIn</a></label><br />
							<input type="checkbox" name="bit51_scp[twitter]" id="twitter" value="1" <?php if ( $scpoptions['twitter'] == 1 ) echo "checked"; ?> /> <label for="twitter"><a href="http://www.twitter.com" target="_blank">Twitter</a></label><br />
						</td>
						<td width="50%">
							<h4><?php _e( 'Where to show buttons', $this->hook ); ?></h4>
							<p><?php __( 'Pick which pages and posts you would like buttons to appear on. If only using the widget leave these all unchecked.', $this->hook ); ?></p>
							<input type="checkbox" name="bit51_scp[archive]" id="archive" value="1" <?php if ( $scpoptions['archive'] == 1 ) echo "checked"; ?> /> <label for="archive"> <?php _e( 'Show on Archives', $this->hook ); ?></label><br />
							<input type="checkbox" name="bit51_scp[page]" id="page" value="1" <?php if ( $scpoptions['page'] == 1 ) echo "checked"; ?> /> <label for="page"> <?php _e( 'Show on Pages', $this->hook ); ?></label><br />
							<input type="checkbox" name="bit51_scp[front]" id="front" value="1" <?php if ( $scpoptions['front'] == 1 ) echo "checked"; ?> /> <label for="front"> <?php _e( 'Show on Frontpage', $this->hook ); ?></label><br />
							<input type="checkbox" name="bit51_scp[home]" id="home" value="1" <?php if ( $scpoptions['home'] == 1 ) echo "checked"; ?> /> <label for="home"> <?php _e( 'Show on Homepage</strong', $this->hook ); ?>></label><br />
							<input type="checkbox" name="bit51_scp[search]" id="search" value="1" <?php if ( $scpoptions['search'] == 1 ) echo "checked"; ?> /> <label for="search"> <?php _e( 'Show on Search Results', $this->hook ); ?></label><br />
							<input type="checkbox" name="bit51_scp[single]" id="single" value="1" <?php if ( $scpoptions['single'] == 1 ) echo "checked"; ?> /> <label for="single"> <?php _e( 'Show on Single Posts', $this->hook ); ?></label><br />
						</td>
					</tr>
					<tr valign="top">
						<td colspan="2">
							<label for="belowpost"> <?php _e( 'Show below the content (if not using a widget)', $this->hook ); ?></label> <input type="checkbox" name="bit51_scp[belowpost]" id="belowpost" value="1" <?php if ( $scpoptions['belowpost'] == 1 ) echo "checked"; ?> /><br />
							<label for"header"><?php _e( 'Enter a title for the widget or a header if in the bottom of posts (if desired)', $this->hook ); ?></label><input name="bit51_scp[header]" id="header" value="<?php echo $scpoptions['header']; ?>" type="text"><br />
							<label for"twitteruser"><?php _e( 'Enter your twitter username (for link tracking)', $this->hook ); ?></label><input name="bit51_scp[twitteruser]" id="twitteruser" value="<?php echo $scpoptions['twitteruser']; ?>" type="text"><br />
						</td>
					</tr>
				</table>
				<p class="submit"><input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ) ?>" /></p>
			</form>
			<?php
		}

		/**
		 * Validate input
		 */
		function scp_val_options( $input ) {
			
			$input['header'] = sanitize_text_field( $input['header'] );
			$input['twitteruser'] = sanitize_text_field( $input['twitteruser'] );
			if ( strstr( $input['twitteruser'], '@' ) ) {
				$input['twitteruser'] = substr( $input['twitteruser'], 1 );
			}
		    
		    return $input;
		}
		
	}

}

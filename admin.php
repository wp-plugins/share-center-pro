<div class="wrap" >

	<h2>Social Share Plus - <?php _e('Options', 'social-share-pro'); ?></h2>
	
	<div id="poststuff" class="ui-sortable">
		<div class="postbox-container" style="width:70%">	
			<div class="postbox opened">
				<h3><?php _e('Options', 'social-share-pro'); ?></h3>	
				<div class="inside">
					<form method="post"  action="options.php">
						<?php settings_fields('SSP_options'); ?>
			            <?php $options = get_option('SSP_options'); ?>
						<table class="form-table">
							<tbody>
								<tr valign="top">
									<td width="50%">
										<h4><?php _e('Buttons to show', 'social-share-pro'); ?></h4>
										<p><?php __('Pick which buttons you would like to have appear on your site','social-share-pro'); ?></p>
										<input type="checkbox" name="SSP_options[show_digg]" id="show_digg" value="1" <?php if ($options['show_digg'] == 1) echo "checked"; ?> /> <label for="show_digg"><a href="http://www.digg.com" target="_blank">Digg</a></label><br />
										<input type="checkbox" name="SSP_options[show_facebook]" id="show_facebook" value="1" <?php if ($options['show_facebook'] == 1) echo "checked"; ?> /> <label for="show_facebook"><a href="http://www.facebook.com" target="_blank">Facebook</a></label><br />
										<input type="checkbox" name="SSP_options[show_google]" id="show_google" value="1" <?php if ($options['show_google'] == 1) echo "checked"; ?> /> <label for="show_google"><a href="http://plus.google.com" target="_blank">Google +1</a></label><br />
										<input type="checkbox" name="SSP_options[show_linkedin]" id="show_linkedin" value="1" <?php if ($options['show_linkedin'] == 1) echo "checked"; ?> /> <label for="show_linkedin"><a href="http://www.linkedin.com" target="_blank">LinkedIn</a></label><br />
										<input type="checkbox" name="SSP_options[show_su]" id="show_su" value="1" <?php if ($options['show_su'] == 1) echo "checked"; ?> /> <label for="show_su"><a href="http://www.stumbleupon.com" target="_blank">Stumbleupon</a></label><br />
										<input type="checkbox" name="SSP_options[show_twitter]" id="show_twitter" value="1" <?php if ($options['show_twitter'] == 1) echo "checked"; ?> /> <label for="show_twitter"><a href="http://www.twitter.com" target="_blank">Twitter</a></label><br />
									</td>
									<td width="50%">
										<h4><?php _e('Where to show buttons', 'social-share-pro'); ?></h4>
										<p><?php __('Pick which pages and posts you would like buttons to appear on. If only using the widget leave these all unchecked.','social-share-pro'); ?></p>
										<input type="checkbox" name="SSP_options[show_archive]" id="show_archive" value="1" <?php if ($options['show_archive'] == 1) echo "checked"; ?> /> <label for="show_archive"> <?php _e('Show on Archives', 'social-share-pro'); ?></label><br />
										<input type="checkbox" name="SSP_options[show_page]" id="show_page" value="1" <?php if ($options['show_page'] == 1) echo "checked"; ?> /> <label for="show_page"> <?php _e('Show on Pages', 'social-share-pro'); ?></label><br />
										<input type="checkbox" name="SSP_options[show_front]" id="show_front" value="1" <?php if ($options['show_front'] == 1) echo "checked"; ?> /> <label for="show_front"> <?php _e('Show on Frontpage', 'social-share-pro'); ?></label><br />
										<input type="checkbox" name="SSP_options[show_home]" id="show_home" value="1" <?php if ($options['show_home'] == 1) echo "checked"; ?> /> <label for="show_home"> <?php _e('Show on Homepage</strong', 'social-share-pro'); ?>></label><br />
										<input type="checkbox" name="SSP_options[show_search]" id="show_search" value="1" <?php if ($options['show_search'] == 1) echo "checked"; ?> /> <label for="show_search"> <?php _e('Show on Search Results', 'social-share-pro'); ?></label><br />
										<input type="checkbox" name="SSP_options[show_single]" id="show_single" value="1" <?php if ($options['show_single'] == 1) echo "checked"; ?> /> <label for="show_single"> <?php _e('Show on Single Posts', 'social-share-pro'); ?></label><br />
									</td>
								</tr>
								<tr valign="top">
									<td colspan="2">
									<label for"heading"><?php _e('Enter a heading here (if desired)','social-share-pro'); ?></label><input name="SSP_options[heading]" id="heading" value="<?php echo $options['heading']; ?>" type="text"><br />
									<label for"twitter_user"><?php _e('Enter your twitter username (for link tracking)','social-share-pro'); ?></label><input name="SSP_options[twitter_user]" id="twitter_user" value="<?php echo $options['twitter_user']; ?>" type="text"><br />
									</td>
								</tr>
							</tbody>
						</table>	
						<p class="submit"><input type="submit" name="SSP_options_save" value="<?php _e('save', 'social-share-pro'); ?>"></p>
					</form>
				</div>
			</div>
		</div>
		<div class="postbox-container" style="width:29%">
			<div class="postbox opened">
				<h3><?php _e('Please Donate', 'social-share-pro'); ?></h3>
				<div class="inside">
					<span style="text-align: center">
						<p><?php _e('If you find this plugin useful please consider a small donation.', 'social-share-pro'); ?></p>
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post"> 
							<input name="cmd" type="hidden" value="_donations" /> 
							<input name="business" type="hidden" value="ZLMVYQBK7WRRS" /> 
							<input name="lc" type="hidden" value="US" /> 
							<input name="item_name" type="hidden" value="Wordpress Better WP Security Plugin" /> 
							<input name="currency_code" type="hidden" value="USD" /> 
							<input name="bn" type="hidden" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted" /> 
							<input alt="<?php _e('PayPal - The safer, easier way to pay online!', 'social-share-pro'); ?>" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" type="image" /> <img src="https://www.paypal.com/en_US/i/scr/pixel.gif" border="0" alt="" width="1" height="1" /><br /> 
						</form>
						<p><?php _e('Users who have made a donation will receive priority for both support and feature requests.', 'social-share-pro'); ?></p>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
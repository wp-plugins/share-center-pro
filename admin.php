<div class="wrap" >

	<h2>Share Center Pro - <?php _e('Options', 'share-center-pro'); ?></h2>
	
	<div id="poststuff" class="ui-sortable">
		<div class="postbox-container" style="width:70%">	
			<div class="postbox opened">
				<h3><?php _e('Options', 'share-center-pro'); ?></h3>	
				<div class="inside">
					<form method="post"  action="options.php">
						<?php settings_fields('SSP_options'); ?>
			            <?php $options = get_option('SSP_options'); ?>
						<table class="form-table">
							<tbody>
								<tr valign="top">
									<td width="50%">
										<h4><?php _e('Buttons to show', 'share-center-pro'); ?></h4>
										<p><?php __('Pick which buttons you would like to have appear on your site','share-center-pro'); ?></p>
										<input type="checkbox" name="SSP_options[show_digg]" id="show_digg" value="1" <?php if ($options['show_digg'] == 1) echo "checked"; ?> /> <label for="show_digg"><a href="http://www.digg.com" target="_blank">Digg</a></label><br />
										<input type="checkbox" name="SSP_options[show_facebook]" id="show_facebook" value="1" <?php if ($options['show_facebook'] == 1) echo "checked"; ?> /> <label for="show_facebook"><a href="http://www.facebook.com" target="_blank">Facebook</a></label><br />
										<input type="checkbox" name="SSP_options[show_google]" id="show_google" value="1" <?php if ($options['show_google'] == 1) echo "checked"; ?> /> <label for="show_google"><a href="http://plus.google.com" target="_blank">Google +1</a></label><br />
										<input type="checkbox" name="SSP_options[show_linkedin]" id="show_linkedin" value="1" <?php if ($options['show_linkedin'] == 1) echo "checked"; ?> /> <label for="show_linkedin"><a href="http://www.linkedin.com" target="_blank">LinkedIn</a></label><br />
										<input type="checkbox" name="SSP_options[show_su]" id="show_su" value="1" <?php if ($options['show_su'] == 1) echo "checked"; ?> /> <label for="show_su"><a href="http://www.stumbleupon.com" target="_blank">Stumbleupon</a></label><br />
										<input type="checkbox" name="SSP_options[show_twitter]" id="show_twitter" value="1" <?php if ($options['show_twitter'] == 1) echo "checked"; ?> /> <label for="show_twitter"><a href="http://www.twitter.com" target="_blank">Twitter</a></label><br />
									</td>
									<td width="50%">
										<h4><?php _e('Where to show buttons', 'share-center-pro'); ?></h4>
										<p><?php __('Pick which pages and posts you would like buttons to appear on. If only using the widget leave these all unchecked.','share-center-pro'); ?></p>
										<input type="checkbox" name="SSP_options[show_archive]" id="show_archive" value="1" <?php if ($options['show_archive'] == 1) echo "checked"; ?> /> <label for="show_archive"> <?php _e('Show on Archives', 'share-center-pro'); ?></label><br />
										<input type="checkbox" name="SSP_options[show_page]" id="show_page" value="1" <?php if ($options['show_page'] == 1) echo "checked"; ?> /> <label for="show_page"> <?php _e('Show on Pages', 'share-center-pro'); ?></label><br />
										<input type="checkbox" name="SSP_options[show_front]" id="show_front" value="1" <?php if ($options['show_front'] == 1) echo "checked"; ?> /> <label for="show_front"> <?php _e('Show on Frontpage', 'share-center-pro'); ?></label><br />
										<input type="checkbox" name="SSP_options[show_home]" id="show_home" value="1" <?php if ($options['show_home'] == 1) echo "checked"; ?> /> <label for="show_home"> <?php _e('Show on Homepage</strong', 'share-center-pro'); ?>></label><br />
										<input type="checkbox" name="SSP_options[show_search]" id="show_search" value="1" <?php if ($options['show_search'] == 1) echo "checked"; ?> /> <label for="show_search"> <?php _e('Show on Search Results', 'share-center-pro'); ?></label><br />
										<input type="checkbox" name="SSP_options[show_single]" id="show_single" value="1" <?php if ($options['show_single'] == 1) echo "checked"; ?> /> <label for="show_single"> <?php _e('Show on Single Posts', 'share-center-pro'); ?></label><br />
									</td>
								</tr>
								<tr valign="top">
									<td colspan="2">
									<label for"heading"><?php _e('Enter a heading here (if desired)','share-center-pro'); ?></label><input name="SSP_options[heading]" id="heading" value="<?php echo $options['heading']; ?>" type="text"><br />
									<label for"twitter_user"><?php _e('Enter your twitter username (for link tracking)','share-center-pro'); ?></label><input name="SSP_options[twitter_user]" id="twitter_user" value="<?php echo $options['twitter_user']; ?>" type="text"><br />
									</td>
								</tr>
							</tbody>
						</table>	
						<p class="submit"><input type="submit" name="SSP_options_save" value="<?php _e('save', 'share-center-pro'); ?>"></p>
					</form>
				</div>
			</div>
		</div>
		<div class="postbox-container" style="width:29%">
			<div class="postbox opened">
				<h3><?php _e('Please Donate', 'share-center-pro'); ?></h3>
				<div class="inside">
					<span style="text-align: center">
						<p><?php _e('If you find this plugin useful please consider a small donation.', 'share-center-pro'); ?></p>
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="QKDGZFLN3QG68">
							<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
							<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
						<p><?php _e('Users who have made a donation will receive priority for both support and feature requests.', 'share-center-pro'); ?></p>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
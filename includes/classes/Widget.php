<?php
class utfeed_widget extends UTFEED_Widgets
{

	function __construct()
	{
		parent::__construct('utfeed_widget', __(UTFEED_PLUGIN_TITLE_WIDGET, UTFEED_PLUGIN_DOMAIN), ['description' => __(UTFEED_PLUGIN_TITLE_WIDGET, UTFEED_PLUGIN_DOMAIN)]);
	}

	public function widget($args, $instance)
	{
		echo $this->GetWidgetTitle($args, $instance);
		echo $this->GetWidgetHtml($instance);
	}

	public function form($instance)
	{
		$values = $this->GetInstanceValues($instance);
		extract($values);
?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', UTFEED_PLUGIN_DOMAIN); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('feed_type')); ?>"><?php _e('Feed Type:', UTFEED_PLUGIN_DOMAIN); ?></label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id('feed_type')); ?>" name="<?php echo esc_attr($this->get_field_name('feed_type')); ?>">
				<?php
				$feed_types = UTFEED_Twitter::getTwitterFeedTypes();
				foreach ($feed_types as $feed_type) {
					echo '<option value="' . esc_attr($feed_type[0]) . '"';
					echo ($instance['feed_type'] == $feed_type[0]) ? "selected" : "";
					echo ' value="' . esc_attr($feed_type[0]) . '">' . esc_attr($feed_type[1]) . '</option>';
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('handle')); ?>"><?php _e('Handle:', UTFEED_PLUGIN_DOMAIN); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('handle')); ?>" name="<?php echo esc_attr($this->get_field_name('handle')); ?>" type="text" value="<?php echo esc_attr($handle); ?>" />
		</p>
		<p>
			<input type="hidden" id="<?php echo esc_attr($this->get_field_id('actual_handle')); ?>" name="<?php echo esc_attr($this->get_field_name('actual_handle')); ?>" value="<?php echo esc_attr($actual_handle); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('feed_width')); ?>">
				<?php _e('Width:', UTFEED_PLUGIN_DOMAIN); ?>
			</label>
			<input id="<?php echo esc_attr($this->get_field_id('feed_width')); ?>" name="<?php echo esc_attr($this->get_field_name('feed_width')); ?>" type="number" value="<?php echo esc_attr($feed_width); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('feed_height')); ?>">
				<?php _e('Height:', UTFEED_PLUGIN_DOMAIN); ?>
			</label>
			<input id="<?php echo esc_attr($this->get_field_id('feed_height')); ?>" name="<?php echo esc_attr($this->get_field_name('feed_height')); ?>" type="number" value="<?php echo esc_attr($feed_height); ?>" />
			<font size="2px"><?php _e('Height will not work for Single Tweet!', UTFEED_PLUGIN_DOMAIN); ?></font>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('feed_lang')); ?>">
				<?php _e('Language:', UTFEED_PLUGIN_DOMAIN); ?>
			</label>
			<select class="widefat" name="<?php echo esc_attr($this->get_field_name('feed_lang')); ?>" id="<?php echo esc_attr($this->get_field_id('feed_lang')); ?>">
				<?php
				$langs = UTFEED_Twitter::getTwitterFeedLangs();
				foreach ($langs as $lang) {
					echo '<option value="' . esc_attr($lang[0]) . '"';
					echo ($instance['feed_lang'] == $lang[0]) ? "selected" : "";
					echo ' value="' . esc_attr($lang[0]) . '">' . esc_attr($lang[1]) . '</option>';
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('feed_theme')); ?>">
				<?php _e('Theme:', UTFEED_PLUGIN_DOMAIN); ?>
			</label>
			<select name="<?php echo esc_attr($this->get_field_name('feed_theme')); ?>" id="<?php echo esc_attr($this->get_field_id('feed_theme')); ?>">
				<option value="light" <?php selected($feed_theme, "light"); ?>>
					<?php _e('Light', UTFEED_PLUGIN_DOMAIN); ?>
				</option>
				<option value="dark" <?php selected($feed_theme, "dark"); ?>>
					<?php _e('Dark', UTFEED_PLUGIN_DOMAIN); ?>
				</option>
			</select>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['feed_track'], "on") ?> id="<?php echo esc_attr($this->get_field_id('feed_track')); ?>" name="<?php echo esc_attr($this->get_field_name('feed_track')); ?>" />
			<label for="<?php echo esc_attr($this->get_field_id('feed_track')); ?>" title="<?php _e('Click Here To Read More!', UTFEED_PLUGIN_DOMAIN) ?>"><?php _e('Opt-out of tailoring Twitter <a href="https://developer.twitter.com/en/docs/twitter-for-websites/privacy" target="_blank">?</a>', UTFEED_PLUGIN_DOMAIN); ?>
			</label>
		</p>
<?php
	}

	public function update($new_instance, $old_instance)
	{
		return $this->UpdateWidgetInstace($new_instance, $old_instance);
	}
}

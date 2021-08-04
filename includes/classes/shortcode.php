<?php
/**
 * Ultimate Twitter Feed Shortcode class.
 * This class will handle rendering shortcode.
 *
 * @package   Ultimate Twitter Feeds
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
if ( !class_exists( 'UTFEED_Shortcode' ) ) {
	class UTFEED_Shortcode {
		public static function doShortcode( $atts, $content = "" ) {
			// Attributes
			$default = get_option( UTFEED_PLUGIN_SETTINGS_OPTION );
			$atts = shortcode_atts(
				[
					'title' => $default['title'],
					'height' => $default['height'] ?? '400',
					'width' => $default['width'] ?? '600',
					'handle' => $default['handle'] ?? 'imneerav',
					'feedtype' => $default['feedtype'] ?? 'profile',
					'feed_track' => $default['track'] ?? 'n',
					'feed_lang' => $default['lang'] ?? '',
					'feed_theme' => $default['theme'] ?? ''
				],
				$atts,
				'UTFEED_TWITTER_FEED'
			);
			$atts['title'] = self::getTitle( $atts['title'] );
			$twitter = new UTFEED_Twitter();
			$twitter->handle = $atts['handle'];
			$twitter->feed_type = $atts['feedtype'];
			$twitter->width = $atts['width'];
			$twitter->height = $atts['height'];
			$twitter->theme = $atts['feed_theme'];
			$twitter->tracking = $atts['feed_track'];
			
			$twitter->cleanTwitterHandle();
			$twitter->feed_lang = $atts['feed_lang'];
			
			$html = '<h3>'.$atts['title'].'</h3>';
			$html .= $twitter->getTwitterHtml();
			return $html;
		}
		
		public static function getTitle( $title ) {
			if ( empty( $title ) ){
				$title = __(UTFEED_PLUGIN_TITLE, 'ultimate-twitter-feeds' );
			}
			
			return apply_filters( 'utfeed_shortcode_title', $title );
		}
	}
}
?>
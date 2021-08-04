<?php
/**
 * Admin Settins class.
 * Handle Admin Settings rendering and saving.
 *
 * @package   Ultimate Twitter Feeds
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

if ( !class_exists( 'UTFEED_Settings' ) ) {
	
	require_once(UTFEED_PLUGIN_CLASSES . 'Pages.php');
	
	class UTFEED_Settings extends UTFEED_Pages {
		
		public function __construct() {
			parent::__construct();
		}

		public function add_plugin_page() {
			add_menu_page(
				UTFEED_PLUGIN_TITLE,
				UTFEED_PLUGIN_TITLE,
				'manage_options',
				'ultimate-twitter-feeds',
				[ $this, 'createAdminPage' ],
				'dashicons-twitter',
				75
			);
		}

		public function createAdminPage() {
			$this->options = get_option( $this->option_name );
			?>

			<div class="wrap">
				<h2><?php echo __( UTFEED_PLUGIN_TITLE, 'ultimate-twitter-feeds' ); ?></h2>
				<?php settings_errors(); ?>

				<form method="post" action="options.php">
					<?php
						settings_fields( UTFEED_PLUGIN_SETTINGS_OPTION_GRP );
						do_settings_sections( $this->page );
						submit_button();
					?>
				</form>
			</div>
		<?php }

		public function page_init() {
			
			$this->setFields();
			
			$this->addSection('setting');
			
			$this->addFields();
		}
		
		private function setFields() {
			
			$this->fields = array (
				'title'      => __( 'Title', 'ultimate-twitter-feeds' ),
				'feedtype'   => __( 'Feed Type', 'ultimate-twitter-feeds' ),
				'handle'     => __( 'Twitter Handle', 'ultimate-twitter-feeds' ),
				'width'   	 => __( 'Width', 'ultimate-twitter-feeds' ),
				'height'     => __( 'Height', 'ultimate-twitter-feeds' ),
				'theme'      => __( 'Theme', 'ultimate-twitter-feeds' ),
				'lang'       => __( 'Language', 'ultimate-twitter-feeds' ),
			);

			/* Extend or Restrict the fields, for future usage.
			$hook_name    = $this->prefix . '_fields';
			$this->fields = apply_filters( $hook_name, $this->fields );*/
		}
		
		public function settingSectionInfo() {
			
		}
	}
}
?>
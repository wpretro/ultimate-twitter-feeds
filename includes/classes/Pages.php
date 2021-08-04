<?php
/**
 * Generalized Page class.
 * Any page can extend and use generalized common features.
 *
 * @package   Ultimate Twitter Feeds
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
if ( !class_exists( 'UTFEED_Pages' ) ) {
	class UTFEED_Pages {
		
		protected $options;
		protected $fields;
		protected $option_name;
		protected $page;
		
		protected function __construct() {
			add_action( 'admin_menu', [ $this, 'add_plugin_page'] );
			add_action( 'admin_init', [ $this, 'page_init'] );
			$this->option_name = UTFEED_PLUGIN_SETTINGS_OPTION;
			$this->page = 'ultimate-twitter-feeds-admin';
		}
		
		protected function sanitize($settings) {
			$sanitary_values = [];
			$settings = array_map( 'trim', $settings );
			foreach( $settings as $key => $value ){
				$sanitary_values[$key] = sanitize_text_field( $value );
			}
			return $sanitary_values;
		}
		
		protected function getInput($name) {
			printf(
					'<input class="regular-text" type="text" name="'.UTFEED_PLUGIN_SETTINGS_OPTION.'['.$name.']" id="'.$name.'" value="%s">',
					isset( $this->options[$name] ) ? esc_attr( $this->options[$name]) : ''
				);
		}
		
		protected function addSection($name){
			register_setting(
				UTFEED_PLUGIN_SETTINGS_OPTION_GRP,
				UTFEED_PLUGIN_SETTINGS_OPTION,
				[ $this, 'sanitize' ]
			);
			
			add_settings_section(
				$name.'_section',
				ucfirst($name),
				[ $this, $name.'SectionInfo' ],
				$this->page
			);
		}
		
		protected function getFieldHelp( $type )
		{
			return '';
			$desc = __(
				'You may use %s in shortcode attribute to override this value.',
				'plugin_pcd'
			);
			return sprintf( $desc, "<code>[".UTFEED_PLUGIN_SHORTCODE." $type]</code>" );
		}
		
		public function printInputField( array $args )
		{
			$type   = $args['type'];
			$id     = $args['label_for'];
			$value  = isset ( $this->options[ $type ] ) ? esc_attr( $this->options[ $type ] ) : '';
			$name   = $this->option_name . '[' . $type . ']';
			$desc   = $this->getFieldHelp( $type );
			
			print "<input type='text' value='$value' name='$name' id='$id'
				class='regular-text code' /> <span class='description'>$desc</span>";
		}
		
		protected function addFields()
		{
			foreach ( $this->fields as $type => $desc )
			{
				$handle   = $this->option_name . "_$type";
				$args     = [ 'label_for' => $handle, 'type' => $type ];
				
				add_settings_field(
					$handle, //id
					$desc, // title
					[ $this, 'printInputField' ], //callback
					$this->page, //page
					'setting_section', //section
					$args
				);
			}
		}
		
		public function SectionInfo() {
			
		}
	}
}
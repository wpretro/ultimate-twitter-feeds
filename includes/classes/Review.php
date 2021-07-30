<?php
/**
 * Add Review class.
 * Ask users to give a review of the plugin on WordPress.org.
 *
 * @package   Ultimate Twitter Feeds
 
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

if ( ! class_exists( 'UTFEED_Review' ) ) :
	
	class UTFEED_Review {

		private $slug;
		private $name;
		public $nobug_option;
		public $date_option;
		private $time_limit;

		public function __construct( $args ) {

			$this->slug         = $args['slug'];
			$this->name         = $args['name'];
			$this->nobug_option = $this->slug . '_no_bug';
			$this->date_option  = 'ultimate-twitter-feeds-activation-date';

			if ( isset( $args['time_limit'] ) ) {
				$this->time_limit = $args['time_limit'];
			} else {
				$this->time_limit = WEEK_IN_SECONDS;
			}

			add_action( 'admin_init', array( $this, 'showReviewNotice' ) );
			add_action( 'admin_init', array( $this, 'setNoBug' ), 5 );
			add_action( 'admin_head', array( $this, 'adminAssets' ) );
		}

		public function adminAssets() {
			wp_enqueue_style( 'add-review-style', UTFEED_PLUGIN_CSS_URL.'review.css', array(), '1.0' );
		}

		public function calculateTime( $seconds ) {
			$years = ( intval( $seconds ) / YEAR_IN_SECONDS ) % 100;
			if ( $years > 0 ) {
				return sprintf( _n( 'a year', '%s years', $years, 'ultimate-twitter-feeds' ), $years );
			}
			$weeks = ( intval( $seconds ) / WEEK_IN_SECONDS ) % 52;
			if ( $weeks > 1 ) {
				return sprintf( __( 'a week', '%s weeks', $weeks, 'ultimate-twitter-feeds' ), $weeks );
			}
			$days = ( intval( $seconds ) / DAY_IN_SECONDS ) % 7;
			if ( $days > 1 ) {
				return sprintf( __( '%s days', 'ultimate-twitter-feeds' ), $days );
			}
			$minutes = ( intval( $seconds ) / MINUTE_IN_SECONDS ) % 60;
			if($minutes > 1 ) {
				return sprintf( __( '%s minutes', 'ultimate-twitter-feeds' ), $minutes );
			}
		}

		public function showReviewNotice() {
			if ( ! get_site_option( $this->nobug_option ) || false === get_site_option( $this->nobug_option ) ) {
				add_site_option( $this->date_option, time() );
				$install_date = get_site_option( $this->date_option );
				if ( ( time() - $install_date ) > $this->time_limit ) {
				add_action( 'admin_notices', array( $this, 'displayAdminNotice' ) );
				}
			}
		}

		public function displayAdminNotice() {
			$this->showReview();
		}

		public function showReview() {
			$scriptname	=	explode('/',$_SERVER['SCRIPT_NAME']);
			$no_bug_url =	wp_nonce_url( admin_url( end($scriptname).'?' . $this->nobug_option . '=true' ), 'ultimate-twitter-feeds-notification-nounce' );
			$time 		=	$this->calculateTime( time() - get_site_option( $this->date_option ) );
			?>
			<div class="notice updated ultimate-twitter-feeds-notice">
				<div class="ultimate-twitter-feeds-notice-inner">
					<div class="ultimate-twitter-feeds-notice-icon">
						<img src="https://ps.w.org/ultimate-twitter-feeds/assets/icon-128x128.png" alt="<?php echo esc_attr__( 'Ultimate Twitter Feeds WordPress Plugin', 'ultimate-twitter-feeds' ); ?>" />
					</div>
					<div class="ultimate-twitter-feeds-notice-content">
						<h3><?php echo esc_html__( 'Are you enjoying using Ultimate Twitter Feeds Plugin?', 'ultimate-twitter-feeds' ); ?></h3>
						<p>
							<?php printf( __( 'You have been using <strong><a href="https://wordpress.org/plugins/ultimate-twitter-feeds/" target="_blank">%1$s</a></strong> for sometime now! Could you please do us a favor and give it a 5-star rating on WordPress to help us spread the word and encourage our hardwork?', 'ultimate-twitter-feeds' ), esc_html( $this->name ), esc_html( $time ) );?>
						</p>
					</div>
					<div class="ultimate-twitter-feeds-install-now">
						<?php printf( '<a href="%1$s" class="button button-primary ultimate-twitter-feeds-install-button" target="_blank">%2$s</a>', esc_url( 'https://wordpress.org/support/view/plugin-reviews/ultimate-twitter-feeds#new-post' ), esc_html__( 'Leave a Review', 'ultimate-twitter-feeds' ) ); ?>
						<a href="<?php echo esc_url( $no_bug_url ); ?>" class="no-thanks">
							<?php echo esc_html__( 'No thanks / I already have', 'ultimate-twitter-feeds' ); ?>
						</a>
					</div>
				</div>
			</div>
			<?php
		}

		public function setNoBug() {
			if ( ! isset( $_GET['_wpnonce'] ) || ( ! wp_verify_nonce( $_GET['_wpnonce'], 'ultimate-twitter-feeds-notification-nounce' ) || ! is_admin() || ! isset( $_GET[ $this->nobug_option ] ) || ! current_user_can( 'manage_options' ) ) ) {
				return;
			}
			add_site_option( $this->nobug_option, true );
		}
	}
endif;

/*
* Instantiate the UTFEED_Review class.
*/
new UTFEED_Review (
	array(
		'slug'       => 'ultimate-twitter-feeds',
		'name'       => __( UTFEED_PLUGIN_TITLE, 'ultimate-twitter-feeds' ),
		'time_limit' => WEEK_IN_SECONDS,
		// 'time_limit' => MINUTE_IN_SECONDS // Uncomment this for testing
	)
);
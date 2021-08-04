<?php
add_action( 'widgets_init', 'utfeed_load_widget' );
add_shortcode( UTFEED_PLUGIN_SHORTCODE, [ 'UTFEED_Shortcode', 'doShortcode'] );

/* Admin Actions */
if ( is_admin() ) {
	/*
	 * Instantiate the UTFEED_Review class.
	 */
	$utfeed_review = new UTFEED_Review();
	$utfeed_settings = new UTFEED_Settings();
	add_action( 'admin_init', [ $utfeed_review, 'showReviewNotice' ] );
	add_action( 'admin_init', [ $utfeed_review, 'setNoBug' ], 5 );
	add_action( 'admin_head', [ $utfeed_review, 'adminAssets' ] );
}
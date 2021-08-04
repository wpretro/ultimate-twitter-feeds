<?php
/*
   Plugin Name: Ultimate Twitter Feeds
   description: An <strong>Ultimate Plugin</strong> to display Twitter Feeds on your website.
   Version: 0.2
   Author: Ultimate Twitter Feeds Devs
   Author URI: http://patelmilap.wordperss.com
   License: GPLv2 or later
   Text Domain: ultimate-twitter-feeds
*/

require_once('functions.php');
require_once('constants.php');
require_once(UTFEED_PLUGIN_CLASSES . 'Review.php');
require_once(UTFEED_PLUGIN_CLASSES . 'admin-settings.php');
require_once(UTFEED_PLUGIN_CLASSES . 'Widget.php');
require_once(UTFEED_PLUGIN_CLASSES . 'Twitter.php');
require_once(UTFEED_PLUGIN_CLASSES . 'shortcode.php');
require_once(UTFEED_PLUGIN_INCLUDE . 'actions.php');

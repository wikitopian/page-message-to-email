<?php
/*
 * Plugin Name: Page Message to Email
 * Version: 0.1
 * Plugin URI: https://www.github.com/wikitopian/page-message-to-email
 * Description: Send FB Page messages to an email
 * Author: @wikitopian
 * Author URI: http://www.possumtech.com/
 * Text Domain: page-message-to-email
 */

if ( ! defined( 'ABSPATH' ) ) exit;

require_once( 'classes/class-settings.php' ); // menu and settings stuff
require_once( 'classes/class-facebook.php' ); // facebook API interface

//require_once( 'libraries/-graph-sdk/src/Facebook/Facebook.php' );
require_once( 'libraries/vendor/autoload.php' );

class Page_Message_To_Email {

	private $tag;

	private $settings;

	public function __construct() {

		$this->tag = 'page-message-to-email';

		$this->settings = new Page_Message_To_Email_Settings( $this->tag );

	}

}

$page_message_to_email = new Page_Message_To_Email();

/* EOF */

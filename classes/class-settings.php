<?php

class Page_Message_To_Email_Settings {

	private $tag;

	public function __construct( $tag ) {
		$this->tag = $tag;

		add_action(
			'admin_menu',
			array( &$this, 'do_menu' )
		);

		add_action(
			'admin_init',
			array( &$this, 'do_settings' )
		);

	}

	public function do_menu() {

		add_options_page(
			'Page 2 Email',
			'Page 2 Email',
			'manage_options',
			$this->tag,
			array( &$this, 'do_page' )
		);

	}

	public function do_settings() {

			register_setting( $this->tag, $this->tag . '_fb_app_id' );
			register_setting( $this->tag, $this->tag . '_fb_app_secret' );
			register_setting( $this->tag, $this->tag . '_email_to' );
			register_setting( $this->tag, $this->tag . '_email_subject' );

	}

	public function do_page() {

		echo <<<PAGE

<div class="wrap">
	<form method="post" action="options.php">
		<h1>Page Message to Email</h1>

PAGE;

		settings_fields( $this->tag );
		do_settings_sections( $this->tag );

		echo "\n\t\t<table class=\"form-table\">\n";

		$this->do_page_option( $this->tag . '_fb_app_id',     'Facebook App ID' );
		$this->do_page_option( $this->tag . '_fb_app_secret', 'Facebook App Secret' );
		$this->do_page_option( $this->tag . '_email_to',      'Send Email To' );
		$this->do_page_option( $this->tag . '_email_subject', 'Email Subject' );

		echo "\n\t\t</table>\n";

		$this->do_fb_user();

		submit_button();
		echo "\n\t</form>\n</div>\n";

	}

	public function do_page_option( $id, $label ) {

		$option = esc_attr( get_option( $id ) );

		echo <<<OPTION

			<tr valign="top">
				<th scope="row">{$label}</th>
				<td>
					<input type="text" name="{$id}" value="{$option}" />
				</td>
			</tr>

OPTION;

	}

	public function do_fb_user() {

		$fb_app_id     = esc_attr( get_option( $this->tag . '_fb_app_id',     '' ) );
		$fb_app_secret = esc_attr( get_option( $this->tag . '_fb_app_secret', '' ) );
		$fb_app_user   = esc_attr( get_option( $this->tag . '_fb_app_user',   '' ) );

		if( empty( $fb_app_id ) || empty( $fb_app_secret ) ) {
			echo '<br /><strong>No Credentials</strong><br />';
			return;
		}

		$facebook  = new Page_Message_To_Email_Facebook( $this->tag );
		$token_url = $facebook->get_token_url();
		echo '<br /><strong><a href="' . $token_url . '">Fetch Permissions</a></strong><br />';

		if( empty( $fb_app_user ) ) {
			echo '<br /><strong>No User Token</strong><br />';
			return;
		}

	}

}

/* EOF */

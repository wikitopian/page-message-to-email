<?php

class Page_Message_To_Email_Facebook {

	private $tag;

	public $fb;

	public function __construct( $tag ) {
		$this->tag = $tag;

		$this->do_connect();
	}

	public function do_connect() {

		$app_id      = get_option( $this->tag . '_fb_app_id' );
		$app_secret  = get_option( $this->tag . '_fb_app_secret' );

		$this->fb = new \Facebook\Facebook([
			'app_id' => $app_id,
			'app_secret' => $app_secret,
			'default_graph_version' => 'v2.8',
			]);

		return $this->fb;
	}

	public function get_token_url() {

		$helper = $this->fb->getRedirectLoginHelper();

		try {
			$accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
		}

		if (isset($accessToken)) {
			// Logged in!
			echo $accessToken;
			$_SESSION['facebook_access_token'] = (string) $accessToken;

			// Now you can redirect to another page and use the
			// access token from $_SESSION['facebook_access_token']
			return '667';
		} else {

			$screen = get_current_screen();

			$redirect  = get_admin_url();
			$redirect .= $screen->parent_file;
			$redirect .= '?page=';
			$redirect .= $this->tag;


			//$permissions = ['manage_pages', 'read_page_mailboxes'];
			$url = $helper->getLoginUrl( $redirect ); //, $permissions);

			return $url;
		}
	}

	public function do_test() {

		try {
			// Get the \Facebook\GraphNodes\GraphUser object for the current user.
			// If you provided a 'default_access_token', the '{access-token}' is optional.
			$response = $this->fb->get( '/me' );
		} catch(\Facebook\Exceptions\FacebookResponseException $e) {
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch(\Facebook\Exceptions\FacebookSDKException $e) {
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		$me = $response->getGraphUser();
		echo 'Logged in as ' . $me->getName();

	}

}

/* EOF */

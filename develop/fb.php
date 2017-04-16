<?php
session_start();

define('FACEBOOK_SDK_V4_SRC_DIR', $_SERVER['DOCUMENT_ROOT'] . '/php/facebook-sdk-v5/');
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/facebook-sdk-v5/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/fb-config.php';

/**
 * @url "?login"            renders the login page
 * @url "?save-token"       save the auth token
 */
$URL_PARAM_LOGIN = "login";
$URL_PARAM_SAVE_TOKEN = "save-token";
$fb = new Facebook\Facebook($FB_CONFIG);
$helper = $fb->getRedirectLoginHelper();

function render_login_page() {
    global $URL_PARAM_SAVE_TOKEN;
    global $helper;

    $permissions = ['email'];
    $login_url = $helper->getLoginUrl("http://ifts.if.ua/fb.php?$URL_PARAM_SAVE_TOKEN", $permissions);

    echo <<<HTML
<html>
<head>
</head>
<body>
    <a href="$login_url">Log in with Facebook</a>
</body>
</html>
HTML;
}

if (isset($_GET[$URL_PARAM_LOGIN])) {
    render_login_page();
} else if (isset($_GET[$URL_PARAM_SAVE_TOKEN])) {
    try {
        $accessToken = $helper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    if (isset($accessToken)) {
        // Logged in!
        // $_SESSION['facebook_access_token'] = (string) $accessToken;
        echo "Token: \"$accessToken\"";
    }
}

?>

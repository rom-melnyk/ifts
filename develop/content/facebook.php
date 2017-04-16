<?php
session_start();

define('FACEBOOK_SDK_V4_SRC_DIR', $_SERVER['DOCUMENT_ROOT'] . '/php/facebook-sdk-v5/');
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/facebook-sdk-v5/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/fb-config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/fb-scripts.php';

$URL_PARAM_SAVE_TOKEN = "save-token";

$fb = new Facebook\Facebook($FB_CONFIG);
$helper = $fb->getRedirectLoginHelper();

if (isset($_GET[$URL_PARAM_SAVE_TOKEN])) {
    save_login_token();
    exit;
} else {
    $token = read_token();
    if (!$token) {
        render_login_part();
        exit;
    }

    $fb->setDefaultAccessToken($token);
    try {
        $response = $fb->get('/me'); // https://www.facebook.com/groups/453544624728446/
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    $response_data = $response->getDecodedBody();
    echo var_dump($response_data);
}

// ------------------------ helper functions ------------------------
function render_login_part() {
    global $URL_PARAM_SAVE_TOKEN;
    global $helper;

    echo isset($helper);
    $login_url = $helper->getLoginUrl("http://ifts.if.ua/page/facebook?$URL_PARAM_SAVE_TOKEN", ['email']);

    echo "<a href=\"$login_url\">Log in with Facebook</a>";
}

function save_login_token() {
    global $helper;

    try {
        $token = $helper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    if (isset($token)) {
        write_token($token);
        echo "Wrote token; now reloading the page";
    }
}

?>

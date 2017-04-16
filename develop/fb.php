<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/facebook-sdk-v5/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/fb-config.php';

/**
 * @url "?login"            renders the login page
 * @url "?save-token"       save the auth token
 */
$URL_PARAM_LOGIN = "login";
$URL_PARAM_SAVE_TOKEN = "save-token";

function render_login_page() {
    global $URL_PARAM_SAVE_TOKEN;
    global $FB_CONFIG;
    $fb = new Facebook\Facebook($FB_CONFIG);

    $helper = $fb->getRedirectLoginHelper();
    $permissions = ['email'];
    $login_url = $helper->getLoginUrl("http://ifth.if.ua/fb.php?$URL_PARAM_SAVE_TOKEN", $permissions);

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
} else {
    echo 'Not set!';
}

?>

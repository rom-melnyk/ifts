<?php
session_start();

// define('FACEBOOK_SDK_V4_SRC_DIR', $_SERVER['DOCUMENT_ROOT'] . '/php/facebook-sdk-v5/');
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/facebook-sdk-v5/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/fb-config.php';

$THIS_PAGE = 'http://ifts.if.ua/page/facebook';
$SAVE_TOKEN_URL_PARAM = 'save-token';
$SAVE_TOKEN_URL = "$THIS_PAGE?$SAVE_TOKEN_URL_PARAM";
$TOKEN_FILENAME = $_SERVER['DOCUMENT_ROOT'] . '/php/fb-token.txt';
$FB_GROUP_ID = '453544624728446';
$FB_GROUP_PAGE = "https://www.facebook.com/groups/$FB_GROUP_ID/";

$fb = new Facebook\Facebook($FB_CONFIG);
$helper = $fb->getRedirectLoginHelper();

if (isset($_GET[$SAVE_TOKEN_URL_PARAM])) {
    save_login_token();
} else {
    $token = file_exists($TOKEN_FILENAME) ? file_get_contents($TOKEN_FILENAME) : FALSE;
    if ($token) {
        $posts = get_posts($token);
        render_posts($posts);
    } else {
        render_login_part();
    }
}

// ------------------------ helper functions ------------------------
function log_error($message, $err) {
    $err = str_replace("\n", '', $err);
    echo "<script>console.error('Facebook $message error:', '$err')</script>";
}

function render_login_part() {
    global $helper;
    global $SAVE_TOKEN_URL;
    global $FB_GROUP_PAGE;

    $login_url = $helper->getLoginUrl($SAVE_TOKEN_URL, ['email']);
    echo <<<HTML
<a class="link" href="$login_url">Залогінься</a>
в Facebook або перейди на нашу
<a class="link" href="$FB_GROUP_PAGE">Facebook-сторінку</a>
HTML;
}

function save_login_token() {
    global $fb;
    global $helper;
    global $TOKEN_FILENAME;
    global $THIS_PAGE;

    try {
        $token = $helper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        log_error('Graph API', $e->getMessage());
        $token = FALSE;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        log_error('SDK', $e->getMessage());
        $token = FALSE;
    }

    if (isset($token)) {
        if ($token) {
            $oAuth2Client = $fb->getOAuth2Client();
            $token = $oAuth2Client->getLongLivedAccessToken($token);
            $result = (boolean) file_put_contents($TOKEN_FILENAME, $token);
            if ($result) {
                echo "Логін-ключ збережений; перезавантажую сторінку через 5 сек.";
                echo <<<HTML
<script>setTimeout(function () { location.href='$THIS_PAGE'; }, 5 * 1000);</script>
HTML;
            } else {
                log_error('Token', 'Unable to save token file');
                render_login_part();
            }
        } else {
            render_login_part();
        }
    } else {
        log_error('Auth', 'Token not set');
        render_login_part();
    }
}


function get_posts($token) {
    global $fb;
    $fb->setDefaultAccessToken($token);

    try {
        $response = $fb->get('/me');
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        log_error('Graph API', $e->getMessage());
        $response = FALSE;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        log_error('SDK', $e->getMessage());
        $response = FALSE;
    }

    return $response ? $response->getDecodedBody() : FALSE;
}

function render_posts($posts) {
    if ($posts) {
        echo var_dump($posts);
    } else {
        render_login_part();
    }
}
?>

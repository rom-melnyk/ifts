<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/php/fb-config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/facebook-sdk-v3/facebook.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/fb-helpers.php';

$TOKEN_FILENAME = $_SERVER['DOCUMENT_ROOT'] . '/php/fb-token.txt';

$fb = new Facebook(array(
    'appId' => $FB_CONFIG['app_id'],
    'secret' => $FB_CONFIG['app_secret']
));


render_fb_part();


// ------------------------ main ------------------------
function render_fb_part() {
    global $fb;
    global $SAVE_TOKEN_URL_PARAM;
    global $TOKEN_FILENAME;

    $token = file_exists($TOKEN_FILENAME) ? file_get_contents($TOKEN_FILENAME) : FALSE;
    $fb->setAccessToken($token);
    $user = $fb->getUser();
    if ($user) {
        $posts = get_posts_from_file();

        $date_from_file = $posts ? get_first_post_date($posts) : new DateTime('2000-01-01');
        $date_from_fb = FALSE;

        if (!$posts || get_time_diff(new DateTime(), $date_from_file) > 0) {
            $posts = get_posts_from_fb($token);
            if ($posts) {
                $date_from_fb = get_first_post_date($posts);
            }
        }

        if ($posts) {
            render_posts($posts);
            if ($date_from_fb && get_time_diff($date_from_file, $date_from_fb) > 0) {
                save_posts_to_file($posts);
            }
        } else {
            render_login_part();
        }
    } else {
        render_login_part();
    }
}


// ------------------------ helper functions ------------------------
function render_login_part() {
    global $fb;
    global $SAVE_TOKEN_URL;
    global $FB_GROUP_PAGE;

    $login_url = $fb->getLoginUrl(array('scope' => 'email', 'redirect_uri' => $SAVE_TOKEN_URL));

    render_fb_javascript();
    echo <<<HTML
<a class="link" href="$login_url">Залогінься</a>
в Facebook або перейди на нашу
<a class="link" href="$FB_GROUP_PAGE">Facebook-сторінку</a>
HTML;
}


function render_saved_ok_part() {
    global $THIS_PAGE;
    echo 'Логін-ключ збережений; перезавантажую сторінку через 5 сек.';
    echo "<script>setTimeout(function () { location.href='$THIS_PAGE'; }, 5 * 1000);</script>";
}


function get_login_token() {
    global $fb;
    global $TOKEN_FILENAME;
    global $THIS_PAGE;

    $token = FALSE;
    try {
        $token = $fb->getAccessToken();
    } catch (FacebookApiException $e) {
        log_error('Graph API', $e->getMessage());
    } catch (Exception $e) {
        log_error('General', $e->getMessage());
    }

    if ($token) {
        try {
            if ($fb->setExtendedAccessToken() !== FALSE) {
                $token = $fb->getAccessToken('access_token');
            } else {
                $token = FALSE;
            };
        } catch (Exception $e) {
            log_error('Graph API / setExtenedAccessToken', $e->getMessage());
        }
    }

    return $token;
}



function get_posts_from_fb($token) {
    global $fb;
    global $FB_GROUP_ID;
    global $FB_API_CALL_CONFIG;

    try {
        $response = $fb->api("/$FB_GROUP_ID/feed");
    } catch (FacebookApiException $e) {
        log_error('Graph API', $e->getMessage());
        $response = FALSE;
    } catch (Exception $e) {
        log_error('General', $e->getMessage());
        $response = FALSE;
    }

    try {
        $response = $response['data'];
    } catch (Exception $e) {
        log_error('Response', 'Unable to parse output data');
        $response = FALSE;
    }
    return $response;
}

function render_fb_javascript() {
    global $FB_CONFIG;
    global $FB_GROUP_ID;

    echo <<<HTML
<script>
    Object.assign(IFTS.facebook, { appId: '${FB_CONFIG['app_id']}', groupId: '$FB_GROUP_ID' });
</script>
HTML;
}
?>

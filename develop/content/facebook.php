<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/php/facebook-sdk-v5/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/fb-config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/fb-helpers.php';

$THIS_PAGE = 'http://ifts.if.ua/page/facebook';
$SAVE_TOKEN_URL_PARAM = 'save-token';
$SAVE_TOKEN_URL = "$THIS_PAGE?$SAVE_TOKEN_URL_PARAM";

$TOKEN_FILENAME = $_SERVER['DOCUMENT_ROOT'] . '/php/fb-token.txt';

$FB_GROUP_ID = '453544624728446';
$FB_GROUP_PAGE = "https://www.facebook.com/groups/$FB_GROUP_ID/";

$FB_API_CALL_CONFIG = array(
    'fields' => 'id,message,full_picture,updated_time',
    'limit' => '10'
);

$fb = new Facebook\Facebook($FB_CONFIG);
$fb_helper = $fb->getRedirectLoginHelper();


render_fb_part();


// ------------------------ main ------------------------
function render_fb_part() {
    global $SAVE_TOKEN_URL_PARAM;
    global $TOKEN_FILENAME;

    if (isset($_GET[$SAVE_TOKEN_URL_PARAM])) {
        $token = get_login_token();
        if (isset($token)) {
            if ($token) {
                if (file_put_contents($TOKEN_FILENAME, $token)) {
                    render_saved_ok_part();
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

    } else {
        $token = file_exists($TOKEN_FILENAME) ? file_get_contents($TOKEN_FILENAME) : FALSE;
        if ($token) {
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
}


// ------------------------ helper functions ------------------------
function log_error($message, $err) {
    $err = str_replace("\n", '', $err);
    echo "<script>console.error('Facebook $message error:', '$err');</script>";
}


function render_login_part() {
    global $fb_helper;
    global $SAVE_TOKEN_URL;
    global $FB_GROUP_PAGE;

    $login_url = $fb_helper->getLoginUrl($SAVE_TOKEN_URL, array('email'));
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
    global $fb_helper;
    global $TOKEN_FILENAME;
    global $THIS_PAGE;

    $token = FALSE;
    try {
        $token = $fb_helper->getAccessToken();
    } catch (Facebook\Exceptions\FacebookResponseException $e) {
        log_error('Graph API', $e->getMessage());
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        log_error('SDK', $e->getMessage());
    }

    if ($token) {
        $oAuth2Client = $fb->getOAuth2Client();
        $token = $oAuth2Client->getLongLivedAccessToken($token);
    }

    return $token;
}



function get_posts_from_fb($token) {
    global $fb;
    global $FB_GROUP_ID;
    global $FB_API_CALL_CONFIG;

    try {
        $fb_app = $fb->getApp();
        $request = new Facebook\FacebookRequest(
            $fb_app,
            $token,
            'GET',
            "/$FB_GROUP_ID/feed",
            $FB_API_CALL_CONFIG
        );
        $response = $fb->getClient()->sendRequest($request);
    } catch (Facebook\Exceptions\FacebookResponseException $e) {
        log_error('Graph API', $e->getMessage());
        $response = FALSE;
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        log_error('SDK', $e->getMessage());
        $response = FALSE;
    }

    try {
        $response = $response->getDecodedBody();
        $response = $response['data'];
    } catch (Exception $e) {
        log_error('Response', 'Unable to parse output data');
        $response = FALSE;
    }
    return $response;
}


function render_posts($posts) {
    global $FB_GROUP_PAGE;

    foreach($posts as $post) {
        $url = get_post_url($post['id']);
        $date = get_post_date($post);

        echo '<article class="fb-post">';
        echo '<p class="date"><a class="link" href="' . $url . '" title="Перейти до допису">' . $date . '</a></p>';

        $img_class_name = array_key_exists('message', $post) ? 'wrapped' : '';
        if (array_key_exists('full_picture', $post)) {
            echo "<a href=\"$url\"><img class=\"$img_class_name\" src=\"${post['full_picture']}\"/></a>";
        }

        if (array_key_exists('message', $post)) {
            echo "<p class=\"text\">${post['message']}</p>";
        }
        echo '</article>';
    };

    echo "<h1><a class=\"link\" href=\"$FB_GROUP_PAGE\" title=\"Перейти на нашу сторінку\">Читати інші дописи на сторінці facebook</a></h1>";
}


function get_post_date($post) {
    $date = 'Перейти до допису';
    if (array_key_exists('updated_time', $post)) {
        preg_match('/(.*)T(\d\d:\d\d)/', $post['updated_time'], $parsed);
        if (count($parsed) === 3) {
            $date = "${parsed[1]} в ${parsed[2]}";
        }
    }

    return $date;
}


function get_post_url($id) {
    global $FB_GROUP_PAGE;
    preg_match('/.*_(.*)/', $id, $parsed);

    return $parsed && $parsed[1]
        ? "${FB_GROUP_PAGE}permalink/${parsed[1]}/"
        : 'javascript:void(0);';
}


function get_first_post_date($posts) {
    try {
        return new DateTime( $posts[0]['updated_time'] );
    } catch (Exception $e) {
        return new DateTime('1970-01-01');
    }
}


function get_time_diff($d1, $d2) {
    $diff = 0;
    try {
        $interval = $d1->diff($d2, TRUE);
        $diff = $interval->days;
    } catch (Exception $e) {}

    return $diff;
}
?>

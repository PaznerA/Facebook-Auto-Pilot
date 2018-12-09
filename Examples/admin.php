<?php
//ini_set('display_startup_errors', 1);
//ini_set('display_errors', 1);
//error_reporting(-1);
//error_reporting(E_ALL);

require '../bootstrap.php';
require '../Src/Controller/Helper.php';

if (!isset($_SESSION['userId']) || !isset($_SESSION['accessToken'])) {
    echo '<h1>Nejste přihlášen/a!</h1>';
    echo 'Pokračujte <a href="' . SITE_URL . '"><strong>tudy</strong> a klikněte na tlačítko "LogIn"</a>';
    die();
};
?>

<!DOCTYPE html>
<html>
<head>
    <title>Facebook 2 CMS</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="/Examples/../Src/Assets/Css/style.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script>
        window.fbAsyncInit = function () {
            FB.init({
                appId: '<?php echo FB_APP_ID; ?>',
                cookie: true,  // enable cookies to allow the server to access
                               // the session
                xfbml: true,  // parse social plugins on this page
                version: 'v2.8' // use graph api version 2.8
            });

            FB.getLoginStatus(function (response) {
                statusChangeCallback(response);
            });

        };
        // Load the SDK asynchronously
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/cs_CZ/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

    </script>
    <script src="/Examples/../Src/Assets/Js/FbEvents.js"></script>
    <meta charset="UTF-8">
</head>
<body>
<div class="container-fluid">
    <div class="row text-center">
        <div class="col-md-12">
            <h1>Vítejte, uživateli Č.: <?php echo $_SESSION['userId'] ?></h1>
        </div>
    </div>
    <div class="row text-center main_controls">
        <div class="overlay visible"></div>
        <div class="col-md-12">
            <button class="btn" onclick="getMyProfile();">Můj profil</button>
            <button class="btn" onclick="getPosts();">Moje příspěvky</button>
            <button class="btn" onclick="getEvents();">Moje události</button>
            <button class="btn" onclick="getGroups();">Výčet mých FB skupin</button>
            <button class="btn" onclick="getPages();">Výčet mých FB stránek</button>
        </div>
    </div>
    <div class="row" id="manager">
        <div class="col-md-2">
            <div id="sidebar" class="well sidebar-nav">
                <h5><i class="glyphicon glyphicon-home"></i>
                    <small><b>MANAGEMENT</b></small>
                </h5>
                <ul class="nav nav-pills nav-stacked">
                    <li><a class="" onclick="getMyProfile();">Můj profil</a></li>
                    <li><a class="" onclick="getPosts();">Moje příspěvky</a></li>
                    <li><a class="" onclick="getEvents();">Moje události</a></li>
                    <li><a class="" onclick="getMyAccount();">Výčet mých FB stránek</a></li>
                    <li><a class="" onclick="getGroups();">Výčet mých FB skupin</a></li>
                    <li><a class="" onclick="getPages();">Pages</a></li>
                    <li><a class="" onclick="fbLogout();">Odhlásit se z FB</span></a></li>
                </ul>
                <h5><i class="glyphicon glyphicon-user"></i>
                    <small><b>USERS</b></small>
                </h5>
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="#">List</a></li>
                    <li><a href="#">Manage</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <h2>Vytvořit příspěvek na FB</h2>
                <div class="timeline-item" onclick="fbDialog('share','https://mirahodina.cz/');">
                    <div class="animated-background facebook">
                        <div class="background-masker header-top"></div>
                        <div class="background-masker header-left"></div>
                        <div class="background-masker header-right"></div>
                        <div class="background-masker header-bottom"></div>
                        <div class="background-masker subheader-left"></div>
                        <div class="background-masker subheader-right"></div>
                        <div class="background-masker subheader-bottom"></div>
                        <div class="background-masker content-top"></div>
                        <div class="background-masker content-first-end"></div>
                        <div class="background-masker content-second-line"></div>
                        <div class="background-masker content-second-end"></div>
                        <div class="background-masker content-third-line"></div>
                        <div class="background-masker content-third-end"></div>
                    </div>
                </div>
            </div>
            <hr>
            <?php

            try {
                $fb = new Facebook\Facebook([
                    'app_id' => FB_APP_ID,
                    'app_secret' => FB_APP_SECRET,
                    'default_access_token' => $_SESSION['accessToken'],
                    'default_graph_version' => 'v2.8',
                ]);
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                echo 'data: ';
                echo '<br>';
                var_dump($fb);
                echo '<br>';
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            }

            try {
                // Requires the "read_stream" permission
                $response = $fb->get('/me/feed?fields=id,message&limit=5');
                // Page 1
                $feedEdge = $response->getGraphEdge();

                foreach ($feedEdge as $status) {
                    echo '<div class="row"><pre>';
                    var_dump($status->asArray());
                    echo '</pre></div>';
                }
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                echo '<br>';
                var_dump($fb);
                exit;
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                echo '<br>';
                var_dump($fb);
                exit;
            }

            ?>
            <div class="row" id="main">
            </div>

            <div class="row">
                <?php
                if(isset($_GET['page_id']) && $_GET['page_id']>0) {
                    $fb_page_id = $_GET['page_id'];
                    $fields = "id,message,picture,link,name,description,type,icon,created_time,from,object_id,likes,comments,shares";
                    $profile_photo_src = "https://graph.facebook.com/{$fb_page_id}/picture?type=square";
                    $limit = 20;
                    $json_link = "https://graph.facebook.com/" . $fb_page_id . "/feed?access_token=" . $_SESSION['accessToken'] . "&fields={$fields}&limit={$limit}";
                    $json = file_get_contents($json_link);
                    $obj = json_decode($json, true);

                    $feed_item_count = count($obj['data']);
                    for ($x = 0; $x < $feed_item_count; $x++) {
//                        echo "<pre>";
//                        var_dump($obj['data'][$x]);
//                        echo "</pre>";
//                        echo "<br>";

                        // to get the post id
                        $id = $obj['data'][$x]['id'];
                        $post_id_arr = explode('_', $id);
                        $post_id = $post_id_arr[1];

                        // user's custom message
                        $message = $obj['data'][$x]['message'];

                        // picture from the link
                        $picture = '';
                        $picture_url = '';
                        if(isset($obj['data'][$x]['picture'])){
                            $picture = $obj['data'][$x]['picture'];
                            $picture_url_arr = explode('&url=', $picture);
                            $picture_url = urldecode($picture_url_arr[1]);
                        }

                        // link posted
                        $link='';
                        if(isset($obj['data'][$x]['link'])){
                            $link = $obj['data'][$x]['link'];
                        }

                        // name or title of the link posted
                        $name = $obj['data'][$x]['name'];

                        $description = $obj['data'][$x]['description'];
                        $type = $obj['data'][$x]['type'];

                        // when it was posted
                        $created_time = $obj['data'][$x]['created_time'];
                        $converted_date_time = date('Y-m-d H:i:s', strtotime($created_time));
                        $ago_value = \Fb2CMS\Controller\Helper::formatTimeElapsed($converted_date_time);

                        // from
                        $page_name = $obj['data'][$x]['from']['name'];

                        // useful for photo
                        $object_id = $obj['data'][$x]['object_id'];

                        echo "<div class='row'>";

                        echo "<div class='col-md-4'>";

                        echo "<div class='profile-info'>";
                        echo "<div class='profile-photo'>";
                        echo "<img src='{$profile_photo_src}' />";
                        echo "</div>";

                        echo "<div class='profile-name'>";
                        echo "<div>";
                        echo "<a href='https://fb.com/{$fb_page_id}' target='_blank'>{$page_name}</a> ";
                        echo "shared a ";
                        if ($type == "status") {
                            $link = "https://www.facebook.com/{$fb_page_id}/posts/{$post_id}";
                        }
                        echo "<a href='{$link}' target='_blank'>{$type}</a>";
                        echo "</div>";
                        echo "<div class='time-ago'>{$ago_value}</div>";
                        echo "</div>";
                        echo "</div>";

                        echo "<div class='profile-message'>{$message}</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "<hr />";
                        echo "<div class='col-md-8'>";
                        echo "<a href='{$link}' target='_blank' class='post-link'>";

                        echo "<div class='post-content'>";

                        if ($type == "status") {
                            echo "<div class='post-status'>";
                            echo "View on Facebook";
                            echo "</div>";
                        } else {
                            if ($type == "photo") {
                                echo "<img src='https://graph.facebook.com/{$object_id}/picture' />";
                            } else {
                                if ($picture_url) {
                                    echo "<div class='post-picture'>";
                                    echo "<img src='{$picture_url}' />";
                                    echo "</div>";
                                }

                                echo "<div class='post-info'>";
                                echo "<div class='post-info-name'>{$name}</div>";
                                echo "<div class='post-info-description'>{$description}</div>";
                                echo "</div>";
                            }
                        }

                        echo "</div>";
                        echo "</a>";
                        echo "</div>";
                        echo "<div class='clearfix'></div>";
                    }
                }
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <h2>Fronta čekajících příspěvků</h2>
            <hr>
        </div>
    </div>
</div>
</body>
<script src="/Examples/../Src/Assets/Js/FbSiteTemplate.js"></script>
<script src="/Examples/../Src/Assets/Js/FbPostTemplate.js"></script>
<script src="/Examples/../Src/Assets/Js/FbGroupTemplate.js"></script>
<script src="/Examples/../Src/Assets/Js/FbEventTemplate.js"></script>
</html>

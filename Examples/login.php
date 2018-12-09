<?php
require '../bootstrap.php';

$postData = json_decode(json_encode($_POST));


if (!isset($postData->access_token) || !isset($postData->user_id)) {
    die("AccessToken or UserID empty!");
}


if (isset($_SESSION['userId']) && isset($_SESSION['accessToken'])) {
    die('logged_in');
}

$User = new \Fb2CMS\Model\User($postData->access_token, $postData->user_id);
if($User->checkTokenExpiration()){
    $_SESSION['userId'] = $User->getUserId();
    $_SESSION['accessToken'] = $User->getAccessToken();
    die('logged_in');
}

die('Unknown problem! Contact admin please.');
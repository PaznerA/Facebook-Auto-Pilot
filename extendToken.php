<?php
require 'bootstrap.php';

$postData = json_decode(json_encode($_POST));


if (!isset($postData->access_token) || !isset($postData->user_id)) {
    die("AccessToken or UserID empty!");
}


if (isset($_SESSION['userId']) && isset($_SESSION['accessToken'])) {
    die('logged_in');
}

$row = $database->nativeQuery('SELECT * FROM tokens WHERE user_id = "' . $postData->user_id . '"');
$vyst = $row->fetchAll();
if(count($vyst) === 1){
    $_SESSION['userId'] = $vyst[0]->user_id;
    $_SESSION['accessToken'] = $vyst[0]->token;
    $_SESSION['expiresAt'] = $vyst[0]->expires_at;
    die('logged_in');
}

$accessToken = $postData->access_token;
$baseUri = $config->facebook->tokenExtendUrl;
$appId = $config->facebook->appId;
$appSecret = $config->facebook->appSecret;
$completePath = $baseUri . '?client_id=' . $appId . '&client_secret=' . $appSecret . '&grant_type=fb_exchange_token&fb_exchange_token=' . $accessToken . '';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $completePath);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_ENCODING, "");
$result = curl_exec($ch);
curl_close($ch);

$data = json_decode($result);
$expireAt = time() - 3600 + (int) $data->expires_in;
$resp = $database->insert(
    'tokens',
    [
        'user_id' => $postData->user_id,
        'token' => $data->access_token,
        'expires_at' => $expireAt,
    ]);
try{
    $resp->execute();
}catch (Dibi\Exception $e){
    die('Nastala chyba');
}

$_SESSION['userId'] = $postData->user_id;
$_SESSION['accessToken'] = $data->access_token;
$_SESSION['expiresAt'] = $expireAt;

die('logged_in');


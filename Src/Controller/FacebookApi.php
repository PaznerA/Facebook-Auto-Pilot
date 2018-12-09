<?php declare(strict_types = 1);


namespace FB2CMS\Controller;


use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;

class FacebookApi
{
    private $FB;

    public function __construct()
    {
        try {
            $this->FB = new Facebook([
                'app_id' => FB_APP_ID,
                'app_secret' => FB_APP_SECRET,
                'default_access_token' => $_SESSION['accessToken'],
                'default_graph_version' => 'v2.8',
            ]);
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            die('Graph returned an error: ' . $e->getMessage());
        }

    }

    public function post($endpoint){
        try {
            $response = $this->FB->post(
                '/page-id/feed',
                array (
                    'message' => 'This is a test message',
                ),
                '{access-token}'
            );
        } catch(FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $graphNode = $response->getGraphNode();
    }

}
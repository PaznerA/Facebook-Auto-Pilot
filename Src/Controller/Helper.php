<?php declare(strict_types = 1);

namespace Fb2CMS\Controller;


class Helper
{

    /**
     * @param string $token
     * @return \stdClass
     */
    public static function extendToken(string $token): \stdClass
    {
        $completePath = FB_TOKEN_EXTEND_URL .
            '?client_id=' . FB_APP_ID .
            '&client_secret=' . FB_APP_SECRET .
            '&grant_type=fb_exchange_token&fb_exchange_token=' . $token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $completePath);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result);
        $data->expires_at = time() - 3600 + (int) $data->expires_in;
        return $data;
    }

}
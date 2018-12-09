<?php

namespace Fb2CMS\Controller;


class Helper
{

    /**
     * @param string $token
     * @return \stdClass
     */
    public static function extendToken(string $token)
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

    public static function formatTimeElapsed($datetime, $full = false)
    {
        $now = new \DateTime;
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

}
<?php

namespace App\Handlers;

use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class SlugTranslateHandler
{
    public function translate($text)
    {
        $http = new Client;

        $api = 'http://openapi.youdao.com/api?';
        $appid = config('services.youdao_translate.APP_KEY');
        $key = config('services.youdao_translate.SEC_KEY');
        $salt = rand(10000, 99999);

        if (empty($appid) || empty($key)) {
            return $this->pinyin($text);
        }

        $sign = md5($appid . $text . $salt . $key);

        $query = http_build_query([
            'q' => $text,
            'from' => 'zh-CHS',
            'to' => 'EN',
            'appKey' => $appid,
            'salt' => $salt,
            'sign' => $sign
        ]);

        $response = $http->get($api . $query);

        $result = json_decode($response->getBody(), true);

        if (isset($result['translation'][0])) {
            return str_slug($result['translation'][0]);
        } else {
            return $this->pinyin($text);
        }
    }

    public function pinyin($text)
    {
        return str_slug(app(Pinyin::class)->permalink($text));
    }
}
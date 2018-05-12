<?php
/**
 * Created by PhpStorm.
 * User: goforbroke
 * Date: 12.05.18
 * Time: 13:13
 */

namespace App\Service;


class YandexService
{
    public function matches(string $query, callable $cb)
    {
        $url = 'https://geocode-maps.yandex.ru/1.x/?format=json&geocode=' . $query;
        $res = file_get_contents($url);
        $res = json_decode($res, true);
        $res = $res["response"]["GeoObjectCollection"]["featureMember"];

        foreach ($res as $addr) {
            $text = $addr["GeoObject"]["metaDataProperty"]["GeocoderMetaData"]["text"];
            $cb($addr["GeoObject"], $text);
        }
    }
}
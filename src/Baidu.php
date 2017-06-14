<?php

namespace tools;

/**
 * Created by PhpStorm.
 * User: xialiangyong
 * Date: 2017/6/12
 * Time: 10:43
 */
class Baidu
{
    public static function query($query, $region)
    {
        $data = [];
        $pageNum = 0;
        $pageSize = 100;
        $is = true;
        do {
            $url = self::getUrl($query, $region, $pageNum, $pageSize);
            $res = self::get($url);
            if (empty($res)) {
                $is = false;
            } else {
                $res_arr = json_decode($res, true);
                if ($res_arr['status'] == 0) {
                    $data = array_merge($data, $res_arr['results']);
                    $page = ceil($res_arr['total'] / $pageSize);
                    $pageNum++;
                    if ($pageNum > $page) {
                        $is = false;
                    }
                } else {
                    $is = false;
                }
            }
        } while ($is);

        return $data;
    }

    public static function getUrl($query, $region, $page_num, $pagesize)
    {
        $url = 'http://api.map.baidu.com/place/v2/search?query=' . $query . '&page_size=' . $pagesize . '&page_num=' . $page_num . '&scope=1&region=' . $region . '&output=json&ak=' . self::getBk();
        return $url;
    }

    public static function getBk()
    {
        return '*****************';
    }

    public static function getAddress($lat, $lon)
    {
        $url = 'http://api.map.baidu.com/geocoder/v2/?location=' . $lat . ',' . $lon . '&output=json&pois=1&ak=' . self::getBk();
        $res = self::get($url);
        $res_arr = json_decode($res, true);
        if ($res_arr['status'] == 0) {
            $address = $res_arr['result']['addressComponent'];
            return $address;
        } else {
            return '';
        }
    }

    /**
     * 发送get请求
     * @param $url
     * @return mixed
     */
    public static function get($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

}
<?php

namespace tools;

class Http
{
    //抓取数据
    public static function post($url)
    {
        $ch = curl_init();
        if (false !== strpos($url, 'https')) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        // 设置 url
        curl_setopt($ch, CURLOPT_URL, $url);
        // 设置浏览器的特定header
        curl_setopt($ch, CURLOPT_HTTPHEADER, []);
        // 页面内容我们并不需要
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        // 只需返回HTTP header
        curl_setopt($ch, CURLOPT_HEADER, 0);
        // 返回结果，而不是输出它
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        ob_start();
        curl_exec($ch);
        $html = ob_get_contents();
        ob_end_clean();
        curl_close($ch);
        return mb_convert_encoding($html, 'utf-8', 'GBK,UTF-8,ASCII');

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
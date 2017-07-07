<?php

/**
 * ApiSignatureTrait Class
 * trait since PHP 5.4.0
 */
trait ApiSignatureTrait
{
    /**
     * Generate signature
     * 签名方式可自定义
     * @param $param
     * @param $secret
     * @return string
     */
    protected static function createSignature($param, $secret)
    {
        ksort($param);
        return sha1(http_build_query($param) . $secret);
    }

}
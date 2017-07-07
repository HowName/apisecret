<?php
/**
 * Produce Api Signature Util Class
 * 生产Signature类，请求方使用
 */
class ProduceApiSignatureUtil
{
    use ApiSignatureTrait;

    /**
     * The appid
     * @var string
     */
    private static $appid = 'appid';

    /**
     * Keep the secret key hidden,Even if the encryption algorithm is cracked,it's safe
     * secret 不可外泄
     * @var string
     */
    private static $secret = 'secret';

    /**
     * Build request parameters
     * @param array $param
     * @return array
     */
    public static function build(array $param)
    {
        $param['appid'] = self::$appid;
        $param['timestamp'] = time();
        $param['nonce'] = self::createNonceStr();
        $param['signature'] = self::createSignature($param, self::$secret);
        return $param;
    }

    /**
     * Create random string
     * @param int $length
     * @return string
     */
    private static function createNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++)
        {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

}
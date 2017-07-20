<?php
/**
 * Consume Api Signature Util Class
 * 消耗-检查Signature类，验证方使用
 */
namespace Secret;

class ConsumeApiSignatureUtil
{
    use ApiSignatureTrait;

    /**
     * Valid appid array
     * format as appid => secret
     * the secret need be keep hide and can not appear in the request parameter
     * @var array
     */
    protected static $appIdArr = [
        'appid' => 'secret',//多个项目的appid与secret
    ];


    /**
     * Check the validity of the request parameter
     * @param array $option Usually POST parameter
     * @return bool|string  Verify successful return true,other else string type notice
     */
    public static function checkSignature(array $option)
    {
        if (empty($option['signature']))
        {
            return 'signature miss';
        }

        if (empty($option['appid']))
        {
            return 'appid miss';
        }

        if (empty($option['timestamp']))
        {
            return 'timestamp miss';
        }

        if (empty($option['nonce']))
        {
            return 'nonce miss';
        }

        $signature = $option['signature'];
        $appid = $option['appid'];
        $timestamp = $option['timestamp'];
        $nonce = $option['nonce'];

        //当前时间的前后20分钟内有效,防止重放攻击
        //真实保证请求的唯一性,防止重放攻击需要利用redis保存20分钟有效期的nonce+timestamp,如redis有此记录表示该请求已被消耗
        $curTime = time();
        if ($timestamp > ($curTime + 1200) || $timestamp < ($curTime - 1200))
        {
            return 'timestamp error';
        }

        if (!in_array($appid, array_keys(static::$appIdArr)))
        {
            return 'appid error';
        }

        $secret = static::$appIdArr[$appid];
        unset($option['signature']);//signature不参与生成签名
        $createSign = static::createSignature($option, $secret);//后期静态绑定 since PHP 5.3.0

        if ($signature != $createSign)
        {
            return 'signature error';
        }

        return true;
    }


}
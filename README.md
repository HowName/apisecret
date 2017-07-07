# apisecret
api请求加密安全工具类,包含生成签名，检查签名

## 文件详解
- ApiSignatureTrait.php

  生成签名类,将请求参数按字典排序后拼接secret后sha1加密生成签名，可额外自定义加密算法

- ConsumeApiSignatureUtil.php

  检查Signature类，验证方使用
 
- ProduceApiSignatureUtil.php

  生产组装api请求参数工具类，请求方使用，secret不可外泄，即使加密算法被破解，api也是安全的

 ## 使用方法
 
```php
//生成请求参数
$requestParam = ProduceApiSignatureUtil::build(['user'=>'abc','pass'=>'abc']);

----------------------------------------------

//验证请求参数
$checkStatus = ConsumeApiSignatureUtil::checkSignature($_POST);

if(is_string($checkStatus)){
    //失败
}else{
    //成功
}

```

 

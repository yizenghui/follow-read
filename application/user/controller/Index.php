<?php

namespace app\user\controller;


use yizenghui\Support\Wechat;


class Index
{

    public function index()
    {
        $options = array(
            'token'=>'sak1', //填写你设定的key
            'encodingaeskey'=>'', //填写加密用的EncodingAESKey
            'appid'=>'wx702b93aef72f3549', //填写高级调用功能的app id, 请在微信开发模式后台查询
            'appsecret'=>'8b69f45fc737a938cbaaffc05b192394' //填写高级调用功能的密钥
        );
        $weObj = new Wechat($options); //创建实例对象
        $user = $weObj->getUserInfo("o7UTkjtXBV1sgEvLtzVMs2t--nD8");
        var_export($user);
    }
}


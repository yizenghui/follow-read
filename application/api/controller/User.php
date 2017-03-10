<?php
namespace app\api\controller;
use think\Request;
use \app\api\model\User as UserModel;
use yizenghui\Support\Wechat as WechatServer;

class User
{
    // 用户签名 (当前用户)
    public function sign()
    {

        sign(null);
        $sign = sign();
//        dump($sign);die;
        if($sign){
            return $sign;
        }

        $open_id = "o7UTkjtXBV1sgEvLtzVMs2t--nD8";
        $user = UserModel::where(['open_id'=>$open_id])->find();
        // 设置用户签名
        sign($user);
//        dump($user);
        return $user->toArray();
    }


    // 用户签名 (当前用户)
    public function printsign()
    {

        $sign = sign();
                dump($sign->follows());die;

    }
}
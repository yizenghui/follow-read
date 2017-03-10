<?php
namespace app\api\controller;
use think\Request;
use yizenghui\Support\Wechat as WechatServer;
use \app\api\model\User as UserModel;

// TODO 把开源的SDK功能集合到本地项目需要


// 微信服务接口
class Wechat
{

    /**
     * @param Request $request
     * @return array
     */
    public function user(Request $request){
        $open_id = $request->get('open_id');
        $open_id = "o7UTkjtXBV1sgEvLtzVMs2t--nD8";
        $options = array(
            'token'=>'sak1', //填写你设定的key
            'encodingaeskey'=>'', //填写加密用的EncodingAESKey
            'appid'=>'wx702b93aef72f3549', //填写高级调用功能的app id, 请在微信开发模式后台查询
            'appsecret'=>'8b69f45fc737a938cbaaffc05b192394' //填写高级调用功能的密钥
        );
        $weObj = new WechatServer($options); //创建实例对象
        $data = $weObj->getUserInfo($open_id);

        // openid

        $open_id = "o7UTkjtXBV1sgEvLtzVMs2t--nD8";
        $user = UserModel::where(['open_id'=>$open_id])->find();
        if(!$user){
            $new = array(
                'nickname' => $data['nickname'],
                'open_id' => $data['openid'],
                'head' => $data['headimgurl'],
                'subscribe' => 1,
            );
            UserModel::create($new);
        }
        return $data;
    }





}
<?php

namespace yizenghui\Support;

// 暂时用tp自带的session先，以后考虑使用其它的
use think\Session;

class Sign
{
	/**
	 *  设置用户签名
	 */
	static public function set($sign){
		if($sign && $sign->id){
			Session::set('sign',$sign->id);
		}else{
			Session::set('sign',$sign);
		}
	}

	/**
	 *	获取用户签名
	 */
	static public function get(){
		$sign = Session::get('sign');
		if($sign && is_numeric($sign)){
			return \app\api\model\User::find($sign);
		}
		return $sign;
	}
}

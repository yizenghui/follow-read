<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


/**
 * 用户签名
 * @param bool|false $sign
 * @return bool|mixed
 */
function sign($sign = false){
    if($sign === false){
        $sign =         \yizenghui\Support\Sign::get();
        return $sign;
    }
    \yizenghui\Support\Sign::set($sign);
    return $sign;
}


/**
 * 检查用户是否已经关注某本书
 * @param \app\api\model\User $user
 * @param \app\api\model\Book $book
 * @return bool
 */
function checkUserFollowBook( \app\api\model\User $user, \app\api\model\Book $book ){
    return \app\api\model\Follow::checkUserIsFollowTheBook($user,$book);
}
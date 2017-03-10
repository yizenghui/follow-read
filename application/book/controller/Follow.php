<?php
namespace app\book\controller;

class Follow
{

    /**
     * 已经关注的书籍(用户)
     * @return \think\response\View
     */
    public function index()
    {
        $user = sign();
        if($user){

            $books = $user->follows;
//            var_export($books);die;
//            dump($books);die;
            return view('index',compact('books','user'));
        }
        return '未登录';
    }
}
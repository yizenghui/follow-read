<?php
namespace app\book\controller;

use think\response\View;

class Index
{
    // 返回书籍列表
    public function index()
    {
        $books = \app\api\model\Book::all();

        return view('index',['books'=>$books]);
    }
}

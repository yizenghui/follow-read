<?php
namespace app\book\controller;

use think\Request;
use yizenghui\Support\Str;
use \yizenghui\Spider\Book as BookSpider;

class Create
{
    // 书籍添加
    public function index()
    {
        $value = Str::is('foo*', 'foobar');echo $value;
        $value = Str::mate('hello,*', 'hello,my friend');dump($value) ;
        return view('index');
    }


    public function save(Request $request){
        $book = new BookSpider($request->post('url'));

        dump($book->info());
        dump($book->chapter());

/*
        $url_info = $this->explain($request->post('url'));

        // TODO 加入任务检查队列

        // TODO 检查书籍相关信息(本站服务器)


        // 获取源站书箱数据
        $info = $this->getQiDianBookInfo($url_info['id']);
        dump($info);

        // 获取源站书箱数据
        $chapter = $this->getQiDianBookChapter($url_info['id']);
        dump($chapter);*/
    }


}
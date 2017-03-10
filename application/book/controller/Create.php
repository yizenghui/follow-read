<?php
namespace app\book\controller;

use think\Request;
use yizenghui\Support\Str;
use \yizenghui\Spider\Book as BookSpider;
use \app\book\model\Book;

class Create
{
    // 书籍添加
    public function index()
    {
        $value = Str::is('foo*', 'foobar');echo $value;
        $value = Str::mate('hello,*', 'hello,my friend');dump($value) ;
        return view('index');
    }

    public function post(Request $request){
        $spider_book = new BookSpider($request->post('url'));
        $data = $spider_book->data();
        if($data){
            $book = Book::get(['source_from' => $data['source_from']]);
            if($book){

            }

            dump($book);
        }

        return '';
    }

    public function test()
    {

        $book = new BookSpider('http://book.qidian.com/info/1001389020');
        dump($book->data());
//        dump($book->chapter());
    }


    public function save(Request $request)
    {
        $spider_book = new BookSpider($request->post('url'));
        $data = $spider_book->data();
        if($data){
            $book = Book::get(['source_from' => $data['source_from']]);
            if($book){

            }

            dump($book);
        }

//        $book = Book::firstOrCreate();

        //        $book = Book::firstOrCreate();

//        dump($book->info());
//        dump($book->chapter());

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
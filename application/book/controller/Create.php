<?php
namespace app\book\controller;

use think\Request;
use yizenghui\Support\Str;

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
        $url_info = $this->explain($request->post('url'));

        // TODO 加入任务检查队列

        // TODO 识别数据库是否有相同的书箱?
        $info = $this->getQiDianBookInfo($url_info['id']);
        dump($info);
    }

    /**
     * 从起点小书网，获取书箱详细信息
     * @param $id
     * @return array
     */
    private function getQiDianBookInfo($id){
        $spider = new \yizenghui\spider\QiDian\BookInfo($id);
        $info = $spider->chapter();
        return $info;
    }

    /***
     * 通过用户输入的一个url,解释这个url里面的平台、BOOK_ID等信息
     * @param $url
     * @return array
     */
    protected function explain($url){
        // TODO 这里面应该外包给其它的包去处理
        return $this->getParamFromUrl($url);
    }

    /**
     * 解释url返回相关书籍参数
     * @param $url
     * @return array
     */
    private function getParamFromUrl($url){
        // TODO
//        dump($url);
        $url_data = parse_url($url);
//        print_r($url_data);
        return $this->explainQiDianBookUrl($url_data);
    }

    /**
     * 解释起点小说链接参数
     * @param $url_data
     * @return array
     */
    private function explainQiDianBookUrl($url_data){
        //  TODO
        return [
            'scheme'=>'http',
            'host'=>'book.qidian.com',
            'id'=>'1004974688' //1004974688  1005031521
        ];
    }

}
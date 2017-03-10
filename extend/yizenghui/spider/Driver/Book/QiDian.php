<?php
namespace  yizenghui\Spider\Driver\Book;

use QL\QueryList;
use yizenghui\Spider\Driver\Book\Common\basic;
use yizenghui\Support\Str;

/**
 * Class QiDian
 * @package yizenghui\Spider\Driver\Book
 */
class QiDian implements basic
{

    /**
     * @var
     */
    protected $book_id;

    /**
     * @var
     */
    protected $book_info_html;


    public function __construct(){}

    /**
     * @param int $book_id
     */
    public function init($book_id){
        $this->book_id = $book_id;
    }

    /**
     * 获取QiDian的详细页html(只获取一次)
     * @return mixed
     */
    public function getInfoHtml(){
        if($this->book_info_html){
            return $this->book_info_html;
        }
        $ql = QueryList::Query($this->url(),[]);
        $this->book_info_html = $ql->getHtml(false);
        return $this->book_info_html;
    }

    /**
     * 根据book_id信息，返回可访问的url (章节主页)
     * @return string
     */
    public function url(){
        return 'http://book.qidian.com/info/'.$this->book_id;
    }


    public function chapterApiUrl(){
        return 'http://book.qidian.com/ajax/book/category?_csrfToken=&bookId='.$this->book_id;
    }


    public function position(){
        return 'qidian.com&'.$this->book_id;
    }

    /**
     * 获取QiDian的详细数据
     * @return mixed
     */
    public function info()
    {
        //采集规则
        $reg = array(
            //采集文章标题
            'name' => array('.book-info h1 em','text'),
            'author' => array('.book-info h1 a','text'),
//            'intro' => array('.book-info .intro','text'),
//            'book-state' => array('.book-state','html'),
            'intro' => array('.book-intro p:eq(0)','text'),

        );
        $data = QueryList::Query($this->getInfoHtml(),$reg)->data;
        return current($data);
    }

    /**
     * 获取QiDian章节列表
     * @return mixed
     */
    public function chapter(){


        $reg_list = array(
            // 章节标题
            'title' => array('.catalog-content-wrap .volume-wrap a','text'),
            // 章节链接
            'link' => array('.catalog-content-wrap .volume-wrap a','href'),
        );
        $list = QueryList::Query($this->getInfoHtml(),$reg_list)->data;
        $chapters = [];
        if($list && is_array($list)){
            foreach($list as $item){
                if( Str::is('//read.qidian.com/chapter/*',$item['link']) ){
                    // 普通章节
                    $chapters[] = $item;
                }elseif( Str::is('//vipreader.qidian.com/chapter/*',$item['link']) ){
                    // VIP 章节
                    $chapters[] = $item;
                }
            }
        }

        // 有部分书籍的章节是ajax加载的,需要扩展
        if(empty($chapters)){
            // 目前可以直接通过 file_get_contents 获取json PS 通过 http://book.qidian.com/info/3544491 可以知道 _csrfToken 只是用js获取浏览器 cookie
            $json_str = file_get_contents($this->chapterApiUrl());
            $data = json_decode($json_str,true);
            if($data && is_array($data)){
                if($data['data']['vs'] && is_array($data['data']['vs'])){
                    foreach($data['data']['vs'] as $volume){
                        if($volume['cs'] && is_array($volume['cs'])){
                            foreach($volume['cs'] as $item){
                                // VIP状态
                                if($volume['vS'] ==1){
                                    $link_url = '//vipreader.qidian.com/chapter/'.$this->book_id.'/'.$item['id'];
                                }else{
                                    $link_url = '//read.qidian.com/chapter/'.$item['cU'];
                                }

                                $chapters[]  = ['title'=>$item['cN'],'link'=>$link_url];
                            }
                        }
                    }
                }
            }
        }
//print_r($chapters);die;
        return $chapters;
    }

}

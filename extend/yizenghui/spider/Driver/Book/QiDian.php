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
        return $chapters;
    }

}

<?php
namespace yizenghui\Spider;


/**
 * 书籍统一操作类
 * Class BookInfo
 * @package spider\QiDian
 * @Author 易增辉
 */
class Book
{

    /**
     *
     * @var \yizenghui\Spider\Driver\Book\Common\basic 实例化书籍采集对象
     */
    private $book_spider;


    /**
     * @var array 书箱的配置信息(由$book_url获取)
     */
    private $book_config;

    /**
     * 初始化此类，必须传入book url
     * Book constructor.
     * @param $book_url
     */
    public function __construct($book_url){
        $this->book_config = (new Driver\Book\Common\explain)->url($book_url);
        if( !$this->book_config ){
            // 抛出错误
        }

        $this->book_spider = $this->CreateSpider($this->book_config['driver']);
        if( !$this->book_spider ){
            // 抛出错误
        }
        $this->book_spider->init($this->book_config['id']);
    }

    /**
     * 动态实例化采集类
     * @param $driver
     * @return mixed
     */
    public function CreateSpider( $driver )
    {
        $class = "\\yizenghui\\Spider\\Driver\\Book\\$driver";
        if(class_exists($class)) return new $class();
        return false;
    }

    /**
     * 数据包
     * @return mixed
     */
    public function data(){
        $info = $this->info();
//        dump($info);die;
        $chapter = $this->chapter();
        $end_chapter = end($chapter);
        $info['end_chapter'] = $end_chapter;

        $info['source_from'] = $this->book_spider->position();
        return $info;
    }

    /**
     * 获取书籍详细信息
     * @return mixed
     */
    public function info(){
        return $this->translateInfo($this->book_spider->info());
    }

    /**
     * 获取书籍所有章节
     * @return mixed
     */
    public function chapter(){
        return $this->book_spider->chapter();
    }

    /**
     * 获取$book_config
     */
    public function conf(){
        return $this->book_config;
    }

    /**
     * 把采集来的详细数据翻译成我们平台使用的数据
     */
    public function translateInfo($info){
        //TODO 这个以后再考虑可视化，但是要先根据不同的站点的数据做个转化先
        return $info;
    }

    /**
     * 把采集来的列表数据翻译成我们平台使用的数据
     */
    public function translateChapter($chapter){
        //TODO 这个以后再考虑可视化, 但是要先根据不同的站点的数据做个转化先
        return $chapter;
    }
}

<?php
namespace app\api\model;

use think\Model;

class Book extends Model
{
    protected $table = 'books';

    protected $type = [
        'end_chapter'      =>  'array',
    ];



    public function follows()
    {
        return $this->belongsToMany('User','follows','user_id','book_id');
    }

    /**
     * 获取需要通过任务形式更新的书籍
     */
    static public function task(){
        return self::where('sync_time','<',time())->where('next_sync','<',time());
    }

}
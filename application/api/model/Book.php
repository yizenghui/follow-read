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
}
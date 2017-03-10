<?php
namespace app\api\model;

use think\Model;

class User extends Model
{
    protected $table = 'users';

    /**
     *
     */
    public function firstOrNew($option){

    }

    /**
     * @return \think\model\relation\BelongsToMany
     */
    public function follows(){
        return $this->belongsToMany('Book','follows','book_id','user_id');
    }
}
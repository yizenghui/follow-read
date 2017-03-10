<?php
namespace app\api\model;

use think\Model;
use \app\api\model\User;
use \app\api\model\Book;

class Follow extends Model
{
    protected $table = 'follows';


    /**
     * 检查用户是否已经关注书籍
     * @param \app\api\model\User $user
     * @param \app\api\model\Book $book
     * @return bool
     */
    static public function checkUserIsFollowTheBook(User $user,Book $book){
        if($user){
            static $follows;
            if( $follows[$user->id] === null ){
                $follows[$user->id] = $user->follows;
            }
            if($follows[$user->id]){
                foreach($follows[$user->id] as $follow){
                    if($follow->id == $book->id)
                        return true;
                }
            }
        }
        return false;
    }

}
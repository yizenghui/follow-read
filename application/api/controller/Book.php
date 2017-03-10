<?php
namespace app\api\controller;


use think\Request;
use \yizenghui\Spider\Book as BookSpider;
use \app\api\model\Book as BookModel;
use \app\api\model\User as UserModel;

class Book
{


    /**
     * @param Request $request
     * @return array|bool
     */
    public function get(Request $request){
        // TODO 数据验证、异常等
        $spider_book = new BookSpider($request->get('url'));
        $data = $spider_book->data();
        if($data){
            $book = BookModel::get(['source_from' => $data['source_from']]);
            if($book){
                //  TODO 比较、更新
//                $book->data($data);
//                $book->save($book);
                $array = $book->toArray();

            }else{
                $book = BookModel::create($data);
                $array = $book->toArray();
            }

            return $array;
        }

        return false;
    }


    /**
     * 关注书籍接口
     * @param Request $request
     */
    public function follow(Request $request){
        $id = $request->get('id');
        $book = BookModel::get($id);
        $sign = sign();
        if($sign){
            // 如果用户没有关注这本书
            if(!checkUserFollowBook($sign,$book)){
                $book->follows()->save($sign);
                return true;
            }
        }
        return false;
    }

    /**
     * 取消关注
     * @param Request $request
     * @return bool
     */
    public function unfollow(Request $request){
        $id = $request->get('id');
        $book = BookModel::get($id);
        $sign = sign();
        if($sign){
            // 如果用户没有关注这本书
            if(checkUserFollowBook($sign,$book)){
                $book->follows()->detach($sign->id);
                return true;
            }
        }
        return false;
    }

}
<?php
namespace app\book\controller;
use think\Request;
use \app\api\model\Book as BookModel;

class Info
{
    // 书籍详细
    public function index(Request $request)
    {
        $id = $request->get('id');
        if($id){
            $book = BookModel::find($id);
            if($book){
                return view('index',compact('book'));
            }
        }
        return view('error');
    }
}
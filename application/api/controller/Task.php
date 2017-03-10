<?php
namespace app\api\controller;

use think\Request;
use \app\api\model\Book;
use \yizenghui\Spider\Book as BookSpider;
use yizenghui\Support\Wechat as WechatServer;

class Task
{

    /**
     * TODO 分布式采集服务
     *
     * 由子采集器去采集和提交数据更新
     */

    /**
     * @param Request $request
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function index(Request $request){
        //where(['sync_time'=>['lt',time()]])->
        $books  = Book::task()->select();
        if($books){
            foreach($books as $book){
                if(!$book->sync_interval){
                    $book->sync_interval = 10*60;
                }
                $book->next_sync = time() + $book->sync_interval;
                $book->save();
            }
        }
        return $books;
    }


    public function post(Request $request){
        \yizenghui\Spider\Driver\Book\Common\position::en('http://book.qidian.com/info/1003723851');
        echo \yizenghui\Spider\Driver\Book\Common\position::de("qidian.com&1003723851");

    }


    /**
     * 本地服务器执行一本书籍的同步更新
     * @param Request $request
     * @return bool
     */
    public function run(Request $request){
        $book_id = $request->get('id');
        $book = Book::find($book_id);
        if($book){
            $book_url = \yizenghui\Spider\Driver\Book\Common\position::de($book->source_from);
            $spider_book = new BookSpider($book_url);
            $data = $spider_book->data();
            if($data['end_chapter'] == $book->end_chapter){
                return false;
            }else{
                $book->end_chapter = $data['end_chapter'];
                $book->sync_time = time();
                $book->save();
                return true;
            }
        }
        return false;
    }


    /**
     * 本地服务器进行书籍更新通知
     * @param Request $request
     * @return bool
     */
    public function notice(Request $request){
        $book_id = $request->get('id');
        $book = Book::find($book_id);
        if($book){
            $fans = $book->follows;
            if($fans){
                foreach($fans as $fan){

                    $ret = $this->bookUpdatePushNotice($fan->open_id,$book);
                    print_r($ret);
                }
            }
        }
        return false;
    }

    /**
     *
     */
    public function bookUpdatePushNotice($open_id,$book){
        // 9S_pcl3gklUmE7jOrHa2mTOcGPhj5_wnuWt2F6MH_qQ

        // book_name end_chapter_title

//        $open_id = "o7UTkjr7if4AQgcPmveQ5wJ5alsA";
        $options = array(
            'token'=>'sak1', //填写你设定的key
            'encodingaeskey'=>'', //填写加密用的EncodingAESKey
            'appid'=>'wx702b93aef72f3549', //填写高级调用功能的app id, 请在微信开发模式后台查询
            'appsecret'=>'8b69f45fc737a938cbaaffc05b192394' //填写高级调用功能的密钥
        );
        $weObj = new WechatServer($options); //创建实例对象

        /**
         {
        "touser":"OPENID",
        "template_id":"ngqIpbwh8bUfcSsECmogfXcV14J0tQlEpBO27izEYtY",
        "url":"http://weixin.qq.com/download",
        "topcolor":"#FF0000",
        "data":{
        "参数名1": {
        "value":"参数",
        "color":"#173177"	 //参数颜色
        },
        "Date":{
        "value":"06月07日 19时24分",
        "color":"#173177"
        },
        "CardNumber":{
        "value":"0426",
        "color":"#173177"
        },
        "Type":{
        "value":"消费",
        "color":"#173177"
        }
        }
        }
         */

        $data = [
            "touser"=>$open_id,
            "template_id"=>"9S_pcl3gklUmE7jOrHa2mTOcGPhj5_wnuWt2F6MH_qQ",
            "url"=>$book->end_chapter['link'],
            "topcolor"=>"#FF0000",
            "data"=>[
                "book_name"=>[
                    "value"=>$book->name,
                    "color"=>"#173177"
                ],
                "end_chapter_title"=>[
                    "value"=>$book->end_chapter['title'],
                    "color"=>"#173177"
                ],
            ]

        ];
/*        $data = [
            "touser"=>$open_id,
            "template_id"=>"iqS-IfWC4tNsHSL8VnTD3YHDh_ZClY2c9B4l1ebqaMs",
            "url"=>"http://weixin.qq.com/download",
            "topcolor"=>"#FF0000",
            "data"=>[
                "Nickname"=>[
                    "value"=>'aa',
                    "color"=>"#173177"
                ],
                "Info"=>[
                    "value"=>'bb',
                    "color"=>"#173177"
                ],
            ]

        ];*/
//        print_r($data);die;
        return $weObj->sendTemplateMessage($data);
    }


    private function sync($id,$data){

    }
}
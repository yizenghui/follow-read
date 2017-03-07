<?php
namespace yizenghui\Spider\Driver\Book\Common;

use yizenghui\Support\Str;

/**
 * Class explain URL 分析类
 * @package yizenghui\Spider\Driver\Book\Common
 */
class  explain
{


      /***
       * 通过用户输入的一个url,解释这个url里面的平台、BOOK_ID等信息
       * @param $url
       * @return array
       */
      public function url($url){
            // TODO 这里面应该外包给其它的包去处理
            return $this->getParamFromUrl($url);
      }

      /**
       * 解释url返回相关书籍参数
       * @param $url
       * @return array
       */
      private function getParamFromUrl($url){
            $url_data = parse_url($url);
            // TODO 多平台URL识别及使用相应解释
            return $this->explainQiDianBookUrl($url_data);
      }

      /**
       * 解释起点小说链接参数
       * @param $url_data
       * @return array
       */
      private function explainQiDianBookUrl($url_data){
            // TODO  手机PC版本等URL兼容性解释
            // PC uri get book id
            $id = Str::mate('/info/*',$url_data['path']);
            return [
                'scheme'=>'http',
                'host'=>'book.qidian.com',
                'id'=>$id, //1004974688  1005031521
                'driver'=>'QiDian'
            ];
      }


}

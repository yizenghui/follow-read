<?php
namespace yizenghui\Spider\Driver\Book\Common;

use yizenghui\Support\Str;


/**
 *
echo \yizenghui\Spider\Driver\Book\Common\position::en('http://book.qidian.com/info/1003723851');
echo \yizenghui\Spider\Driver\Book\Common\position::de("qidian.com&1003723851");
 */


/**
 * Class position
 * @package yizenghui\Spider\Driver\Book\Common
 */
class  position
{

      /**
       * 匹配规则配置
       * @var array
       */
      static protected $conf = [
            'qidian.com&*'=>'http://book.qidian.com/info/*',
      ];

      /**
       * 映射配置
       * @var array
       */
      protected $map = [

      ];

      /**
       * 把url转化成资源定位
       */
      static public function en($url){
            if( $url && self::$conf ){
                  foreach(self::$conf as $position=>$value){
                        $val = Str::mate($value,$url);
                        if($val){
                              $position = strtr($position,['*'=>$val]);
                              return $position;
                        }
                  }
            }
            return false;
      }

      /**
       * 把资源定位转化成url
       */
      static public function de($resource){
            if( $resource && self::$conf ){
                  foreach(self::$conf as $position=>$value){
                        $val = Str::mate($position,$resource);
                        if($val){
                              $value = strtr($value,['*'=>$val]);
                              return $value;
                        }
                  }
            }
            return false;
      }


}

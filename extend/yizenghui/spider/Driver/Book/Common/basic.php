<?php
namespace yizenghui\Spider\Driver\Book\Common;

/**
 * Interface basic  小说采集接口声名
 * @package yizenghui\Spider\Driver\Book\Common
 */
Interface  basic
{

      /**
       * 必须具有初始化book
       * @param $book_id int 只能传入一个参数
       * @return mixed
       */
      function init($book_id);

      /**
       * 根据 init func $book_id 获取书籍详细
       * @return mixed
       */
      function info();

      /**
       * 根据 init func $book_id 获取书籍所有章节信息
       * @return mixed
       */
      function chapter();


      /**
       * 返回书箱的资源定位标识(唯一)
       * @return mixed
       */
      function position();



}

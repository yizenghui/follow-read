<?php

use Phinx\Migration\AbstractMigration;

class Books extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        // create the table
        $table = $this->table('books',array('engine'=>'MyISAM'));
        $table->addColumn('name', 'string',array('limit' => 255,'default'=>'','comment'=>'名称'))
            ->addColumn('intro', 'string',array('limit' => 1024,'comment'=>'简介'))
            ->addColumn('author', 'string',array('limit' => 64,'comment'=>'作者'))
            ->addColumn('source_from', 'string',array('limit' => 64,'comment'=>'来源')) // 资源定位参数
            ->addColumn('book_state', 'integer',array('limit' => 4,'comment'=>'书籍状态')) // 连载中，已完结，太监了。。。
            ->addColumn('sync_time', 'integer',array('default'=>0,'comment'=>'最后同步时间'))
            ->addColumn('next_sync', 'integer',array('default'=>0,'comment'=>'下次同步时间'))
            ->addColumn('sync_interval', 'integer',array('limit' => 11,'default'=>0,'comment'=>'同步间隔'))
            ->addColumn('end_chapter', 'string',array('limit' => 1024,'comment'=>'末章')) // 开发时公司电脑mysql不是 MySQL 5.7
            ->addColumn('create_time', 'integer',array('limit' => 11,'default'=>0,'comment'=>'添加时间'))
            ->addColumn('update_time', 'integer',array('limit' => 11,'default'=>0,'comment'=>'更新时间'))
            ->addColumn('hot', 'integer',array('limit' => 11,'default'=>0,'comment'=>'总热度')) // 书籍更新时统计结果。。
            ->addIndex(array('source_from'))
            ->create();
    }
}

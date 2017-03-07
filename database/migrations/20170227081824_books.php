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
        $table->addColumn('title', 'string',array('limit' => 255,'default'=>'','comment'=>'标题'))
            ->addColumn('synopsis', 'string',array('limit' => 1024,'comment'=>'简介'))
            ->addColumn('author', 'string',array('limit' => 64,'comment'=>'作者'))
            ->addColumn('source_from', 'string',array('limit' => 64,'comment'=>'来源'))
            ->addColumn('sync_at', 'datetime',array('default'=>0,'comment'=>'最后同步时间'))
            ->addColumn('next_sync', 'datetime',array('default'=>0,'comment'=>'下次同步时间'))
            ->addColumn('sync_interval', 'integer',array('limit' => 11,'default'=>0,'comment'=>'同步间隔'))
            ->addColumn('end_chapter', 'string',array('limit' => 1024,'comment'=>'末章')) // 开发时公司电脑mysql不是 MySQL 5.7
            ->addColumn('create_at', 'datetime',array('default'=>0,'comment'=>'添加时间'))
            ->addColumn('update_at', 'datetime',array('default'=>0,'comment'=>'更新时间'))
            ->addColumn('hot', 'integer',array('limit' => 11,'default'=>0,'comment'=>'热度'))
            ->create();
    }
}

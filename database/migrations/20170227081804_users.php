<?php

use Phinx\Migration\AbstractMigration;

class Users extends AbstractMigration
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
        $table = $this->table('users',array('engine'=>'MyISAM'));
        $table->addColumn('nickname', 'string',array('limit' => 15,'default'=>'','comment'=>'昵称'))
            ->addColumn('open_id', 'string',array('limit' => 64,'comment'=>'wechat open_id'))
            ->addColumn('safe_email', 'string',array('limit' => 64,'comment'=>'安全邮箱'))
            ->addColumn('head', 'string',array('limit' => 256,'comment'=>'头像'))
            ->addColumn('subscribe', 'boolean',array('limit' => 1,'default'=>1,'comment'=>'关注'))
            ->addColumn('create_at', 'datetime',array('default'=>0,'comment'=>'添加时间'))
            ->addColumn('update_at', 'datetime',array('default'=>0,'comment'=>'更新时间'))
            ->addIndex(array('open_id'), array('unique' => true))
            ->create();
    }
}

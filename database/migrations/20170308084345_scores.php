<?php

use Phinx\Migration\AbstractMigration;

class Scores extends AbstractMigration
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
        $table = $this->table('scores',array('engine'=>'MyISAM'));
        $table->addColumn('book_id', 'integer',array('limit' => 11,'default'=>0,'comment'=>'书籍ID'))
            ->addColumn('score', 'integer',array('limit' => 4,'default'=>0,'comment'=>'得分'))
            ->addColumn('time', 'integer',array('limit' => 11,'default'=>0,'comment'=>'时间'))
            ->addIndex(array('book_id'))
            ->addIndex(array('time'))
            ->create();
    }
}

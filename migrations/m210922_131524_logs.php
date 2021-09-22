<?php

use yii\db\Migration;

/**
 * Class m210922_131524_logs
 */
class m210922_131524_logs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('logs', [
            'id'    => $this->bigPrimaryKey(),
            'url'   => $this->string(250)->null(),
            'date'  => $this->dateTime()->null()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('logs');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210922_131524_logs cannot be reverted.\n";

        return false;
    }
    */
}

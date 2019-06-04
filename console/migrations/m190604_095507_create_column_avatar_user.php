<?php

use yii\db\Migration;

/**
 * Class m190604_095507_create_column_avatar_user
 */
class m190604_095507_create_column_avatar_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'avatar', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'avatar');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190604_095507_create_column_avatar_user cannot be reverted.\n";

        return false;
    }
    */
}

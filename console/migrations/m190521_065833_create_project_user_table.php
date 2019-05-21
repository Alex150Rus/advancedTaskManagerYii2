<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project_user}}`.
 */
class m190521_065833_create_project_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project_user}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'role' => 'ENUM("manager", "developer", "tester")'
        ]);

        $this->addForeignKey('fx_project_user_user_id', 'project_user', ['user_id'], 'user', ['id']);
        $this->addForeignKey('fx_project_user_project_id', 'project_user', ['project_id'], 'project', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey('fx_project_user_user_id', 'project_user');
        $this->dropForeignKey('fx_project_user_project_id', 'project_user');

        $this->dropTable('{{%project_user}}');
    }
}

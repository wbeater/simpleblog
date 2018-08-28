<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tbl_user`.
 */
class m180824_221153_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull()->unique(),
            'access_token' => $this->string(255),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string(255)->notNull(),
            'password_reset_token' => $this->string(255),
            'email' => $this->string(255)->notNull()->unique(),
            'is_admin' => $this->string(255)->notNull()->defaultValue(0),
            'status' => $this->integer(6)->notNull()->defaultValue(10),
            'created_at' => $this->integer(11)->notNull()->defaultValue(0),
            'updated_at' => $this->integer(11)->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}

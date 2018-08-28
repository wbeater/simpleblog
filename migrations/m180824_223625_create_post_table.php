<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post`.
 */
class m180824_223625_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull(),
            'thumbnail_url' => $this->string(255),
            'image_url' => $this->string(255),
            'summary'=> $this->text(),
            'content' => $this->text(),
            'status' => $this->integer(1)->notNull()->comment("-2 : Admin unpublished\n-1 : Deleted\n0: Unpublished\n1: Published"),
            'published_time' => $this->integer(11),
            'created_at' => $this->integer(11)->notNull()->defaultValue(0),
            'updated_at' => $this->integer(11)->notNull()->defaultValue(0),
            'created_by' => $this->integer(11)->notNull()->defaultValue(0),
            'updated_by' => $this->integer(11)->notNull()->defaultValue(0),
        ]);
        
        $this->createIndex('idx_post_title', '{{%post}}', 'title');
        $this->createIndex('idx_post_published_time', '{{%post}}', 'published_time');
        $this->addForeignKey('fk_post_user_created_by', '{{%post}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('fk_post_user_updated_by', '{{%post}}', 'updated_by', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post}}');
        $this->dropIndex('idx_post_title', '{{%post}}');
        $this->dropIndex('idx_post_published_time', '{{%post}}');
        $this->dropForeignKey('fk_post_user_created_by', '{{%post}}');
        $this->dropForeignKey('fk_post_user_updated_by', '{{%post}}');
    }
}

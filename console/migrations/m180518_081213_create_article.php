<?php

use yii\db\Migration;

/**
 * Class m180518_081213_create_article
 */
class m180518_081213_create_article extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'content' => $this->text(),
            'tags' => $this->string(),
            'status' => $this->boolean()->defaultValue(0),
            'create_time' => $this->integer()->notNull(),
            'update_time' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
        ],$tableOptions);
        $this->addForeignKey('fk-article-author_id','article','author_id','admin','id','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180518_081213_create_article cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180518_081213_create_article cannot be reverted.\n";

        return false;
    }
    */
}

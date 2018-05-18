<?php

use yii\db\Migration;

/**
 * Class m180518_081356_create_comment
 */
class m180518_081356_create_comment extends Migration
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
        $this->createTable('comment',[
            'id' => $this->primaryKey(),
            'content' => $this->string()->notNull(),
            'status' => $this->boolean()->notNull()->defaultValue(0),
            'user_id' => $this->integer()->notNull(),
            'email' => $this->string(),
            'url' => $this->string(),
            'article_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('fk-comment-user_id','comment','user_id','user','id','CASCADE');
        $this->addForeignKey('fk-comment-article_id','comment','article_id','article','id','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180518_081356_create_comment cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180518_081356_create_comment cannot be reverted.\n";

        return false;
    }
    */
}

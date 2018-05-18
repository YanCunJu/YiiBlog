<?php

use yii\db\Migration;

/**
 * Class m180518_082212_create_tag
 */
class m180518_082212_create_tag extends Migration
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
        $this->createTable('tag',[
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'frequency' => $this->smallInteger()->notNull()->defaultValue(0)
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180518_082212_create_tag cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180518_082212_create_tag cannot be reverted.\n";

        return false;
    }
    */
}

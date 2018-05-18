<?php

namespace common\models\db;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $content
 * @property int $status
 * @property int $user_id
 * @property string $email
 * @property string $url
 * @property int $article_id
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'user_id', 'article_id'], 'required'],
            [['status', 'user_id', 'article_id'], 'integer'],
            [['content', 'email', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'status' => 'Status',
            'user_id' => 'User ID',
            'email' => 'Email',
            'url' => 'Url',
            'article_id' => 'Article ID',
        ];
    }
}

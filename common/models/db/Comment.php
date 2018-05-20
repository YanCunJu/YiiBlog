<?php

namespace common\models\db;

use backend\models\db\User;
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
            [['content', 'user_id', 'article_id','create_time'], 'required'],
            [['status', 'user_id', 'article_id','create_time'], 'integer'],
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
            'content' => '内容',
            'status' => '状态',
            'user_id' => '用户',
            'email' => 'Email',
            'url' => 'Url',
            'create_time'=>'创建时间',
            'article_id' => '文章',
        ];
    }

    public static function statuses()
    {
        return [
            '0' => '未审核',
            '1' => '已审核'
        ];
    }

    public function getStatus()
    {
        return self::statuses()[$this->status];
    }

    public function getBeginning()
    {
        $tmpStr = strip_tags($this->content);
        $tmpLen = mb_strlen($tmpStr);
        return mb_substr($tmpStr,0,15,'utf-8').(($tmpLen>15 ? '...' : ''));
    }

    public function getUser()
    {
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }

    public function getArticle()
    {
        return $this->hasOne(Article::className(),['id'=>'article_id']);
    }

    public function approve()
    {
        $this->status = 1; //代表已审核
        return ($this->save() ? true : false);
    }

    public static function getPengdingCommentCount()
    {
        return Comment::find()->where(['status'=>0])->count();
    }
}

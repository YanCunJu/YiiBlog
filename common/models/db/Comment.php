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
 * @property string $create_time
 * @property int $article_id
 * @property int $remind 0表示未提醒，1表示已提醒
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
            [['status', 'user_id', 'article_id', 'remind'], 'integer'],
            [['content', 'email', 'url'], 'string', 'max' => 255],
            [['create_time'], 'string', 'max' => 32],
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
            'remind' => 'Remind',
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

    public static function findRecentComments($limit = 10)
    {
        return Comment::find()->where(['status'=>1])->orderBy('create_time desc')->limit($limit)->all();
    }
}

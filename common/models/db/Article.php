<?php

namespace common\models\db;

use backend\models\db\Admin;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property int $status
 * @property int $create_time
 * @property int $update_time
 * @property int $author_id
 *
 * @property Admin $author
 */
class Article extends \yii\db\ActiveRecord
{

    public $_oldTags = '';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'create_time', 'update_time', 'author_id'], 'required'],
            [['content'], 'string'],
            [['status', 'create_time', 'update_time', 'author_id'], 'integer'],
            [['title', 'tags'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Admin::className(), 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'tags' => '标签',
            'status' => '状态',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'author_id' => '作者',
        ];
    }

    public static function statuses()
    {
        return [
            '0' => '未发布',
            '1' => '已发布'
        ];
    }

    public function getStatus()
    {
        return self::statuses()[$this->status];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Admin::className(), ['id' => 'author_id']);
    }

    public function getAuthors()
    {
        return ArrayHelper::map(Admin::find()->all(),'id','username');
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            if($insert) {
                $this->create_time = time();
                $this->update_time = time();
            } else {
                $this->update_time = time();
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->_oldTags = $this->tags;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
        Tag::updateFrequency($this->_oldTags,$this->tags);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        Tag::updateFrequency($this->tags,'');
    }


    public function getUrl()
    {
        return Yii::$app->urlManager->createUrl(
            ['article/detail','id'=>$this->id,'title'=>$this->title]
        );
    }

    public  function getBeginning($length = 288)
    {
        $tmpStr = strip_tags($this->content);
        $tmpLen = mb_strlen($tmpStr);

        $tmpStr =  mb_substr($tmpStr,0,$length,'utf-8');
        return $tmpStr.($tmpLen>$length ? '...':'');
    }

    public function getTagLinks()
    {
        $links = [];
        foreach(Tag::string2array($this->tags) as $tag) {
            $links[] = Html::a(Html::encode($tag),['article/index','ArticleSearch[tags]'=>$tag]);
        }
        return $links;
    }

    public function getCommentCount()
    {
        return Comment::find()->where(['article_id'=>$this->id,'status'=>1])->count();
    }

    public function getActiveComments()
    {
        return $this->hasMany(Comment::className(), ['article_id' => 'id'])
            ->where('status=:status',[':status'=>1])->orderBy('id DESC');
    }
}

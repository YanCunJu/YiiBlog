<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\db\Comment;

/**
 * CommentSearch represents the model behind the search form of `common\models\db\Comment`.
 */
class CommentSearch extends Comment
{

    public function attributes()
    {
        return array_merge(parent::attributes(),['userName','article.title']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'user_id', 'article_id'], 'integer'],
            [['content', 'email', 'url','userName','article.title'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Comment::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>['pageSize'=>5]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'comment.id' => $this->id,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'article_id' => $this->article_id,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'url', $this->url]);

        $query->join('INNER JOIN','user','user.id = comment.user_id');
        $query->andFilterWhere(['like','user.username',$this->userName]);

        $query->join('INNER JOIN','article','article.id = comment.article_id');
        //因为属性中有“.”，必须使用getAttribute方法
        $query->andFilterWhere(['like','article.title',$this->getAttribute('article.title')]);

        $dataProvider->sort->attributes['userName'] = [
            'asc' =>['user.username'=>SORT_ASC],
            'desc'=>['user.username'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['article.title'] = [
            'asc' =>['article.title'=>SORT_ASC],
            'desc'=>['article.title'=>SORT_DESC],
        ];

        $dataProvider->sort->defaultOrder = [
            'status'=> SORT_ASC,
            'id'=>SORT_DESC
        ];

        return $dataProvider;
    }
}

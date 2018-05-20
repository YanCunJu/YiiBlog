<?php

use common\models\db\Comment;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

//            'id',
            ['attribute'=>'id','contentOptions'=>['width'=>'30px']],
            ['attribute'=>'content','value'=>'beginning'],
            [
            'attribute'=>'status',
            'value'=>function($model){return $model->getStatus();},
            'filter'=>Comment::statuses(),
            'contentOptions'=>function($model){return ($model->status == 0) ? ['class'=>'bg-danger'] : [];}
            ],
            ['attribute'=>'userName','label'=>'用户','value'=>'user.username'],
//            'email:email',
            //'url:url',
            //'article_id',
            //'article.title',
            ['attribute'=>'article.title','label'=>'文章','value'=>function($model){return $model->article->title;}],
            ['class' => 'yii\grid\ActionColumn',
            'template'=>'{view}{update}{delete}{approve}',
            'buttons'=>[
                    'approve'=>function($url,$model,$key){
                        $options = [
                           'title'=>Yii::t('yii','审核'),
                           'aria-label'=>Yii::t('yii','审核'),
                           'data-confirm'=>Yii::t('yii','你确定通过这条评论吗？'),
                           'data-method'=>'post',
                           'data-pjax'=>'0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-check"></span>',$url,$options);
                    }
                    ],
            ],
        ],
    ]); ?>
</div>

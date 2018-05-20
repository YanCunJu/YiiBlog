<?php

use common\models\db\Article;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            ['attribute'=>'id','contentOptions'=>['width'=>'30px']],
            'title',
            ['attribute'=>'authorName','label'=>'作者','value'=>'author.username'],
            //'content:ntext',
            'tags',
            [
                'attribute'=>'status',
                'value'=>function($model){return $model->getStatus();},
                'filter'=>Article::statuses(),
            ],
            //'create_time:datetime',
            'update_time:datetime',


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

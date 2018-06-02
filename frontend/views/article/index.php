<?php

use frontend\components\RctReplyWidget;
use frontend\components\TagsCloudWidget;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\db\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '文章列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <?= ListView::widget([
                'id'=>'articleList',
                'dataProvider'=>$dataProvider,
                'itemView'=>'_listitem',  //子试图
                'layout' => '{items}{pager}',
                'pager'=>[
                    'maxButtonCount' => 10,
                    'nextPageLabel' => Yii::t('app','下一页'),
                    'prevPageLabel' => Yii::t('app','上一页')
                ]
            ])?>
        </div>

        <div class="col-md-3">
            <div class="searchbox">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>查找文章
                    </li>
                    <li class="list-group-item">
                        <form action="index.php?r=article/index" id="w0" method="get" class="form-inline">
                            <div class="form-group">
                                <input type="text" class="form-control" id="w0input" name="ArticleSearch[title]" placeholder="按标题">
                            </div>
                            <button type="submit" class="btn btn-default">搜索</button>
                        </form>
                    </li>
                </ul>
            </div>

            <div class="tagcloudbox">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>标签云
                    </li>
                    <li class="list-group-item">
                        <?= TagsCloudWidget::widget(['tags'=>$tags])?>
                    </li>
                </ul>
            </div>

            <div class="commentbox">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>最新回复
                    </li>
                    <li class="list-group-item">
                        <?= RctReplyWidget::widget(['recentComments'=>$recentComments])?>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>

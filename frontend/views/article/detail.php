<?php

use common\models\db\Comment;
use frontend\components\RctReplyWidget;
use frontend\components\TagsCloudWidget;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\db\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = $model->title;
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="article">
                <div class="title">
                    <h2><a href="<?=$model->url?>"><?=Html::encode($model->title);?></a></h2>
                </div>
                <div class="author">
                    <span class="glyphicon glyphicon-time" aria-hidden="true"><?=date('Y-m-d H:i:s',$model->create_time)?></span>
                    <span class="glyphicon glyphicon-user" aria-hidden="true"><?=Html::encode($model->author->username)?></span>
                </div>
                <br>
                <div class="content">
                    <?=HTMLPurifier::process($model->content);?>
                </div>
                <br>
                <div class="nav">
                    <span class="glyphicon glyphicon-tag" aria-hidden="true">
                        <?=implode(',',$model->tagLinks);?>
                    </span>
                    <br>
                    <?= Html::a("评论 ({$model->commentCount})",$model->url.'#comments')?> | 最后修改于 <?=date('Y-m-d H:i:s',$model->update_time)?>
                </div>
            </div>
            <div id="comments">

                <?php if($added) {?>
                    <br>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                        <h4>谢谢您的回复，我们会尽快审核后发布出来！</h4>

                        <p><?= nl2br($commentModel->content);?></p>
                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span><em><?= date('Y-m-d H:i:s',$model->create_time)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";?></em>
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span><em><?= Html::encode($model->author->username);?></em>
                    </div>
                <?php }?>

                <?php if($model->commentCount>=1) :?>

                    <h5><?= $model->commentCount.'条评论';?></h5>
                    <?= $this->render('_comment',array(
                        'article'=>$model,
                        'comments'=>$model->activeComments,
                    ));?>
                <?php endif;?>

                <h5>发表评论</h5>
                <?php
                $commentModel =new Comment();
                echo $this->render('_guestform',array(
                    'id'=>$model->id,
                    'commentModel'=>$commentModel,
                ));?>

            </div>
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

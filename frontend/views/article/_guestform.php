<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="comment-form">

    <?php $form = ActiveForm::begin([
        'action'=>['article/detail','id'=>$id,'#'=>'comments'],
        'method'=>'post'
    ]); ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($commentModel,'content')->textarea(['rows'=>4])?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('发表评论', ['class' =>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


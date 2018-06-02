<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$admin = \backend\models\db\Admin::findOne($id);
/* @var $this yii\web\View */
/* @var $model backend\models\db\Admin */

$this->title = '权限设置: ' . $admin->username;
$this->params['breadcrumbs'][] = ['label' => '管理员', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '权限设置';
?>
<div class="admin-privilege">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="admin-privilege-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= Html::checkboxList('newPri',$authAssignmentArray,$allPrivilegeArray);?>


        <div class="form-group">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>


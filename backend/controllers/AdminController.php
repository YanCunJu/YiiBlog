<?php

namespace backend\controllers;

use backend\models\db\AuthAssignment;
use backend\models\db\AuthItem;
use backend\models\form\ResetPasswordForm;
use backend\models\form\SignupForm;
use Yii;
use backend\models\db\Admin;
use backend\models\search\AdminSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admin model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignUpForm();

        if ($model->load(Yii::$app->request->post())) {
            if($user = $model->signup()) {
                return $this->redirect(['view', 'id' => $user->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionResetpwd($id)
    {
        $model = new ResetPasswordForm();

        if ($model->load(Yii::$app->request->post())) {
            if($model->resetPassword($id)) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('resetpwd', [
            'model' => $model,
        ]);
    }



    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Admin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPrivilege($id)
    {
        $model = $this->findModel($id);
        //step1:找出所有权限，提供给checkboxlist
        $allPrivileges = AuthItem::find()
            ->select(['name','description'])
            ->where(['type'=>1])
            ->orderBy('description')
            ->all();
        foreach($allPrivileges as $pri)
        {
            $allPrivilegesArray[$pri->name] = $pri->description;
        }
        //step2:当前用户的权限
        $authAssignments = AuthAssignment::find()
            ->select(['item_name'])
            ->where(['user_id'=>$id])
            ->all();
        $authAssignmentsArray = [];
        foreach($authAssignments as $authAssignment)
        {
            array_push($authAssignmentsArray,$authAssignment->item_name);
        }
        //step3:从表单提交的数据，来更新AuthAssignment表，从而用户的角色发生变化
        if(isset($_POST['newPri']))
        {
            AuthAssignment::deleteAll('user_id=:id',[':id'=>$id]);
            $newPri = $_POST['newPri'];
            $arrlength = count($newPri);
            for ($i = 0; $i<$arrlength; $i++) {
                $aPri = new AuthAssignment();
                $aPri->item_name = $newPri[$i];
                $aPri->user_id = $id;
                $aPri->created_at = time();

                $aPri->save();
            }
            return $this->redirect(['index']);
        }


        //渲染checkboxlist表单
        return $this->render('privilege',[
            'model' => $model,
            'id' => $id,
            'authAssignmentArray' => $authAssignmentsArray,
            'allPrivilegeArray'=> $allPrivilegesArray
        ]);
    }
}

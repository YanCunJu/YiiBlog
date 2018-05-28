<?php
namespace console\controllers;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // 添加 "createArticle" 权限
        $createArticle = $auth->createPermission('createArticle');
        $createArticle->description = '新增文章';
        $auth->add($createArticle);

        // 添加 "updateArticle" 权限
        $updateArticle = $auth->createPermission('updateArticle');
        $updateArticle->description = '修改文章';
        $auth->add($updateArticle);

        // 添加 "deleteArticle" 权限
        $deleteArticle = $auth->createPermission('deleteArticle');
        $deleteArticle->description = '删除文章';
        $auth->add($deleteArticle);

        // 添加 "approveComment" 权限
        $approveComment = $auth->createPermission('approveComment');
        $approveComment->description = '审核评论';
        $auth->add($approveComment);

        // 添加 "articleadmin" 角色并赋予 "updatearticle" “deletearticle” “createarticle”
        $articleAdmin = $auth->createRole('articleAdmin');
        $articleAdmin->description = '文章管理员';
        $auth->add($articleAdmin);
        $auth->addChild($articleAdmin, $updateArticle);
        $auth->addChild($articleAdmin, $createArticle);
        $auth->addChild($articleAdmin, $deleteArticle);

        // 添加 "articleOperator" 角色并赋予  “deletearticle” 
        $articleOperator = $auth->createRole('articleOperator');
        $articleOperator->description = '文章操作员';
        $auth->add($articleOperator);
        $auth->addChild($articleOperator, $deleteArticle);

        // 添加 "commentAuditor" 角色并赋予  “approveComment”
        $commentAuditor = $auth->createRole('commentAuditor');
        $commentAuditor->description = '评论审核员';
        $auth->add($commentAuditor);
        $auth->addChild($commentAuditor, $approveComment);

        // 添加 "admin" 角色并赋予所有其他角色拥有的权限
        $admin = $auth->createRole('admin');
        $commentAuditor->description = '系统管理员';
        $auth->add($admin);
        $auth->addChild($admin, $articleAdmin);
        $auth->addChild($admin, $commentAuditor);



        // 为用户指派角色。其中 1 和 2 是由 IdentityInterface::getId() 返回的id （译者注：user表的id）
        // 通常在你的 User 模型中实现这个函数。
        $auth->assign($admin, 1);
        $auth->assign($articleAdmin, 2);
        $auth->assign($articleOperator, 3);
        $auth->assign($commentAuditor, 4);
    }

    public function down()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}
<?php

/**
 * Created by PhpStorm.
 * User: smile
 * Date: 16-12-6
 * Time: 下午5:22
 */
namespace app\controllers;

use app\widgets\ShowMessage;
use app\widgets\OutPut;
use app\models\User;
use yii\helpers\Url;
use Yii;
class UserController extends BaseController
{
    public function actionIndex()
    {
        $name = $this->request->get('name');
        $pageSize = $this->request->get('per-page', PAGESIZE);
        $info = User::getAll($name,$pageSize);
        return $this->render('index', [
            'info' => $info['data'],
            'name' => $name,
            'pages' => $info['pages']
        ]);
    }
    
    public function actionAdd()
    {
        if($this->request->isPost){
            $user = $this->request->post('user');
            $model = new User();
            $model->setAttributes([
                'name' => $user['name'],
                'realName' => $user['realname'],
                'password' => User::hashPwd($user['password']),
                'mobile' => $user['mobile'],
                'status' => $user['status'],
                'addTime' => $this->datetime,
                'ediTime' => $this->datetime,
            ],false);
            $model->save();
            ShowMessage::info('添加成功','',Url::toRoute(['index']),'edit');
        }
        return $this->render('add');
    }
    
    public function actionEdit($id)
    {
        $model = User::findOne($id);
        if($this->request->isPost){
            $user = $this->request->post('user');
            $model->setAttributes([
                'name' => $user['name'],
                'realName' => $user['realname'],
                'mobile' => $user['mobile'],
                'status' => $user['status'],
                'editTime' => $this->datetime,
            ],false);
            $model->save();
            ShowMessage::info('修改成功','',Url::toRoute(['index']),'edit');
        }
        return $this->render('edit',[
            'model' => $model,
        ]);
    }
    
    public function actionDelete($id)
    {
        $model = User::findOne($id);
        $model->setAttributes([
            'isDelete' => DEL_FLAG_TRUE,
        ],false);
        $model->save();
        ShowMessage::info('删除成功','',Url::toRoute(['index']),'edit');
    }

    public function actionPerson()
    {
        if(empty($this->userid)){
            ShowMessage::info('请重新登陆！',Url::toRoute('/login/index'),1000);
        }
        $model = User::findOne($this->userid);
        if(empty($model)){
            ShowMessage::info('请重新登陆！',Url::toRoute('/login/index'),1000);
        }
        return $this->render('person',[
            'user' => $model,
        ]);
    }

    /**
     * 修改密码
     * @return string
     */
    public function actionEditpwd()
    {
        if($this->request->isPost){
            $oldPassword = $this->request->post('oldPassword');
            $password = $this->request->post('password');
            $repassword = $this->request->post('repassword');
            $userModel = User::findOne($this->userid);
            if($userModel->password != User::hashPwd($oldPassword)){
                ShowMessage::info('原密码输入错误');
            }
            if($password != $repassword){
                ShowMessage::info('两次密码输入不一致');
            }
            $userModel->password = User::hashPwd($password);
            if($userModel->save()){
                ShowMessage::info('修改成功！');
            }else{
                ShowMessage::info('修改失败，请稍后再试！');
            }
        }
        return $this->render('editpwd');
    }

    /**
     * 验证原密码是否正确
     */
    public function actionCheckpwd_ajax()
    {
        if($this->request->isAjax){
            $oldPassword = $this->request->get('old-password');
            $userModel = User::findOne($this->userid);
            if($userModel->password == User::hashPwd($oldPassword)){
                OutPut::returnJson('密码正确',200,['status'=> 1]);
            }else{
                OutPut::returnJson('密码错误',200,['status'=> 0]);
            }
        }else{
            OutPut::returnJson('非法请求',201,['status'=> 0]);
        }
    }

    public function actionCheckname_ajax() {
        if ($this->request->isAjax) {
            $username = $this->request->get('User-username');
            $id = $this->request->get('id');
            if (!empty($id)) {
                $userInfo = User::find()->where(['isDelete'=> DEL_FLAG_FALSE])->andWhere('name=:name and id !=:id', [':name' => $username, ':id' => $id])->one();
            } else {
                $userInfo = User::find()->where(['name' => $username,'isDelete'=>DEL_FLAG_FALSE])->one();
            }
            if (!empty($userInfo)) {
                echo 200;die;  //返回该用户名已经注册
            } else {
                echo 201;die;
            }
        } else {
            echo 201;die;
        }
    }

    public function actionCheckphone_ajax() {
        if ($this->request->isAjax) {
            $mobile = $this->request->get('User-mobile');
            $id = $this->request->get('id');
            if (!empty($id)) {
                $phoneInfo = User::find()->where(['isDelete'=> DEL_FLAG_FALSE])->andWhere('mobile=:mobile and id !=:id', [':mobile' => $mobile, ':id' => $id])->one();
            } else {
                $phoneInfo = User::find()->where(['mobile' => $mobile,'isDelete'=>DEL_FLAG_FALSE])->one();
            }
            if (!empty($phoneInfo)) {
                echo 200;die;  //返回该手机号码已经注册
            } else {
                echo 201;die;
            }
        } else {
            echo 200;die;
        }
    }
}
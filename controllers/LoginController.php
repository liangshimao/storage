<?php
/**
 * Created by PhpStorm.
 * User: smile
 * Date: 16-9-14
 * Time: 下午5:23
 */

namespace app\controllers;

use app\widgets\ShowMessage;
use app\models\User;
use yii\web\Controller;
use Yii;
use yii\helpers\Url;
class LoginController extends Controller
{
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
    
    public function actionLogin()
    {
        if(Yii::$app->request->isPost){
            $username = Yii::$app->request->post('username');
            $password = Yii::$app->request->post('password');
            if (empty($username) || empty($password)){
                ShowMessage::info("用户名或密码不能为空", Url::toRoute('index'));
            }
            $mInfo = User::find()->where(['isDelete'=> DEL_FLAG_FALSE])->andWhere('name=:name or mobile=:name',[':name'=> trim($username)])->one();
            if (empty($mInfo)){
                ShowMessage::info("用户不存在", Url::toRoute('index'));
            }

            if (User::hashPwd($password) != $mInfo['password']) {
                ShowMessage::info("密码错误", Url::toRoute('index'));
            }
            if ($mInfo['status'] != 0) {
                ShowMessage::info("该用户被禁用", Url::toRoute('index'));
            }

            Yii::$app->getSession()->set("userid", $mInfo->id);
            Yii::$app->getSession()->set("name", $mInfo->name);
            Yii::$app->getSession()->set("realname", $mInfo->realName);
            //登陆成功
            $mInfo->loginTime = date("Y-m-d H:i:s",time());
            $mInfo->ip = Yii::$app->request->getUserIP();
            
            if($mInfo->save()){
                return $this->redirect('/');
            }else{
                ShowMessage::info("登录失败", Url::toRoute('index'));
            }
        }
    }
    public function actionLogout()
    {
        Yii::$app->session->removeAll();
        return $this->redirect(Url::toRoute('/login/index'));
    }
}
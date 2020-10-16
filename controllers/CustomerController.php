<?php
/**
 * Created by PhpStorm.
 * User: liangsm
 * Date: 2020/10/16
 * Time: 0:42
 */

namespace app\controllers;
use app\models\Customer;
use app\widgets\ShowMessage;
use yii\helpers\Url;
class CustomerController extends BaseController
{
    public function actionIndex()
    {
        $name = $this->request->get('name');
        $pageSize = $this->request->get('per-page', PAGESIZE);
        $info = Customer::getAll($name,$pageSize);
        return $this->render('index', [
            'info' => $info['data'],
            'name' => $name,
            'pages' => $info['pages']
        ]);
    }

    public function actionAdd()
    {
        if($this->request->isPost){
            $customer = $this->request->post('customer');
            $model = new Customer();
            $model->setAttributes([
                'name' => $customer['name'],
                'alias' => $customer['alias'],
                'mobile' => $customer['mobile'],
                'addTime' => $this->datetime,
                'editTime' => $this->datetime,
                'sort' => $customer['sort'],
            ],false);
            $model->save();
            ShowMessage::info('添加成功','',Url::toRoute(['index']),'edit');
        }
        return $this->render('add');
    }

    public function actionEdit($id)
    {
        $model = Customer::findOne($id);
        if($this->request->isPost){
            $customer = $this->request->post('customer');
            $model->setAttributes([
                'name' => $customer['name'],
                'alias' => $customer['alias'],
                'mobile' => $customer['mobile'],
                'editTime' => $this->datetime,
                'sort' => $customer['sort'],
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
        $model = Customer::findOne($id);
        $model->setAttributes([
            'isDelete' => DEL_FLAG_TRUE,
        ],false);
        $model->save();
        ShowMessage::info('删除成功','',Url::toRoute(['index']),'edit');
    }

    public function actionCheckname_ajax() {
        if ($this->request->isAjax) {
            $username = $this->request->get('User-name');
            $id = $this->request->get('id');
            if (!empty($id)) {
                $userInfo = Customer::find()->where(['isDelete'=> DEL_FLAG_FALSE])->andWhere('name=:name and id !=:id', [':name' => $username, ':id' => $id])->one();
            } else {
                $userInfo = Customer::find()->where(['name' => $username,'isDelete'=> DEL_FLAG_FALSE])->one();
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
}
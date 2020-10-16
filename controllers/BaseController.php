<?php

/**
 * Created by PhpStorm.
 * User: smile
 * Date: 16-9-14
 * Time: 下午4:18
 */
namespace app\controllers;
use app\widgets\ShowMessage;
use yii\web\Controller;
use Yii;
use yii\helpers\Url;
class BaseController extends Controller
{
    public $cache;
    public $request;
    public $session;
    public $userid;
    public $name;
    public $realname;
    public $datetime;


    public function init()
    {
        $this->cache = Yii::$app->cache;

        $this->request = Yii::$app->request;

        $this->session = Yii::$app->session;

        $this->userid = $this->session->get('userid');
        $this->name = $this->session->get('name');
        $this->realname = $this->session->get('realname');

        if(empty($this->userid)){
            ShowMessage::info('您还没有登陆！',Url::toRoute('/login/index'),1800);
        }
        $this->datetime = date('Y-m-d H:i:s');
    }
}
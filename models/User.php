<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\data\Pagination;
class User extends ActiveRecord
{
    public static function tableName()
    {
        return 'basic_user';
    }

    public static function tableDesc(){
        return '用户表';
    }

    public static function hashPwd($pwd)
    {
        return md5(md5(strtolower($pwd)));
    }

    public static function getAll($name,$pageSize)
    {
        $query = self::find()->where(['isDelete' => DEL_FLAG_FALSE]);
        if(!empty($name)){
            $query->andFilterWhere(['like','realName',$name]);
        }
        $query->orderBy(['editTime'=> SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize]);
        $info['data'] = $query->offset($pages->offset)->limit($pages->limit)->all();
        $info['pages'] = $pages;
        return $info;
    }



}
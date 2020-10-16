<?php
/**
 * Created by PhpStorm.
 * User: liangsm
 * Date: 2020/10/16
 * Time: 1:03
 */

namespace app\models;
use yii\data\Pagination;
use yii\db\ActiveRecord;
class Pear extends ActiveRecord
{
    public static function tableName()
    {
        return 'basic_pear';
    }

    public static function tableDesc(){
        return '梨品表';
    }


    public static function getAll($name,$pageSize)
    {
        $query = self::find()->where(['isDelete' => DEL_FLAG_FALSE]);
        if(!empty($name)){
            $query->andFilterWhere(['like','name',$name]);
        }
        $query->orderBy(['sort'=> SORT_ASC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize]);
        $info['data'] = $query->offset($pages->offset)->limit($pages->limit)->all();
        $info['pages'] = $pages;
        return $info;
    }
}
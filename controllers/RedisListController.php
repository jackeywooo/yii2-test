<?php

namespace app\controllers;

use app\models\RedisList;

class RedisListController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionView()
    {
        $model = (new RedisList())->findAll(['task_id'=>0]);

        return $this->render('view', $model);
    }

}

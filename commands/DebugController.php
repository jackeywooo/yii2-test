<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2019/1/19
 * Time: 15:42
 */

namespace app\commands;
use app\job\TestJob;
use \yii;
use yii\console\Controller;

class DebugController extends Controller
{
    public function actionDb() {
        $db = yii::$app->db;
        $result = $db->createCommand("select * from `country`")->queryAll();

        print_r($result);
    }

    public function actionRedis()
    {
        try {
            $redis = yii::$app->redis;

            $redis->lpush('test_queue','a','b');
            $redis->lpush('test_queue','c');
            while($res = $redis->rpop('test_queue')) {
                echo $res . "\t";
            }

            echo "\n";
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function actionQueue()
    {
        $i=1;
        while($i++ <= 10) {
            $id = Yii::$app->queue->push(new TestJob($i));
        }
    }




}
<?php
namespace app\job;
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2019/1/19
 * Time: 17:33
 */

use app\models\RedisList;
use Yii;
use yii\queue\RetryableJobInterface;

class TestJob implements RetryableJobInterface
{
    public $taskId;

    public function __construct($taskId)
    {
        $this->taskId = $taskId;
    }

    public function execute($queue)
    {
        (new RedisList())->addOne($this->taskId);
    }

    public function getTtr()
    {

        echo 'ttr';

        return 15 * 60;
    }

    public function canRetry($attempt, $error)
    {
        return 5;
//        echo 'can try';
//        return ($attempt < 5) && ($error );
    }
}
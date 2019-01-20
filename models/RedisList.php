<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "redis_list".
 *
 * @property int $id
 * @property int $task_id
 * @property int $status
 * @property string $create_time
 * @property string $update_time
 */
class RedisList extends \yii\db\ActiveRecord
{
    const STATUS_CLOSE = 0;
    const STATUS_OPEN = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'redis_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'status'], 'integer'],
            [['create_time', 'update_time'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * {@inheritdoc}
     * @return RedisListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RedisListQuery(get_called_class());
    }

    public function addOne($taskId, $status=0) {
        if(empty($taskId)) {
            Yii::error('insert error');
        }
        $this->task_id = $taskId;
        $this->status = $status;

        if($this->save()) {
            return true;
        } else {
            return false;
        }
    }

}

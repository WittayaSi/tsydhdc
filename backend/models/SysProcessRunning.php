<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sys_process_running".
 *
 * @property string $running
 */
class SysProcessRunning extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_process_running';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['running'], 'required'],
            [['running'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'running' => 'Running',
        ];
    }
}

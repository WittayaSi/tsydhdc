<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sys_check_input".
 *
 * @property string $input
 */
class SysCheckInput extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_check_input';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['input'], 'required'],
            [['input'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'input' => 'Input',
        ];
    }
}

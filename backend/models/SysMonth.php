<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sys_month".
 *
 * @property string $month
 * @property string $selyear
 * @property string $selmonth
 * @property string $month_th
 */
class SysMonth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_month';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['month'], 'required'],
            [['month'], 'string', 'max' => 6],
            [['selyear'], 'string', 'max' => 4],
            [['selmonth'], 'string', 'max' => 2],
            [['month_th'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'month' => 'Month',
            'selyear' => 'Selyear',
            'selmonth' => 'Selmonth',
            'month_th' => 'Month Th',
        ];
    }
}

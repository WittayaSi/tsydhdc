<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "sys_count_all".
 *
 * @property string $hospcode
 * @property string $month
 * @property string $person
 * @property string $death
 * @property string $service
 * @property string $accident
 * @property string $diagnosis_opd
 * @property string $procedure_opd
 * @property string $ncdscreen
 * @property string $chronicfu
 * @property string $labfu
 * @property string $chronic
 * @property string $fp
 * @property string $epi
 * @property string $nutrition
 * @property string $prenatal
 * @property string $anc
 * @property string $labor
 * @property string $postnatal
 * @property string $newborn
 * @property string $newborncare
 * @property string $dental
 * @property string $admission
 * @property string $diagnosis_ipd
 * @property string $procedure_ipd
 */
class SysCountAll extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_count_all';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hospcode', 'month'], 'required'],
            [['person', 'death', 'service', 'accident', 'diagnosis_opd', 'procedure_opd', 'ncdscreen', 'chronicfu', 'labfu', 'chronic', 'fp', 'epi', 'nutrition', 'prenatal', 'anc', 'labor', 'postnatal', 'newborn', 'newborncare', 'dental', 'admission', 'diagnosis_ipd', 'procedure_ipd'], 'integer'],
            [['hospcode'], 'string', 'max' => 5],
            [['month'], 'string', 'max' => 6]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'hospcode' => 'Hospcode',
            'month' => 'Month',
            'person' => 'Person',
            'death' => 'Death',
            'service' => 'Service',
            'accident' => 'Accident',
            'diagnosis_opd' => 'Diagnosis Opd',
            'procedure_opd' => 'Procedure Opd',
            'ncdscreen' => 'Ncdscreen',
            'chronicfu' => 'Chronicfu',
            'labfu' => 'Labfu',
            'chronic' => 'Chronic',
            'fp' => 'Fp',
            'epi' => 'Epi',
            'nutrition' => 'Nutrition',
            'prenatal' => 'Prenatal',
            'anc' => 'Anc',
            'labor' => 'Labor',
            'postnatal' => 'Postnatal',
            'newborn' => 'Newborn',
            'newborncare' => 'Newborncare',
            'dental' => 'Dental',
            'admission' => 'Admission',
            'diagnosis_ipd' => 'Diagnosis Ipd',
            'procedure_ipd' => 'Procedure Ipd',
        ];
    }
}

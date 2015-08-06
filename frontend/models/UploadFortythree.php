<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "upload_fortythree".
 *
 * @property integer $id
 * @property string $hospcode
 * @property string $file_name
 * @property string $file_size
 * @property string $upload_date
 * @property string $upload_time
 * @property string $note1
 * @property string $note2
 * @property string $note3
 * @property string $note4
 * @property string $note5
 */
class UploadFortythree extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $file;
    public static function tableName()
    {
        return 'upload_fortythree';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file'],
            [['hospcode', 'file_name', 'file_size', 'upload_date', 'upload_time', 'note1', 'note2', 'note3', 'note4', 'note5'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file' => 'ไฟล์ 43 แฟ้ม (zip)',
            'id' => 'ID',
            'hospcode' => 'Hospcode',
            'file_name' => 'File Name',
            'file_size' => 'File Size',
            'upload_date' => 'Upload Date',
            'upload_time' => 'Upload Time',
            'note1' => 'Note1',
            'note2' => 'Note2',
            'note3' => 'Note3',
            'note4' => 'Note4',
            'note5' => 'Note5',
        ];
    }
}

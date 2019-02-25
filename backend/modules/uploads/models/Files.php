<?php

namespace backend\modules\uploads\models;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property int $id File ID
 * @property string $file_name File Name
 * @property string $file_name_org File Name Original
 * @property string $file_detail File Detail
 * @property int $created_by Create By
 * @property string $create_date Create Date
 * @property int $update_by Update By
 * @property string $update_date Update Date
 * @property int $deleted Status
 * @property int $forder Order By
 * @property int $folder_id Folder Id
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           
            [['id', 'created_by', 'updated_by', 'deleted', 'forder', 'folder_id'], 'integer'],
            [['file_detail'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['file_name', 'file_name_org'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'File ID'),
            'file_name' => Yii::t('app', 'File Name'),
            'file_name_org' => Yii::t('app', 'File Name Original'),
            'file_detail' => Yii::t('app', 'File Detail'),
            'created_by' => Yii::t('app', 'Create By'),
            'created_date' => Yii::t('app', 'Create Date'),
            'updated_by' => Yii::t('app', 'Update By'),
            'updated_date' => Yii::t('app', 'Update Date'),
            'deleted' => Yii::t('app', 'Status'),
            'forder' => Yii::t('app', 'Order By'),
            'folder_id' => Yii::t('app', 'Folder Id'),
        ];
    }
}

<?php

namespace backend\modules\uploads\models;

use Yii;

/**
 * This is the model class for table "folders".
 *
 * @property int $id Folder Id
 * @property string $name Folder Name
 * @property int $parent_id Parent Id
 * @property int $forder Order By
 * @property string $icon Icon
 * @property string $detail Detail
 * @property int $created_by Create By
 * @property string $created_date Create Date
 * @property int $updated_by Update By
 * @property string $update_date Update Date
 * @property int $deleted Status
 */
class Folders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'folders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'parent_id', 'forder', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['detail'], 'string'],
            [['created_date', 'update_date'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['icon'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Folder Id'),
            'name' => Yii::t('app', 'Folder Name'),
            'parent_id' => Yii::t('app', 'Parent Id'),
            'forder' => Yii::t('app', 'Order By'),
            'icon' => Yii::t('app', 'Icon'),
            'detail' => Yii::t('app', 'Detail'),
            'created_by' => Yii::t('app', 'Create By'),
            'created_date' => Yii::t('app', 'Create Date'),
            'updated_by' => Yii::t('app', 'Update By'),
            'update_date' => Yii::t('app', 'Update Date'),
            'deleted' => Yii::t('app', 'Status'),
        ];
    }
}

<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Reques for project model
 * 
 * @property integer $id;
 * @property integer $user_id
 * @property integer $project_id
 * @property integer $status ()
 * 
 */
class ProjectRequest extends ActiveRecord
{
    const STATUS_NEW = 1; // Новая
    const STATUS_CONFIRMED = 2; // Принята
    const STATUS_REJECTED = 3; // Отклонена
    const PAGE_SIZE = 10; //

    /** @inheritdoc */
    public static function tableName()
    {
        return '{{%request}}';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['user_id', 'project_id'], 'required'],
            [['status'], 'default', 'value' => null],
        ];
    }
    
    /**
     * Relation. 
     * 
     * @return ArrayQuery
     */
    public function getProfile()
    {
        return $this->hasOne(User\Profile::className(), ['user_id' => 'user_id']);
    }

}

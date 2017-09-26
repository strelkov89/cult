<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * ContactForm is the model behind the contact form.
 * 
 * @property integer $id;
 * @property integer $created_at
 * @property integer $updated_at
 * @property string  $title
 * @property text    $description
 * @property integer $author_id
 * @property boolean $need_coder
 * @property boolean $need_designer
 * @property boolean $need_ux
 * @property integer $status
 * 
 */
class Project extends ActiveRecord
{
    const STATUS_NEW = 1; //Формируется
    const STATUS_MODERATE = 2; // отправлен на модерацию
    const STATUS_CONFIRM = 3; //Модерация пройдена
    const LABEL_NEW = 'Создать проект';
    const LABEL_EDIT = 'Мой проект';

    /** @inheritdoc */
    public static function tableName()
    {
        return '{{%project}}';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title', 'description', 'author_id'], 'required'],
            [['need_coder', 'need_designer', 'need_ux'], 'boolean'],
            [['status'], 'default', 'value' => null],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'description' => 'Описание',
            'need_coder' => 'Программист',
            'need_designer' => 'Дизайнер',
            'need_ux' => 'Автор идеи', //'UX-специалист',
        ];
    }

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

}
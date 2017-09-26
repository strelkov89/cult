<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * mail to user
 * 
 * 
 */
class MailToUser extends \yii\base\Model
{
    public $subject;
    public $message;
    public $email;
    public $emailto;
    public $name;
    public $returnUrl;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['subject', 'message', 'email', 'emailto'], 'required'],
            [['name', 'returnUrl'], 'string'],
        ];
    }
    
    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'subject' => 'Тема',
            'message' => 'Сообщение',
        ];
    }

}

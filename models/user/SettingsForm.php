<?php

namespace app\models\user;

use dektrium\user\models\SettingsForm as BaseSettingsForm;

class SettingsForm extends BaseSettingsForm
{
    /** @var string */
    public $phone;

    public function rules()
    {
        $rules = parent::rules();
        // Костыль!
        foreach($rules as $key => $item){
            if (isset($item[0]) && $item[0] == 'username' && isset($item[1]) && $item[1] == 'match'){
                $rules[$key]['pattern'] = '/.*/';
                break;
            }
        }
        $rules[] = ['phone', 'required'];
        $rules[] = ['phone', 'match', 'pattern' => '/^[0-9\(\)\+\- ]+$/i', 'message' => 'Разрешенно использовать только цифры и знаки: ()+-'];
        return $rules;
    }

    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['phone'] = 'Телефон';
        return $attributeLabels;
    }
    
    public function save()
    {
        $this->user->phone = $this->phone;
        $this->username = $this->email;
        return parent::save();
    }

}

<?php

namespace app\models\user;

use dektrium\user\models\LoginForm as BaseLoginForm;
use app\models\user\User;


class LoginForm extends BaseLoginForm
{
    public $rememberMe = false;
  
    /** @inheritdoc */
    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            ['login', 'trim'],
            ['password', function ($attribute) {
                
            }],
            ['login', function ($attribute) {
                
            }],
            ['rememberMe', 'boolean'],
        ];
    }

    /**
     * Validates form and logs the user in.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        
        //print_r(\Yii::$app->getUser()->login('asd')); die;
        //$this->validate();
        //print_r($this->getErrors());
        if ($this->validate()) {//echo "!"; die;
            return \Yii::$app->getUser()->login($this->user, $this->rememberMe ? $this->module->rememberFor : 0);
        } else {echo "?"; die;
            return false;
        }
    }

    /** @inheritdoc */
    public function beforeValidate()
    {        
        if (parent::beforeValidate()) {
            //$this->user = $this->finder->findUserByUsernameOrEmail($this->login);
            
            $this->user = USER::findOne(['uid'=>'16a550b0-1f1d-11e5-a1cc-bc5ff4e557a5']);
            
            //print_r($this->user); die;
            return true;
        } else {
            return false;
        }
    }
}

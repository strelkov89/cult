<?php

namespace app\models\user;

use dektrium\user\models\User as BaseUser;
use dektrium\user\models\Token;
use app\models\user\Profile;

class User extends BaseUser
{
    const TYPE_HACKATHON = 1;
    const TYPE_DEMOCAMP = 2;

    /** @inheritdoc */
    public function rules()
    {
        return [
            // username rules
            ['username', 'required', 'on' => ['register', 'connect', 'create', 'update']],
            ['username', 'string', 'min' => 1, 'max' => 255],
            ['username', 'trim'],
            // email rules
            ['email', 'required', 'on' => ['register', 'connect', 'create', 'update']],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique'],
            ['email', 'trim'],
            // password rules
            ['password', 'required', 'on' => ['register']],
            ['password', 'string', 'min' => 6, 'on' => ['register', 'create']],
        ];
    }

    /** @inheritdoc */
    public function scenarios()
    {
        return [
            'register' => ['username', 'email', 'password'],
            'connect' => ['username', 'email'],
            'create' => ['username', 'email', 'password'],
            'update' => ['username', 'email', 'password'],
            'settings' => ['username', 'email', 'password'],
            'default' => ['email', 'phone', 'firstName', 'lastName']
        ];
    }

    /* Название атрибута для вывода на экран */

    public function attributeLabels()
    {
        $attr = parent::attributeLabels();
        $attr['firstName'] = 'Имя';
        $attr['lastName'] = 'Фамилия';
        return $attr;
    }

    public function is_myadmin()
    {
        return ($this->is_admin > 0) ? 1 : null;
    }

    public function is_hackathon()
    {
        return ($this->type == self::TYPE_HACKATHON) ? 1 : null;
    }

    public function is_democamp()
    {
        return ($this->type == self::TYPE_DEMOCAMP) ? 1 : null;
    }

    /* Связь с моделью Profile */

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

    /* Геттер для имени */
    public function getFirstName()
    {
        return $this->profile->name;
    }
    /* Геттер для фамилии */
    public function getLastName()
    {
        return $this->profile->lastName;
    }

    /**
     * Attempts user confirmation.
     *
     * @param string $code Confirmation code.
     *
     * @return boolean
     */
    public function attemptConfirmation($code)
    {
        $this->module->confirmWithin = 99999999999999999986400;
        $token = $this->finder->findTokenByParams($this->id, $code, Token::TYPE_CONFIRMATION);

        if ($token instanceof Token && !$token->isExpired) {
            $token->delete();
            if (($success = $this->confirm())) {
                \Yii::$app->user->login($this, $this->module->rememberFor);
                $message = \Yii::t('user', 'Thank you, registration is now complete.');
            } else {
                $message = \Yii::t('user', 'Something went wrong and your account has not been confirmed.');
            }
        } else {
            $myUser = User::findOne(['id' => $this->id]);
            if ($myUser) {
                $this->confirm();
                \Yii::$app->session->setFlash('success', \Yii::t('user', 'Thank you, registration is now complete.'));
                \Yii::$app->user->login($this);
                return true;
            }
        }

        \Yii::$app->session->setFlash($success ? 'success' : 'danger', $message);

        return $success;
    }

}
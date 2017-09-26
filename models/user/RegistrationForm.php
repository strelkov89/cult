<?php

namespace app\models\user;

use dektrium\user\models\RegistrationForm as BaseRegistrationForm;

class RegistrationForm extends BaseRegistrationForm
{
    /** @var string */
    public $firstName;
    public $lastName;
    public $role;
    public $type;
    public $phone;
    public $city;
    public $about;
    public $username;
    public $disclaimer;
    /* Democamp form*/
    public $title;
    public $url;
    public $stage;
    public $direction;
    public $description;

    public function rules()
    {
        $user = $this->module->modelMap['User'];

        $rules = [
            // username rules
            'usernameLength' => ['username', 'string', 'min' => 3, 'max' => 255],
            'usernameTrim' => ['username', 'filter', 'filter' => 'trim'],
            'usernamePattern' => ['username', 'match', 'pattern' => $user::$usernameRegexp],
            'usernameRequired' => ['username', 'default', 'value' => null],
            // email rules
            'emailTrim' => ['email', 'filter', 'filter' => 'trim'],
            'emailRequired' => ['email', 'required'],
            'emailPattern' => ['email', 'email'],
            'emailUnique' => [
                'email',
                'unique',
                'targetClass' => $user,
                'message' => \Yii::t('user', 'This email address has already been taken')
            ],
            // password rules
            'passwordRequired' => ['password', 'required', 'skipOnEmpty' => $this->module->enableGeneratingPassword],
            'passwordLength' => ['password', 'string', 'min' => 6],
        ];

        // Костыль!
        foreach ($rules as $key => $item) {
            if (isset($item[0]) && $item[0] == 'username' && isset($item[1]) && $item[1] == 'match') {
                $rules[$key]['pattern'] = '/.*/';
                break;
            }
        }
        $rules[] = ['phone', 'required'];
        $rules[] = ['phone', 'string', 'min' => 11];
        $rules[] = ['phone', 'match', 'pattern' => '/^[0-9\(\)\+\- ]+$/i', 'message' => 'Разрешенно использовать только цифры и знаки: ()+-'];
        // pofile
        $rules[] = [['about'], 'string'];
        $rules[] = [['firstName', 'lastName'], 'required'];
        $rules[] = [['firstName', 'lastName', 'city'], 'string', 'max' => 255];

        $rules[] = ['disclaimer', 'match', 'pattern' => '/^[1-9]+$/i', 'message' => 'Вы должны согласиться с условиями'];
        $rules[] = [['type', 'role', 'city', 'about'], 'default', 'value' => null];
        // democamp
        $rules[] = [['title', 'url', 'stage', 'direction', 'description'], 'default', 'value' => null];

        return $rules;
    }

    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['phone'] = 'ТЕЛЕФОННЫЙ НОМЕР';
        $attributeLabels['email'] = 'EMAIL';
        $attributeLabels['firstName'] = 'ИМЯ';
        $attributeLabels['lastName'] = 'ФАМИЛИЯ';
        $attributeLabels['city'] = 'ГОРОД';
        $attributeLabels['about'] = 'О СЕБЕ';
        $attributeLabels['disclaimer'] = 'Я прочитал <a href="/img/_index/regulations/regulations.docx">условия</a> и с ними согласен';
        $attributeLabels['title'] = 'НАЗВАНИЕ ПРОЕКТА';
        $attributeLabels['url'] = 'ССЫЛКА НА ПРОЕКТ';
        $attributeLabels['description'] = 'КРАТКОЕ РЕЗЮМЕ ПРОЕКТА';
        return $attributeLabels;
    }

    /**
     * Registers a new user account. If registration was successful it will set flash message.
     *
     * @return bool
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }


        /** @var User $user */
        $user = \Yii::createObject(User::className());
        $user->setScenario('register');
        $this->loadAttributes($user);
        $user->phone = $this->phone;
        $user->username = $this->email;
        $user->type = $this->type;

        if (!$user->register()) {
            return false;
        }

        \Yii::$app->session->setFlash(
            'success', \Yii::t('user', 'Your account has been created and a message with further instructions has been sent to your email')
        );

        return true;
    }

}
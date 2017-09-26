<?php

/**
 * Created by PhpStorm.
 * User: x
 * Date: 02/02/15
 * Time: 13:47
 */

namespace app\models\user;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "profile".
 *
 * @property integer $user_id
 * @property string  $name
 * @property string  $lastName
 * @property string  $gravatar_email
 * @property string  $gravatar_id
 * @property string  $bio
 * @property boolean $is_coder
 * @property boolean $is_designer
 * @property boolean $is_ux
 * @property string  $portfolio_images
 * @property string  $portfolio_links
 *
 * @author Aleksei Akireikin <opexus@gmail.com>
 */
class Profile extends ActiveRecord
{
    /** @var \dektrium\user\Module */
    protected $module;
    public $roleArr;
    
    /** @inheritdoc */
    public function init()
    {
        $this->module = \Yii::$app->getModule('user');
    }

    /** @inheritdoc */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bio'], 'string'],
            [['gravatar_email'], 'email'],
            [['is_coder', 'is_designer', 'is_ux'], 'boolean'],
            [['name', 'lastName', 'city'], 'string', 'max' => 255],
            [['portfolio_images', 'portfolio_links'], 'string', 'max' => 4095],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'name' => \Yii::t('user', 'Name'),
            'lastName' => 'Фамилия',
            'city' => 'Город',
            'gravatar_email' => \Yii::t('user', 'Gravatar email'),
            'bio' => \Yii::t('user', 'Bio'),
            'is_coder' => 'Программист',
            'is_designer' => 'Дизайнер',
            'is_ux' => 'Автор идеи',
            'portfolio_images' => 'Изображения',
            'portfolio_links' => 'Ссылки на проекты',
        ];
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isAttributeChanged('gravatar_email')) {
                $this->setAttribute('gravatar_id', md5($this->getAttribute('gravatar_email')));
            }
            return true;
        }

        return false;
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getUser()
    {
        return $this->hasOne($this->module->modelMap['User'], ['id' => 'user_id']);
    }

    /**
     * @return array
     */
    public function getPortfolioImages()
    {
        return $this->portfolio_images ? explode(' ', $this->portfolio_images) : [];
    }

    /**
     * @return array
     */
    public function getPortfolioLinks()
    {
        return $this->portfolio_links ? explode(' ', $this->portfolio_links) : [];
    }

    /**
     * @return array
     */
    public function getSkills()
    {
        $profile = $this;
        return array_filter(['is_coder', 'is_designer', 'is_ux'], function ($attribute) use ($profile) {
            return $profile->{$attribute};
        });
    }

    /**
     * Relation.
     * 
     * @return ArrayQuery
     */
    public function getRequests()
    {
        return $this->hasMany(\app\models\ProjectRequest::className(), ['user_id' => 'user_id']);
    }
}
<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "democamp".
 *
 * @property integer $id
 * @property string $title
 * @property integer $direction
 * @property string $description
 * @property integer $stage
 * @property string $url
 * @property integer $author_id
 *
 */
class Democamp extends \yii\db\ActiveRecord
{
    const DIRECTIONARR = [
        '1' => 'Медицина',
        '2' => 'Экология',
        '3' => 'Образовательные',
        '4' => 'Финансы, банкинг',
        '5' => 'Социальные',
        '6' => 'Мультимедиа',
        '7' => 'Контент',
        '8' => 'Бизнес',
        '9' => 'Спорт',
        '10' => 'Другое',
    ];
    const STAGEARR = [
        '1' => 'Предшествующая посевной стадия',
        '2' => 'Посевная стадия',
        '3' => 'Прототип',
        '4' => 'Работающий прототип',
        '5' => 'Альфа-версия проекта или продукта',
        '6' => 'Закрытая бета-версия проекта или продукта',
        '7' => 'Публичная бета-версия проекта или продукта',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'democamp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['direction', 'stage', 'author_id'], 'integer'],
            [['title', 'direction', 'description', 'stage'], 'required'],
            [['title', 'url'], 'string', 'max' => 245],
            [['url'], 'default', 'value' => null],
            [['description'], 'string', 'min' => 50, 'max' => 350]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Название проекта',
            'url' => 'Ссылка на проект',
            'direction' => 'Направление',
            'description' => 'Краткое резюме проекта',
            'stage' => 'Стадия проекта',
        ];
    }

    /**
     * 
     * @param string $userId
     * @return boolean
     */
    public static function userHasOwnDemocamp($userId)
    {
        return self::findOne(['author_id' => $userId]);
    }
    
    public static function getDirection($key)
    {
        $arr = self::DIRECTIONARR;
        return isset($arr[$key]) ? $arr[$key] : null;
    }
    public static function getStage($key)
    {
        $arr = self::STAGEARR;
        return isset($arr[$key]) ? $arr[$key] : null;
    }
    
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegs()
    {
        /* If we had current team with some developers - then they have the same democamp issue */
        return $this->hasMany(Registration::className(), ['id' => 'author_id']);
    }

}
<?php

namespace app\models\user;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\user\User;
use app\models\user\Profile;

/**
 * Registration search model
 * 
 * 
 */
class UserSearch extends User
{
    const PAGE_SIZE = 100;

    public $firstName;
    public $lastName;

    public function rules()
    {
        // only fields in rules() are searchable
        return [
            //[['ticket'], 'integer'],
            [['email', 'phone', 'firstName', 'lastName'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = User::find();

        $query->where('confirmed_at > 0')->andWhere('(is_deleted is null or is_deleted = 0)')->andWhere('type = '.self::TYPE_HACKATHON.'');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);

        // load the seach form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'phone', $this->phone]);
        //$query->andFilterWhere(['like', 'ticket', $this->ticket]);

        return $dataProvider;
    }

    public function AdminSearch($params)
    {
        $query = User::find();

        $query->where('confirmed_at > 0')->andWhere('(is_deleted is null or is_deleted = 0)');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);

        // load the seach form data and validate
        if (!($this->load($params) && $this->validate())) {
            $query->joinWith(['profile']);
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'phone', $this->phone]);

        // Фильтр по имени
        $query->joinWith(['profile' => function ($q) {
            $q->andFilterWhere(['like', 'profile.name', $this->firstName]);
            $q->andFilterWhere(['like', 'profile.lastName', $this->lastName]);
            }]);

        return $dataProvider;
    }

    public function ProdSearch($params)
    {
        $query = User::find();

        $query->where('confirmed_at > 0')->andWhere('(is_deleted is null or is_deleted = 0)')->andWhere('type = '.self::TYPE_HACKATHON)->JoinWith('profile');

        $role = \Yii::$app->request->get('role');
        if ($role) {
            if ($role == 1)
                $query->andWhere('(profile.is_coder > 0)');
            elseif ($role == 2)
                $query->andWhere('(profile.is_designer > 0)');
            elseif ($role == 3)
                $query->andWhere('(profile.is_ux > 0)');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        // load the seach form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'phone', $this->phone]);
        //$query->andFilterWhere(['like', 'ticket', $this->ticket]);

        return $dataProvider;
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

}
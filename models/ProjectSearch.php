<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\user\User;
use app\models\Project;

/**
 * Registration search model
 * 
 * 
 */
class ProjectSearch extends Project
{
    const PAGE_SIZE = 100;

    public function rules()
    {
        // only fields in rules() are searchable
        return [
            //[['ticket'], 'integer'],
            [['title'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Project::find();
                      
        $query->where('id > 0')->andWhere('(is_deleted is null or is_deleted = 0)');        

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
        $query->andFilterWhere(['like', 'title', $this->title]);
        //$query->andFilterWhere(['like', 'email', $this->email]);
        //$query->andFilterWhere(['like', 'ticket', $this->ticket]);

        return $dataProvider;
    }

}

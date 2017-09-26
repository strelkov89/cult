<?php

/**
 * Контроллер для идей
 *
 * 
 */

namespace app\controllers;

use app\models\GoogleAnalytics;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Project;
use app\models\ProjectSearch;
use DateTime;
use app\models\user\Profile;
use app\models\user\User;
use app\models\user\UserSearch;
use app\models\ProjectRequest;
use app\models\ProjectManager;
use app\models\Ticket;
use app\models\Democamp;
use yii\data\ActiveDataProvider;
use Exception;
// for performAjaxValidation
use yii\db\ActiveRecord;
use yii\web\Response;
use yii\widgets\ActiveForm;

class AdminController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'projects', 'democamps', 'removeproject', 'removedemocamp'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['remove', 'visited', 'moderated', 'removeproject', 'removedemocamp'],
                        'allow' => true,
                        'roles' => ['@'],
                        'verbs' => ['POST'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $projectManager = new ProjectManager;

        $searchModel = new UserSearch();
        $userProvider = $searchModel->AdminSearch(Yii::$app->request->get());

        return $this->render('index', [
                'userProvider' => $userProvider,
                'searchModel' => $searchModel,
                'confirmedCount' => User::find()->where("(is_moderated >= 1) and (is_deleted = 0 or is_deleted is null)")->count(),
                'visitedCount' => User::find()->where("(is_deleted = 0 or is_deleted is null) and (is_visited >=1)")->count()
        ]);
    }

    public function actionRemove()
    {
        $user = User::findOne(['id' => Yii::$app->user->id]);

        if (!$user->is_myadmin()) {
            return null;
        }

        $user = User::findOne(['id' => Yii::$app->request->post('id')]);

        if ($user) {
            return $user->updateAttributes(['is_deleted' => 1]);
        }
        return null;
    }

    public function actionVisited()
    {
        $user = User::findOne(['id' => Yii::$app->user->id]);

        if (!$user->is_myadmin()) {
            return null;
        }

        $user = User::findOne(['id' => Yii::$app->request->post('id')]);

        if ($user) {
            if ($user->is_visited)
                return $user->updateAttributes(['is_visited' => 0]);
            else
                return $user->updateAttributes(['is_visited' => 1]);
        }
        return null;
    }

    /**
     * 
     * @return string|null
     */
    public function actionModerated()
    {
        $user = User::findOne(['id' => Yii::$app->user->id]);

        if (!$user->is_myadmin()) {
            return null;
        }

        $user = User::findOne(['id' => Yii::$app->request->post('id')]);
        if ($user) {
            /*
              if ($user->is_moderated)
              return $user->updateAttributes(['is_moderated' => 0]);
              else {
              return $user->updateAttributes(['is_moderated' => 1]);
              } */
            if (!$user->is_moderated) {
                $ticket = new Ticket($user);

                if ($ticket->createImage()) {
                    if ($ticket->sendToEmail()) {
                        return $ticket->number;
                    }
                    throw new Exception('Ticket model email can not be send');
                }
                throw new Exception('Ticket model image can not be create');
            }
        }
        return null;
    }

    public function actionProjects()
    {
        $projectManager = new ProjectManager;

        $searchModel = new ProjectSearch();
        $projectProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('projects', [
                'projectProvider' => $projectProvider,
                'searchModel' => $searchModel,
                'confirmedCount' => Project::find()->where("id > 0")->count()
        ]);
    }

    public function actionDemocamps()
    {
        $democampModel = new Democamp();
        $democampProvider = new ActiveDataProvider([
            'query' => Democamp::find()->where("title IS NOT NULL"),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('democamps', [
                'democampProvider' => $democampProvider,
                'democampModel' => $democampModel
        ]);
    }

    public function actionRemovedemocamp()
    {
        $user = User::findOne(['id' => Yii::$app->user->id]);

        if (!$user->is_myadmin()) {
            return null;
        }

        $project = Democamp::findOne(['id' => Yii::$app->request->post('id')]);


        if ($project) {
            $projectUser = User::findOne(['id' => $project->author_id]);
            if ($projectUser) {
                $projectEmail = $projectUser->email;
                $projectName = $project->title;
            } else
                return null;

            $project->delete();
            Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['email'])
                ->setTo($projectEmail)
                ->setSubject('Ваш демокемп "'.$projectName.'" удалён администратором сайта')
                ->setHtmlBody('Ваш демокемп удалён администратором сайта.'
                    .'<br><br>Команда Apps4All<br>')
                ->send();
            return 1;

            //return $project->updateAttributes(['is_deleted' => 1]);
        }
        return null;
    }

    public function actionRemoveproject()
    {
        $user = User::findOne(['id' => Yii::$app->user->id]);

        if (!$user->is_myadmin()) {
            return null;
        }

        $project = Project::findOne(['id' => Yii::$app->request->post('id')]);


        if ($project) {
            $projectUser = User::findOne(['id' => $project->author_id]);
            if ($projectUser) {
                $projectEmail = $projectUser->email;
                $projectName = $project->title;
            } else
                return null;

            $project->delete();
            Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['email'])
                ->setTo($projectEmail)
                ->setSubject('Ваш проект "'.$projectName.'" удалён администратором сайта')
                ->setHtmlBody('Ваш проект удалён администратором сайта.'
                    .'<br><br>Команда Apps4All<br>')
                ->send();
            return 1;

            //return $project->updateAttributes(['is_deleted' => 1]);
        }
        return null;
    }

    /**
     * Performs ajax validation.
     * @param Model $model
     * @throws \yii\base\ExitException
     */
    protected function performAjaxValidation(ActiveRecord $model)
    {
        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            echo json_encode(ActiveForm::validate($model));
            \Yii::$app->end();
        }
    }

}
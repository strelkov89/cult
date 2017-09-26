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
use DateTime;
use app\models\user\Profile;
use app\models\ProjectRequest;
use app\models\ProjectManager;
use app\models\MailToUser;
use yii\data\ActiveDataProvider;
use Exception;
// for performAjaxValidation
use yii\db\ActiveRecord;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ProjectController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'list', 'message', 'mail'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create', 'edit', 'join', 'request_confirm', 'request_reject', 'remove'],
                        'allow' => true,
                        'roles' => ['@'],
                        'verbs' => ['POST'],
                    ],
                ],
            ],
        ];
    }

    public function actionRemove()
    {
        $projectManager = new ProjectManager;
        $project = $projectManager->getUserProject(Yii::$app->user->identity->id);
        $project->delete();
        return $this->redirect('/project');
    }

    public function actionIndex()
    {
        $projectManager = new ProjectManager;

        $project = $projectManager->getUserProject(Yii::$app->user->identity->id);
        if (!$project)
            $project = new Project();

        if ($project->is_deleted) {
            return $this->render('deleted', [
                    'project' => $project,
            ]);
        }

        if ($project->id) {
            $newRequestsProvider = new ActiveDataProvider([
                'query' => Profile::find()->joinWith('requests')
                    ->where('`request`.project_id = '.$project->id)
                    ->andWhere('`request`.status = '.ProjectRequest::STATUS_NEW)
                ,
                'pagination' => ['pageSize' => ProjectRequest::PAGE_SIZE,],
            ]);

            $confirmedRequestsProvider = new ActiveDataProvider([
                'query' => Profile::find()->joinWith('requests')
                    ->where('`request`.project_id = '.$project->id)
                    ->andWhere('`request`.status = '.ProjectRequest::STATUS_CONFIRMED)
                ,
                'pagination' => ['pageSize' => ProjectRequest::PAGE_SIZE,],
            ]);
        } else {
            $newRequestsProvider = $confirmedRequestsProvider = null;
        }

        return $this->render('index', [
                'project' => $project,
                'newRequestsProvider' => $newRequestsProvider,
                'confirmedRequestsProvider' => $confirmedRequestsProvider,
        ]);
    }

    public function actionMessage()
    {
        $projectManager = new ProjectManager;

        $project = $projectManager->getUserProject(Yii::$app->user->identity->id);
        if (!$project)
            $project = new Project();

        if ($project->id) {
            $newRequestsProvider = new ActiveDataProvider([
                'query' => Profile::find()->joinWith('requests')
                    ->where('`request`.project_id = '.$project->id)
                    ->andWhere('`request`.status = '.ProjectRequest::STATUS_NEW)
                ,
                'pagination' => ['pageSize' => ProjectRequest::PAGE_SIZE,],
            ]);

            $confirmedRequestsProvider = new ActiveDataProvider([
                'query' => Profile::find()->joinWith('requests')
                    ->where('`request`.project_id = '.$project->id)
                    ->andWhere('`request`.status = '.ProjectRequest::STATUS_CONFIRMED)
                ,
                'pagination' => ['pageSize' => ProjectRequest::PAGE_SIZE,],
            ]);
        } else {
            $newRequestsProvider = $confirmedRequestsProvider = null;
        }

        return $this->render('message', [
                'project' => $project,
                'newRequestsProvider' => $newRequestsProvider,
                'confirmedRequestsProvider' => $confirmedRequestsProvider
        ]);
    }

    /**
     * Project save
     */
    public function actionCreate()
    {
        $projectManager = new ProjectManager;

        $project = new Project();
        $this->performAjaxValidation($project);

        if ($project->load(\Yii::$app->request->post())) {
            $projectManager->prepareProject($project);

            if ($projectManager->userCanCreateProject(Yii::$app->user->identity->id)) {
                if ($project->save()) {

                    $userProfile = Profile::findOne(['user_id' => Yii::$app->user->identity->id]);
                    $projectManager->deleteAllUsersRequest($userProfile);

                    $post = Yii::$app->request->post();
                    $project = Project::findOne(['author_id' => $project->author_id]);

                    Yii::$app->session->setFlash('success', 'Проект успешно создан');
                    return $this->redirect('/project');
                }
            }
            Yii::$app->session->setFlash('danger', $projectManager->message);
            return $this->redirect('/project');
        }
    }

    /**
     * Project save
     */
    public function actionEdit()
    {
        $projectManager = new ProjectManager;
        $project = $projectManager->getUserProject(Yii::$app->user->identity->id);

        if (!$projectManager->userCanChangeProject($project)) {
            return $this->redirect('/project');
        }

        $this->performAjaxValidation($project);

        if ($project->load(\Yii::$app->request->post())) {
            $projectManager->prepareProject($project);

            if ($project->save()) {
                $post = Yii::$app->request->post();

                if ($project->status == Project::STATUS_MODERATE)
                    Yii::$app->session->setFlash('success', 'Проект успешно отправлен на модерацию');
                else
                    Yii::$app->session->setFlash('success', 'Проект успешно изменён');

                return $this->redirect('/project');
            }
        }
    }

    /**
     * list projects
     */
    public function actionList()
    {
        $userProfile = Profile::findOne(['user_id' => Yii::$app->user->identity->id]);

        $projectsProvider = new ActiveDataProvider([
            'query' => Project::find()->where(["status" => Project::STATUS_NEW])->andWhere('(is_deleted is null or is_deleted < 1)'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('/project/list', ['projectsProvider' => $projectsProvider, 'userProfile' => $userProfile]);
    }

    /**
     * ProjectRequest save
     */
    public function actionJoin()
    {
        if (isset($_POST['projectId'])) {
            $projectManager = new ProjectManager;
            $userProfile = Profile::findOne(['user_id' => Yii::$app->user->identity->id]);
            $request = new ProjectRequest;
            $request = $projectManager->prepareRequest($request);
            $project = Project::findOne(['id' => $request->project_id]);

            if ($projectManager->userCanJoinProject($userProfile, $project)) {
                $transaction = Yii::$app->db->beginTransaction();
                if ($request->save()) {
                    if ($projectManager->alertUserAboutNewRequest($userProfile, $project)) {
                        // ga
                        //$ga = new GoogleAnalytics(YII_DEBUG);
                        //$ga->trackEvent('Проект', 'Заявка на вступление', $userProfile->user->email);

                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Заявка на участие в проекте успешно отправлена');
                        return $this->redirect('/project/list');
                    }
                }
                $transaction->rollBack();
                Yii::$app->session->setFlash('danger', 'Заявка не отправлена. Пожалуйста, повторите запрос позже');
            }
            Yii::$app->session->setFlash('danger', $projectManager->message);
            return $this->redirect('/project/list');
        }
    }

    /**
     * ProjectRequest save
     */
    public function actionRequest_confirm()
    {
        $projectManager = new ProjectManager;
        $userProfile = Profile::findOne(['user_id' => Yii::$app->request->post('userId')]);
        $project = Project::findOne(['id' => Yii::$app->request->post('projectId')]);

        if (!$projectManager->userCanChangeProject($project)) {
            return $this->redirect('/project');
        }

        $transaction = Yii::$app->db->beginTransaction();
        if ($projectManager->projectNotUseEntireLimit($project)) { 
                        
            if (!$projectManager->userHasConfirmedRequest($userProfile->user->id) && $projectManager->confirmRequest($userProfile, $project)) {
                $projectManager->deleteAllUsersRequest($userProfile);

                if ($projectManager->alertUserThatRequestConfirmed($userProfile, $project)) {
                    $transaction->commit();

                    // ga
                    //$ga = new GoogleAnalytics(YII_DEBUG);
                    //$ga->trackEvent('Проект', 'Подтверждение заявки', $userProfile->user->email);

                    Yii::$app->session->setFlash('success', 'Заявка успешно подтверждена');
                    return $this->redirect('/project');
                }
                throw new Exception('Ошибка при отправке письма пользователю');
            }
        } else {            
            Yii::$app->session->setFlash('danger', 'Превышен лимит участников!'); 
            $transaction->rollBack();
            return $this->redirect('/project');
        }
        $transaction->rollBack();
        Yii::$app->session->setFlash('danger', 'Ошибка при подтверждении заявки. Пожалуйста, повторите запрос позже');
        return $this->redirect('/project');
    }

    /**
     * ProjectRequest save
     */
    public function actionRequest_reject()
    {
        $projectManager = new ProjectManager;
        $userProfile = Profile::findOne(['user_id' => Yii::$app->request->post('userId')]);
        $project = Project::findOne(['id' => Yii::$app->request->post('projectId')]);

        if (!$projectManager->userCanChangeProject($project)) {
            return $this->redirect('/project');
        }

        $transaction = Yii::$app->db->beginTransaction();
        if ($projectManager->rejectRequest($userProfile, $project)) {
            if ($projectManager->alertUserThatRequestReject($userProfile, $project)) {
                // ga
                //$ga = new GoogleAnalytics(YII_DEBUG);
                //$ga->trackEvent('Проект', 'Отклонение заявки', $userProfile->user->email);
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Пользователь успешно удалён из проекта');
                return $this->redirect('/project');
            }
        }
        $transaction->rollBack();

        Yii::$app->session->setFlash('danger', 'Ошибка при удалении участника. Пожалуйста, повторите запрос позже');
        return $this->redirect('/project');
    }

    /**
     * ProjectRequest save
     */
    public function actionMail()
    {
        $mailToUser = new MailToUser;
        $this->performAjaxValidation($mailToUser);

        if (isset($_POST['MailToUser'])) {
            if ($mailToUser->load(\Yii::$app->request->post())) {
                if (Yii::$app->mailer->compose()
                        ->setFrom(Yii::$app->params['email'])
                        ->setTo($mailToUser->emailto)
                        ->setSubject($mailToUser->subject)
                        ->setHtmlBody('Сообщение от пользователя "'.$mailToUser->name.'"('.$mailToUser->email.')'
                            .'<br><br>'.$mailToUser->message.'<br>')
                        ->send()) {
                    Yii::$app->session->setFlash('success', 'Сообщение успешно отправленно');
                    return $this->redirect($mailToUser->returnUrl);
                }
            }
            Yii::$app->session->setFlash('danger', 'При отправке сообщения возникла ошибка. Пожалуйста, попробуйте отправить сообщение повторно.');
            return $this->redirect($mailToUser->returnUrl);
        }
    }

    /**
     * Performs ajax validation.
     * @param Model $model
     * @throws \yii\base\ExitException
     */
    protected function performAjaxValidation($model)
    {
        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            echo json_encode(ActiveForm::validate($model));
            \Yii::$app->end();
        }
    }

}
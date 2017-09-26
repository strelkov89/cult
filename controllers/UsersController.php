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
use app\models\MailToUser;
use yii\data\ActiveDataProvider;
use Exception;
// for performAjaxValidation
use yii\db\ActiveRecord;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

class UsersController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'mail'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $projectManager = new ProjectManager;

        $searchModel = new UserSearch();
        $userProvider = $searchModel->ProdSearch(Yii::$app->request->get());

        return $this->render('index', [
                    'userProvider' => $userProvider,
                    'searchModel' => $searchModel,
        ]);
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
                                        .'<br><br>'.nl2br(Html::encode($mailToUser->message)).'<br>')
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
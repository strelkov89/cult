<?php

/**
 * Контроллер для идей
 *
 * 
 */

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Project;
use DateTime;
use app\models\user\Profile;
use app\models\ProjectRequest;
use app\models\ProjectManager;
use app\models\MailToUser;
use \app\models\Democamp;
use yii\data\ActiveDataProvider;
use Exception;
// for performAjaxValidation
use yii\db\ActiveRecord;
use yii\web\Response;
use yii\widgets\ActiveForm;

class DemocampController extends Controller
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

    public function actionIndex()
    {
        $democamp = Democamp::findOne(['author_id' => Yii::$app->user->identity->id]);
        if (!$democamp)
            $democamp = new Democamp();

        return $this->render('index', [
                'democamp' => $democamp,
        ]);
    }

    public function actionList()
    {
        $userProfile = Profile::findOne(['user_id' => Yii::$app->user->identity->id]);

        $democampProvider = new ActiveDataProvider([
            'query' => Democamp::find()->where('id > 0')->andWhere('title != ""')->andWhere('description != ""'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('/democamp/list', ['democampProvider' => $democampProvider, 'userProfile' => $userProfile]);
    }

    /**
     * Project save
     */
    public function actionCreate()
    {
        $democamp = new Democamp();
        $this->performAjaxValidation($democamp);

        if ($democamp->load(\Yii::$app->request->post())) {
            $democamp->author_id = Yii::$app->user->identity->id;
            if ($democamp->save()) {
                Yii::$app->session->setFlash('success', 'Демокемп успешно создан');
                return $this->redirect('/democamp');
            }

            Yii::$app->session->setFlash('danger', 'Демокемп не создан. Пожалуйста, попробуйте еще раз позже или обратитесь к администратору сайта');
            return $this->redirect('/democamp');
        }
        throw new \yii\web\HttpException(403, 'Access denied.');
    }

    /**
     * Project save
     */
    public function actionEdit()
    {
        $democamp = Democamp::findOne(['author_id' => Yii::$app->user->identity->id]);

        if ($democamp) {
            if ($democamp->load(\Yii::$app->request->post())) {
                $this->performAjaxValidation($democamp);

                if ($democamp->save()) {
                    Yii::$app->session->setFlash('success', 'Демокемп успешно изменён');
                    return $this->redirect('/democamp');
                }

                Yii::$app->session->setFlash('danger', 'Демокемп не изменён. Пожалуйста, попробуйте еще раз позже или обратитесь к администратору сайта');
                return $this->redirect('/democamp');
            }
        }
        throw new \yii\web\HttpException(403, 'Access denied.');
    }

    public function actionRemove()
    {
        $democamp = Democamp::findOne(['author_id' => Yii::$app->user->identity->id]);
        if ($democamp->delete()) {
            Yii::$app->session->setFlash('success', 'Демокемп успешно удалён');
            return $this->redirect('/democamp');
        }
        Yii::$app->session->setFlash('danger', 'Демокемп не удалён. Пожалуйста, попробуйте еще раз позже или обратитесь к администратору сайта');
        return $this->redirect('/democamp');
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
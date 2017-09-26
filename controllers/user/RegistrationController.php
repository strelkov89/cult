<?php

/**
 * Created by PhpStorm.
 * User: x
 * Date: 02/02/15
 * Time: 16:57
 */

namespace app\controllers\user;

use app\models\GoogleAnalytics;
use app\models\user\RegistrationForm;
use Yii;
use dektrium\user\controllers\RegistrationController as BaseRegistrationController;
use yii\web\NotFoundHttpException;
use app\models\user\SettingsForm;
use app\models\user\Profile;
use app\models\user\User;
use \app\models\Democamp;

class RegistrationController extends BaseRegistrationController
{

    /** @inheritdoc */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access']['rules'][] = ['allow' => true, 'actions' => ['newuser'], 'roles' => ['@']];

        return $behaviors;
    }

    /**
     * Confirms user's account. If confirmation was successful logs the user and shows success message. Otherwise
     * shows error message.
     * @param  integer $id
     * @param  string  $code
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionConfirm($id, $code)
    {
        $response = parent::actionConfirm($id, $code);

        // success confirmation
        if (Yii::$app->session->hasFlash('success')) {
            return $this->redirect(['settings/profile'], 302);
        }

        // error confirmation
        return $response;
    }

    /**
     * Displays the registration page.
     * After successful registration if enableConfirmation is enabled shows info message otherwise redirects to home page.
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionRegister()
    {
        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException;
        }
        $this->module->enableConfirmation = 1;
        $this->module->enableGeneratingPassword = 1;

        $model = \Yii::createObject(RegistrationForm::className());
        if (isset(\Yii::$app->request->post('register-form')['email']))
            $model->username = \Yii::$app->request->post('register-form')['email'];

        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->request->post()) && $model->register()) {

            $data = \Yii::$app->request->post('register-form');

            $user = User::findOne(['email' => $model->email]);
            $profile = Profile::findOne(['user_id' => $user->id]);
            $profile->city = @$data['city'];
            $profile->name = @$data['firstName'];
            $profile->lastName = @$data['lastName'];
            $profile->bio = @$data['about'];
            if (isset($data['role'])) {
                if ($data['role'] == 1)
                    $profile->is_coder = 1;
                elseif ($data['role'] == 2)
                    $profile->is_designer = 1;
                elseif ($data['role'] == 3)
                    $profile->is_ux = 1;
            }

            $profile->save();

            $democamp = new Democamp();
            $democamp->author_id = $user->id;
            $democamp->title = $model->title;
            $democamp->url = $model->url;
            $democamp->stage = $model->stage;
            $democamp->direction = $model->direction;
            $democamp->description = $model->description;
            $democamp->save(false);

            return $this->render('/message', [
                    'title' => \Yii::t('user', 'Your account has been created'),
                    'module' => $this->module,
            ]);
        }
        else {
            foreach ($model->getErrors() as $key => $item) {
                if (@$item[0] == 'Этот email уже используется') {
                    return $this->goHome();
                }
                Yii::$app->session->setFlash('danger', $item);
            }
            return $this->render('/message', [
                    'title' => 'ошибка при регистрации',
                    'module' => $this->module,
            ]);
        }


        return $this->goHome();
        /*
          return $this->render('register', [
          'model' => $model,
          'module' => $this->module,
          ]);
         * 
         */
    }

    public function actionNewuser()
    {
        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException;
        }
        $this->module->enableGeneratingPassword = 1;
        $this->module->enableConfirmation = 0;

        $model = \Yii::createObject(RegistrationForm::className());

        $this->performAjaxValidation($model);
        $admin = User::findOne(['id' => Yii::$app->user->id]);

        if ($model->load(\Yii::$app->request->post()) && $model->register()) {

            $data = \Yii::$app->request->post('register-form');

            $user = User::findOne(['email' => $model->email]);
            $profile = Profile::findOne(['user_id' => $user->id]);
            $profile->city = @$data['city'];
            $profile->name = @$data['firstName'];
            $profile->lastName = @$data['lastName'];
            $profile->bio = @$data['about'];
            if (isset($data['role'])) {
                if ($data['role'] == 1)
                    $profile->is_coder = 1;
                elseif ($data['role'] == 2)
                    $profile->is_designer = 1;
                elseif ($data['role'] == 3)
                    $profile->is_ux = 1;
            }

            $profile->save();

            //Yii::$app->user->logout();
            Yii::$app->user->login($admin);

            return $this->render('/message', [
                    'title' => \Yii::t('user', 'Your account has been created'),
                    'module' => $this->module,
            ]);
        }


        return $this->render('@app/views/admin/newuser', [
                'model' => $model,
                'module' => $this->module,
        ]);
    }

}
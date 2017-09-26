<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 30/01/15
 * Time: 17:01
 */

namespace app\controllers\user;

use app\models\GoogleAnalytics;
use dektrium\user\controllers\SecurityController as BaseSecurityController;
use dektrium\user\models\LoginForm;

class SecurityController extends BaseSecurityController
{
    /** @inheritdoc */
    public function behaviors()
    {
        // remove post Verb filter from logout action
        $behaviors = parent::behaviors();
        unset($behaviors['verbs']);

        return $behaviors;
    }

    /**
     * Displays the login page.
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        $model = \Yii::createObject(LoginForm::className());

        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->login()) {

            // ga
            //$ga = new GoogleAnalytics(YII_DEBUG);
            //$ga->trackEvent('Регистрация', 'Вход', $model->login);

            return $this->redirect(['settings/profile'], 302);
        }
        
        return $this->goHome();

        /*
        return $this->render('login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
         * 
         */
    }
}
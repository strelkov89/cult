<?php

namespace app\controllers\user;

use app\models\GoogleAnalytics;
use dektrium\user\controllers\SettingsController as BaseSettingsController;
use app\models\user\SettingsForm;

class SettingsController extends BaseSettingsController
{

    public function actionAccount()
    {
        if (isset($_POST['settings-form'])) {
            /** @var SettingsForm $model */
            $model = \Yii::createObject(SettingsForm::className());
            // Add phone
            $model->phone = $model->user->phone;

            $this->performAjaxValidation($model);

            if ($model->load(\Yii::$app->request->post()) && $model->save()) {
                \Yii::$app->session->setFlash('success', \Yii::t('user', 'Your account details have been updated'));
                return $this->redirect('/user/settings/profile');
            }
            
            foreach ($model->getErrors() as $key => $item) {
                \Yii::$app->session->setFlash('danger', $item);
            }

            return $this->redirect('/user/settings/profile');
        }
    }

    /**
     * Shows profile settings form.
     * @return string|\yii\web\Response
     */
    public function actionProfile()
    {
        $model = $this->finder->findProfileById(\Yii::$app->user->identity->getId());

        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your profile has been updated'));
            return $this->refresh();
        }

        /** @var SettingsForm $model */
        $account = \Yii::createObject(SettingsForm::className());
        // Add phone
        $account->phone = $account->user->phone;

        return $this->render('profile', [
                    'model' => $model,
                    'account' => $account,
        ]);
    }

}
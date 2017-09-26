<?php

namespace app\controllers\user;

use dektrium\user\controllers\RecoveryController as BaseRecoveryController;

use dektrium\user\Finder;
use dektrium\user\models\RecoveryForm;
use dektrium\user\models\Token;
use yii\base\Model;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class RecoveryController extends BaseRecoveryController
{

    /**
     * Shows page where user can request password recovery.
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionRequest()
    {
        if (!$this->module->enablePasswordRecovery) {
            throw new NotFoundHttpException;
        }

        $model = \Yii::createObject([
            'class'    => RecoveryForm::className(),
            'scenario' => 'request',
        ]);

        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->request->post()) && $model->sendRecoveryMessage()) {
            //\Yii::$app->session->setFlash('success', \Yii::t('user', 'Recovery message sent'));
            return $this->refresh();
        }

        return $this->render('request', [
            'model' => $model,
        ]);
    }

}

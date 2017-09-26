<?php
/*
 * Форма создания Проектов
 * 
 * @var Profile $teamProfile
 * 
 * 
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Project;
use app\models\ProjectManager;
use app\models\user\Profile;
use app\models\ProjectRequest;
use yii\data\ActiveDataProvider;
use app\models\MailToUser;

$projectManager = new ProjectManager;
?>

<div class="modal fade partmodal" id="participant-<?= $teamProfile->user_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                            
            </div>
            <div class="modal-body">
                <?php
                $form = ActiveForm::begin([
                        'action' => '/project/mail',
                        'options' => ['class' => 'form-horizontal'],
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-xs-12\">{input}</div>\n<div class=\"col-xs-12\">{error}\n{hint}</div>",
                            'labelOptions' => ['class' => 'col-xs-12 control-label'],
                        ],
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false
                ]);
                $mailToUser = new MailToUser;
                ?>


                <?php $name = Html::encode($userProfile->name).' '.Html::encode($userProfile->lastName); ?>
                <div class="form-group">
                    <?= Html::label('Имя', null, ['class' => 'col-xs-12 control-label', 'style' => '']); ?>
                    <div class='col-xs-12'>
                        <?= Html::input('text', 'name2', $name, ['class' => 'form-control', 'disabled' => 'disabled']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::label('Email', null, ['class' => 'col-xs-12 control-label', 'style' => '']); ?>
                    <div class='col-xs-12'>
                        <?= Html::input('email', 'email2', Yii::$app->user->identity->email, ['class' => 'form-control', 'disabled' => 'disabled']) ?>
                    </div>
                </div>

                <div style="height:0px; overflow: hidden; margin:0px; padding: 0px;">
                    <?= $form->field($mailToUser, 'name')->hiddenInput(['value' => $name])->label(false); ?>
                    <?= $form->field($mailToUser, 'email')->hiddenInput(['value' => $userProfile->getUser()->one()->email])->label(false); ?>
                    <?= $form->field($mailToUser, 'emailto')->hiddenInput(['value' => $teamProfile->getUser()->one()->email])->label(false); ?>
                    <?= $form->field($mailToUser, 'returnUrl')->hiddenInput(['value' => \yii\helpers\Url::current()])->label(false); ?>

                </div>

                <div class="div-input">
                <?= $form->field($mailToUser, 'subject') ?>
                </div>

                <div class="" style="margin-bottom: 0px;">
                    <?= $form->field($mailToUser, 'message')->textArea(['rows' => '6']); ?>
                </div>

                <div class="btn-wrap" style="padding-bottom: 0px;">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>    
                </div>
                <?php ActiveForm::end(); ?>

                <p>&nbsp;</p>
            </div>
        </div>
    </div>
</div>

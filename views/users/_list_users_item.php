<?php
/*
 * Форма создания Проектов
 * 
 * @var User $model
 * 
 * 
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Project;
use app\models\ProjectManager;
use app\models\ProjectRequest;
use app\models\user\Profile;
use yii\data\ActiveDataProvider;
use app\models\MailToUser;

$projectManager = new ProjectManager;

$teamProfile = Profile::findOne(['user_id' => $model->id]);
$projectReq = ProjectRequest::findOne(['user_id' => $model->id, 'status' => 2]);
if ($projectReq){
    $project = Project::findOne(['id' => $projectReq->project_id]);
}
else {
    $project = Project::findOne(['author_id' => $model->id]);
}
?>

<div class="media">
    <div class="media-body users-item">
        <div class="col-sm-2 col-xs-12"><b>Имя:</b></div>
        <div class="col-sm-10 col-xs-12">
            <?= Html::encode($teamProfile->name).' '.Html::encode($teamProfile->lastName)."&nbsp;"; ?>
            <span onclick="$('#users-<?= $teamProfile->user_id; ?>').modal('show'); return false;" title="Отправить сообщение" class="glyphicon glyphicon-envelope part-email" aria-hidden="true"></span>
        </div>
        <div class="col-sm-2 col-xs-12"><b>Город:</b></div>
        <div class="col-sm-10 col-xs-12"><?= Html::encode($teamProfile->city)."&nbsp;"; ?></div>
        <div class="col-sm-2 col-xs-12"><b>О себе:</b></div>
        <div class="col-sm-10 col-xs-12"><?= nl2br(Html::encode($teamProfile->bio))."&nbsp;"; ?></div>
        <?php
        $skills = '&nbsp;';
        if (count($teamProfile->getSkills()) >= 1) {
            $skills = '<ul style="padding-left: 15px;">';
            foreach ($teamProfile->getSkills() as $attribute) {
                $skills .= '<li>'.$teamProfile->getAttributeLabel($attribute).'</li>';
            }
            $skills .= '</ul>';
        }
        ?>
        <div class="col-sm-2 col-xs-12"><b>Роль:</b></div>
        <div class="col-sm-10 col-xs-12"><?= $skills; ?></div>
        <div class="col-sm-2 col-xs-12"><b>&nbsp;</b></div>
        <?php if (isset($project) && $project) { ?>
        <div class="col-sm-10 col-xs-12"><b>Участвует в команде проекта: "<?= $project->title; ?>"</b></div>
            <div>&nbsp;</div>
        <?php } ?>
    </div>
</div>

<div class="modal fade partmodal" id="users-<?= $teamProfile->user_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                            
            </div>
            <div class="modal-body">
                <?php
                $form = ActiveForm::begin([
                            'action' => '/users/mail',
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

                <?= $form->field($mailToUser, 'subject') ?>

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

<?php
/*
 * Форма создания Проектов
 * 
 * @var Project $project
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

<?php
if ($projectManager->userCanJoinProject($userProfile, $model)) {
    $buttonTitle = '';
    $disabled = false;
} else {
    $buttonTitle = $projectManager->message;
    $disabled = true;
}

// участники:
$confirmedRequestsProvider = new ActiveDataProvider([
    'query' => Profile::find()->joinWith('requests')
        ->where('`request`.project_id = '.$model->id)
        ->andWhere('`request`.status = '.ProjectRequest::STATUS_CONFIRMED)
    ,
    'pagination' => false,
    ]);
$amountParticipants = count($confirmedRequestsProvider->getModels()) + 1;
$authorProfile = Profile::findOne(['user_id' => $model->author_id]);

$isConfirmedRequest = null;
if ($projectManager->userHasRequestToProject2($userProfile, $model)) {
    $isConfirmedRequest = true;
}
?>

<div class="media">
    <div class="media-left">
        <?php $form = ActiveForm::begin(['action' => '/project/join', 'options' => ['class' => 'mini-1but-inline']]); ?>
        <?= Html::hiddenInput('projectId', $model->id); ?>
        <?php
        if ($isConfirmedRequest) {
            echo Html::submitButton('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>', ['class' => 'btn btn-default mini', 'style' => 'background: #4db849 !important; border: 1px solid #4db849 !important;', 'title' => $buttonTitle, 'disabled' => $disabled]);
        } else {
            echo Html::submitButton('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', ['class' => 'btn btn-default mini', 'title' => 'Присоедениться к проекту', 'disabled' => $disabled]);
        }
        ?>        
        <?php ActiveForm::end(); ?>        
    </div>
    <div class="media-body">
        <h4 class="media-heading"><?= Html::encode($model->title) ?></h4>
        <?= nl2br(Html::encode($model->description)) ?>
        <p>
            <a href="#" onclick="$('#participants-<?= $model->id; ?>').modal('show'); return false;" >Участники: <?= $amountParticipants; ?></a>            
        </p>
    </div>
    <p class="help-block"><?= $buttonTitle ?></p>
</div>


<div class="modal fade partmodal" id="participants-<?= $model->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                            
            </div>
            <div class="modal-body">                
                <div class="h2"><h2>Команда</h2></div>                

                <?= $this->render('/project/_list_projects_item_team', ['teamProfile' => $authorProfile, 'isAuthor' => 1]); ?>

                <?php if (count($confirmedRequestsProvider->getModels()) >= 1) { ?>
                    <?php foreach ($confirmedRequestsProvider->getModels() as $key => $item) { ?>
                        <?= $this->render('/project/_list_projects_item_team', ['teamProfile' => $item]); ?>                        
                    <?php } ?>
                <?php } ?>
                <p><i class="help-important"> * В проекте могут принять участие не более 6 человек</i></p>
            </div>
        </div>
    </div>
</div>


<!-- modal mail -->
<?= $this->render('/project/_list_projects_item_mail', ['teamProfile' => $authorProfile, 'userProfile' => $userProfile]); ?> 
<?php if (count($confirmedRequestsProvider->getModels()) >= 1) { ?>
    <?php foreach ($confirmedRequestsProvider->getModels() as $key => $item) { ?>
        <?= $this->render('/project/_list_projects_item_mail', ['teamProfile' => $item, 'userProfile' => $userProfile]); ?>        
    <?php } ?>
<?php } ?>

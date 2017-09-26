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

$projectManager = new ProjectManager;
$disabledButtons = false;
if (!$project->id) {
    $projectAction = 'create';
    $this->title = 'Создать проект';
    $projectManager = new ProjectManager;
    if (!$projectManager->userCanCreateProject(Yii::$app->user->identity->id)){
        Yii::$app->session->setFlash('danger', $projectManager->message);
        $disabledButtons = true;
    }

} else {
    $projectAction = 'edit';
    $this->title = 'Редактировать проект';
    if (!$projectManager->userCanChangeProject($project)) {
        $disabledButtons = true;
        Yii::$app->session->setFlash('success', 'Проект на модерации');
    }
}




$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/user/_alert') ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('../user/settings/_menu', []) ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?=
                $this->render('/project/_form', [
                    'project' => $project,
                    'projectAction' => $projectAction,
                    'disabledButtons' => $disabledButtons]);
                ?> 
            </div>
        </div>
    </div>    
</div>
<?php if ($confirmedRequestsProvider && count($confirmedRequestsProvider->getModels()) >= 1) { ?>
    <div class="row" style="margin-top: 0px;">
        <div class="col-md-9 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= 'Участники проекта' ?> <span style="display: block; float: right;"><i class="help-important"> *В проекте могут принять участие не более 6 человек </i></span></h3>
                </div>
                <div class="panel-body">
                    <?=
                    $this->render('/project/_confirmedRequests', [
                        'confirmedRequestsProvider' => $confirmedRequestsProvider,
                        'projectId' => $project->id,
                        'disabledButtons' => $disabledButtons]);
                    ?>                    
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if ($newRequestsProvider && count($newRequestsProvider->getModels()) >= 1) { ?>
    <div class="row" style="margin-top: 0px;">
        <div class="col-md-9 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= 'Заявки на вступление в проект' ?></h3>
                </div>
                <div class="panel-body">
                    <?=
                    $this->render('/project/_newRequests', [
                        'newRequestsProvider' => $newRequestsProvider,
                        'projectId' => $project->id,
                        'disabledButtons' => $disabledButtons]);
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>



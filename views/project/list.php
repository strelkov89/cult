<?php
/*
 * Форма создания Проектов
 * 
 * @var Project $projects
 * 
 * 
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Project;
use app\models\ProjectManager;

$this->title = 'Проекты';
$this->params['breadcrumbs'][] = $this->title;
$projectManager = new ProjectManager;

?>
<?= $this->render('/user/_alert') ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('../user/settings/_menu', []) ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php if ($projectManager->userHasOwnProject($userProfile->user->id)) { ?>
                    <h3 class="panel-title"><?= Html::encode($this->title) ?> <span class="panel-h-right"><a href="/project">Мой проект</a></span></h3>
                <?php } else { ?>
                    <h3 class="panel-title"><?= Html::encode($this->title) ?> <span class="panel-h-right"><a href="/project"><b>+</b> Создать проект</a></span></h3>                    
                <?php } ?>
            </div>
            <div class="panel-body projects-list">
                <?php if ($projectsProvider && count($projectsProvider->getModels()) >= 1) { ?>
                    <?= $this->render('/project/_list_projects', ['projectsProvider' => $projectsProvider]); ?>
                <?php } else { echo "К сожалению, нет ни одного проекта"; }?>

            </div>
        </div>
    </div>
</div>

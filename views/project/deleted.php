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
                Ваш проект удалён администратором сайта
            </div>
        </div>
    </div>    
</div>




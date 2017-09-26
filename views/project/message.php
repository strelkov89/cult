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
$this->title = 'Проекты';
    
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
                <p>Благодарим за регистрацию.</p>
                <p>Заявки на участие в хакатоне будут приниматься с 22 июня.</p>
                <p>Мы обязательно известим Вас о начале приема заявок и проектов.</p>
            </div>
        </div>
    </div>    
</div>
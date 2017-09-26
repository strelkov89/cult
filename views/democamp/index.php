<?php
/*
 * Форма создания Демокемпов
 * 
 * @var Dempcamp $democamp
 * 
 * 
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Project;
use app\models\ProjectManager;

if (!$democamp->id) {
    $democampAction = 'create';
    $this->title = 'Создать проект';
} else {
    $democampAction = 'edit';
    $this->title = 'Редактировать проект';
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
                $this->render('/democamp/_form', [
                    'democamp' => $democamp,
                    'democampAction' => $democampAction,
                ]);
                ?> 
            </div>
        </div>
    </div>    
</div>

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
?>

<div style="padding: 5px 10px; height: auto; min-height: 60px;">
    <div class="col-xs-2" style="padding-left: 0px; width: 60px;">
        <?php $form = ActiveForm::begin(['action' => '/project/request-reject', 'options' => ['class' => 'mini-1but-inline float'],]); ?>
        <?= Html::hiddenInput('userId', $model->user_id); ?>
        <?= Html::hiddenInput('projectId', $projectId); ?>
        <?=
        Html::submitButton('<span class="glyphicon glyphicon glyphicon-minus" aria-hidden="true"></span>', [
            'class' => 'btn btn-default mini',
            'title' => 'Удалить участника',
            'disabled' => $disabledButtons])
        ?>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-xs-10 plus-minus" style="padding-top: 5px; padding-left: 10px;">
        <b><?= empty($model->name) ? $model->user->username : Html::encode($model->name).' '.Html::encode(@$model->lastName); ?></b>
        <?= '('.$model->user->email.')'; ?>
        <a target="_blank" href="/user/<?= $model->user_id; ?>">Портфолио</a>
    </div>
</div>
<?php
/*
 * Форма создания Демокемпов
 * 
 * @var Project $democamp
 * 
 * 
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Project;
use app\models\ProjectManager;
use kartik\select2\Select2;
?>

<?php
$form = ActiveForm::begin([
        'id' => 'democamp-form',
        'action' => '/democamp/'.$democampAction,
        'options' => ['class' => 'form-horizontal democamp-'.$democampAction],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-lg-9\">{error}\n{hint}</div>",
            'labelOptions' => ['class' => 'col-lg-3 control-label'],
        ],
        'enableAjaxValidation' => true,
        'enableClientValidation' => false
    ]);
?>

<?php if ($democampAction == 'edit') { echo "<div class='hiddeniput'>" . $form->field($democamp, 'author_id')->hiddenInput(['value'=>$democamp->author_id])->label(false) . '</div>'; }?>

<?= $form->field($democamp, 'title') ?>
<?= $form->field($democamp, 'url') ?>
<?php
$data = \app\models\Democamp::STAGEARR;
echo $form->field($democamp, 'stage')->widget(Select2::classname(), [
    'data' => $data,
    'language' => 'ru',
    'hideSearch' => true,
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>

<?php
$data = \app\models\Democamp::DIRECTIONARR;
echo $form->field($democamp, 'direction')->widget(Select2::classname(), [
    'data' => $data,
    'language' => 'ru',
    'hideSearch' => true,
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>

<?= $form->field($democamp, 'description')->textarea(['rows' => '5']); ?>

<div class="btn-wrap">
    <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-success']) ?>     
</div>

<?php ActiveForm::end(); ?>


<?php if ($democampAction == 'edit') { ?>
    <?php
    $form = ActiveForm::begin([
            'id' => 'democamp-edit2',
            'action' => '/democamp/remove',
            'options' => ['class' => 'form-horizontal democamp-'.$democampAction],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-lg-9\">{error}\n{hint}</div>",
                'labelOptions' => ['class' => 'col-lg-3 control-label'],
            ],
            'enableAjaxValidation' => false,
            'enableClientValidation' => false
    ]);
    ?>
    <div class="btn-wrap">
        <?=
        Html::submitButton('Удалить проект', [
            'class' => 'btn btn-success',
            'onclick' => 'if (confirm("Удалить проект?")) { return true; } else { return false; }'])
        ?>
    </div>
    <?php ActiveForm::end(); ?>
<?php } ?>
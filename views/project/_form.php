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
?>

<?php
$form = ActiveForm::begin([
            'id' => 'project-form',
            'action' => '/project/'.$projectAction,
            'options' => ['class' => 'form-horizontal project-'.$projectAction],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-lg-9\">{error}\n{hint}</div>",
                'labelOptions' => ['class' => 'col-lg-3 control-label'],
            ],
            'enableAjaxValidation' => true,
            'enableClientValidation' => false
        ]);
?>

<?= $form->field($project, 'title') ?>
<?= $form->field($project, 'description')->textarea(); ?>

<div class="form-group">
    <?= Html::label('Требуются', null, ['class' => 'col-lg-3 control-label', 'style' => '']); ?>
    <div class='col-lg-9'>
        <?php
        foreach (['need_coder', 'need_designer', 'need_ux'] as $attribute) {
            echo $form->field($project, $attribute, ['template' => "<div class=\"col-lg-9\">{input}</div>"])->checkbox();
        }
        ?>
    </div>
</div>

<div class="btn-wrap">
    <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-success', 'disabled' => $disabledButtons]) ?>     
</div>

<?php ActiveForm::end(); ?>


<?php if ($projectAction == 'edit') { ?>
    <?php
    $form = ActiveForm::begin([
                'id' => 'project-edit2',
                'action' => '/project/remove',
                'options' => ['class' => 'form-horizontal project-'.$projectAction],
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
            'disabled' => $disabledButtons,
            'onclick' => 'if (confirm("Удалить проект?")) { return true; } else { return false; }'])
        ?>
    </div>
    <?php ActiveForm::end(); ?>
<?php } ?>


<?php
$this->registerJs("
(function($){    
    $('#checkboxMain input').each(function(indx, element){
        
        $(this).on('click', function(e) {
            var id = e.target.id;
            
            $('#checkboxMain input').each(function(indx, element){
                //alert(element.id);
                if (element.id != id) {
                    $(this).removeAttr('checked');
                }
            });
            
            $(this).attr('checked', 'checked');
            
            
            return  true;
            
         });   
    });
 
    return false;
})( jQuery );
", yii\web\View::POS_END, 'checkboxMain');
?>

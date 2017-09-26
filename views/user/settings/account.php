<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this  yii\web\View
 * @var $form  yii\widgets\ActiveForm
 * @var $account dektrium\user\models\SettingsForm
 */
?>


<?php
$form = ActiveForm::begin([
            'id' => 'account-form',
            'action' => '/user/settings/account',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-lg-9\">{error}\n{hint}</div>",
                'labelOptions' => ['class' => 'col-lg-3 control-label'],
            ],
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
        ]);
?>

<?= $form->field($account, 'email', ['inputOptions' => ['class' => 'form-control', 'disabled' => 'disabled']]) ?>

<?= $form->field($account, 'phone') ?>

<?= $form->field($account, 'new_password')->passwordInput() ?>

<hr/>

<?= $form->field($account, 'current_password')->passwordInput() ?>

<div class="btn-wrap">
    <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
   
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
use dektrium\user\widgets\Connect;

/**
 * @var yii\web\View                   $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module           $module
 */
?>

<div class="panel panel-default">

    <div class="panel-body ">
        <?php
        $form = ActiveForm::begin([
                'id' => 'login-form',
                'action' => Yii::$app->urlManager->createUrl('/user/security/login'),
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'validateOnBlur' => false,
                'validateOnType' => false,
                'validateOnChange' => false,
            ])
        ?>

        <div class="col-xs-12 div-input ">
            <?= $form->field($model, 'login', ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']])->textInput(['placeholder' => 'E-MAIL'])->label(false); ?>
        </div>

        <div class="col-xs-12 div-input">
            <?= $form->field($model, 'password', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])->passwordInput(['placeholder' => 'ПАРОЛЬ'])->label(false); ?>
        </div>
         
        <div class="col-xs-12 div-input disclaimer">
            <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '4']) ?>
        </div>
        
        
        <?= Html::submitButton('ВХОД', ['class' => 'btn btn-primary btn-block', 'tabindex' => '3']) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>        

<?php /*
<p class="text-center">
    <?= Html::a(Yii::t('user', 'Forgot password?'), ['/user/recovery/request'], ['tabindex' => '5']) ?>
</p>
*/ ?>
<?=
Connect::widget([
    'baseAuthUrl' => ['/user/security/auth']
])
?>

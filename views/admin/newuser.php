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
use kartik\select2\Select2;

/**
 * @var yii\web\View              $this
 * @var dektrium\user\models\User $user
 * @var dektrium\user\Module      $module
 */
?>
<?php 
$this->title = 'Добавить нового пользователя';

?>

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
                <?php
                $form = ActiveForm::begin([
                            'id' => 'registration-form2',
                            'action' => Yii::$app->urlManager->createUrl('/user/registration/newuser'),
                            'enableAjaxValidation' => true,
                            'enableClientValidation' => false
                ]);
                ?>

                <div class="col-xs-12 col-sm-6 div-input">
                    <?= $form->field($model, 'firstName')->textInput(['placeholder' => $model->getAttributeLabel('Имя')])->label(false); ?>
                </div>

                <div class="col-xs-12 col-sm-6 div-input">
                    <?= $form->field($model, 'lastName')->textInput(['placeholder' => $model->getAttributeLabel('Фамилия')])->label(false); ?>
                </div>

                <div class="col-xs-12 col-sm-6 div-input">
                    <?php
                    $data = ['1' => 'Программист', '2' => 'Дизайнер', '3' => 'Автор идеи'];
                    echo $form->field($model, 'role')->widget(Select2::classname(), [
                        'data' => $data,
                        'language' => 'ru',
                        'hideSearch' => true,
                        'options' => ['placeholder' => 'Ваша роль в проекте'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?>
                </div>
                <div class="col-xs-12 col-sm-6 div-input">
                    <?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('Email')])->label(false); ?>
                </div>
                <div class="col-xs-12 col-sm-6 div-input">
                    <?= $form->field($model, 'phone')->textInput(['placeholder' => $model->getAttributeLabel('Телефонный номер')])->label(false); ?>
                </div>
                <div class="col-xs-12 col-sm-6 div-input">
                    <?= $form->field($model, 'city')->textInput(['placeholder' => $model->getAttributeLabel('Город')])->label(false); ?>
                </div>

                <div class="col-xs-12 div-input" style="margin-bottom: 20px;">
                    <?= $form->field($model, 'about')->textArea(['rows' => '6', 'placeholder' => $model->getAttributeLabel('О себе')])->label(false)->hint('Укажите свои профессиональные навыки / дополнительные контакты'); ?>
                </div>

                <?= Html::submitButton('РЕГИСТРАЦИЯ', ['class' => 'btn btn-success btn-block']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>    
</div>

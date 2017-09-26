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
<?php if ($type == \app\models\user\User::TYPE_HACKATHON) { ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php
            $form = ActiveForm::begin([
                    'id' => 'registration-form',
                    'action' => Yii::$app->urlManager->createUrl('/user/registration/register'),
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false
            ]);
            ?>
            <div style="visibility: hidden; height: 0px; overflow: hidden;"><?= $form->field($model, 'type')->hiddenInput(['value' => $type])->label(false); ?></div>

            <div class="ftable">
                <div class="col-xs-12 col-sm-6 div-input">
                    <?= $form->field($model, 'firstName')->textInput(['placeholder' => $model->getAttributeLabel('Имя'), 'maxlength' => 100])->label(false); ?>
                </div>

                <div class="col-xs-12 col-sm-6 div-input">
                    <?= $form->field($model, 'lastName')->textInput(['placeholder' => $model->getAttributeLabel('Фамилия'), 'maxlength' => 100])->label(false); ?>
                </div>

                <div class="col-xs-12 col-sm-6 div-input">
                    <?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('Email'), 'maxlength' => 100])->label(false); ?>
                </div>
                <div class="col-xs-12 col-sm-6 div-input">
                    <?= $form->field($model, 'phone')->textInput(['placeholder' => $model->getAttributeLabel('Телефонный номер'), 'maxlength' => 100])->label(false); ?>
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
                    <?= $form->field($model, 'city')->textInput(['placeholder' => $model->getAttributeLabel('Город'), 'maxlength' => 100])->label(false); ?>
                </div>
            </div>
            <div class="col-xs-12 div-input">
                <?= $form->field($model, 'about')->textArea(['rows' => '5', 'placeholder' => $model->getAttributeLabel('О себе')])->label(false); ?>
            </div>

            <div class="col-xs-12 div-input disclaimer">
                <?= $form->field($model, 'disclaimer')->checkbox(['label' => $model->getAttributeLabel('disclaimer')]); ?>
            </div>

            <div style="clear: both;"></div>
            <?= Html::submitButton('РЕГИСТРАЦИЯ', ['class' => 'btn btn-success btn-block']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
<?php } ?>

<?php if ($type == \app\models\user\User::TYPE_DEMOCAMP) { ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php
            $form = ActiveForm::begin([
                    'id' => 'registration-form2',
                    'action' => Yii::$app->urlManager->createUrl('/user/registration/register'),
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false
            ]);
            ?>
            <div style="visibility: hidden; height: 0px; overflow: hidden;"><?= $form->field($model, 'type')->hiddenInput(['value' => $type])->label(false); ?></div>

            <div class="ftable">
                <div class="col-xs-12 col-sm-6 div-input">
                    <?= $form->field($model, 'firstName')->textInput(['placeholder' => $model->getAttributeLabel('firstName'), 'maxlength' => 100])->label(false); ?>
                </div>

                <div class="col-xs-12 col-sm-6 div-input">
                    <?= $form->field($model, 'lastName')->textInput(['placeholder' => $model->getAttributeLabel('lastName'), 'maxlength' => 100])->label(false); ?>
                </div>
                <div class="col-xs-12 col-sm-6 div-input">
                    <?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('email'), 'maxlength' => 100])->label(false); ?>
                </div>
                <div class="col-xs-12 col-sm-6 div-input">
                    <?= $form->field($model, 'phone')->textInput(['placeholder' => $model->getAttributeLabel('phone'), 'maxlength' => 100])->label(false); ?>
                </div>
                <div class="col-xs-12 col-sm-6 div-input">
                    <?= $form->field($model, 'title')->textInput(['placeholder' => $model->getAttributeLabel('title'), 'maxlength' => 100])->label(false); ?>
                </div>
                <div class="col-xs-12 col-sm-6 div-input">
                    <?= $form->field($model, 'url')->textInput(['placeholder' => $model->getAttributeLabel('url'), 'maxlength' => 100])->label(false); ?>
                </div>
                <div class="col-xs-12 col-sm-6 div-input">
                    <?php
                    $data = \app\models\Democamp::STAGEARR;
                    echo $form->field($model, 'stage')->widget(Select2::classname(), [
                        'data' => $data,
                        'language' => 'ru',
                        'hideSearch' => true,
                        'options' => ['placeholder' => 'СТАДИЯ ПРОЕКТА'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?>
                </div>
                <div class="col-xs-12 col-sm-6 div-input">
                    <?php
                    $data = \app\models\Democamp::DIRECTIONARR;
                    echo $form->field($model, 'direction')->widget(Select2::classname(), [
                        'data' => $data,
                        'language' => 'ru',
                        'hideSearch' => true,
                        'options' => ['placeholder' => 'НАПРАВЛЕНИЕ'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?>
                </div>
            </div>

            <div class="col-xs-12 div-input">
                <?= $form->field($model, 'description')->textArea(['rows' => '6', 'placeholder' => $model->getAttributeLabel('description')])->label(false); ?>
            </div>

            <div class="col-xs-12 div-input disclaimer">
                <?= $form->field($model, 'disclaimer')->checkbox(['label' => $model->getAttributeLabel('disclaimer')]); ?>
            </div>

            <div style="clear: both;"></div>
            <?= Html::submitButton('РЕГИСТРАЦИЯ', ['class' => 'btn btn-success btn-block']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

<?php } ?>

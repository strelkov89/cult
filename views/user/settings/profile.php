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
use kartik\file\FileInput;
use kartik\select2\Select2;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\Profile $profile
 */
$this->title = 'Анкета';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php
                $form = \yii\widgets\ActiveForm::begin([
                        'id' => 'profile-form',
                        'options' => ['class' => 'form-horizontal'],
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-lg-9\">{error}\n{hint}</div>",
                            'labelOptions' => ['class' => 'col-lg-3 control-label'],
                        ],
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                        'validateOnBlur' => false,
                ]);
                ?>

                <?= $form->field($model, 'name') ?>

                <?= $form->field($model, 'lastName') ?>

                <?= $form->field($model, 'city') ?>

                <?= $form->field($model, 'bio')->textarea()->hint('Укажите свои профессиональные навыки / дополнительные контакты'); ?>

                <div class="form-group">
                    <!-- developers -->
                    <?= Html::label('Роль в проекте', null, ['class' => 'col-lg-3 control-label', 'style' => '']); ?>
                    <div class='col-lg-9'>
                        <!-- is_coder, is_designer, is_ux -->
                        <?php
                        foreach (['is_coder', 'is_designer', 'is_ux'] as $attribute) {
                            echo $form->field($model, $attribute, ['template' => "<div class=\"col-lg-9\">{input}</div>"])->checkbox();
                        }
                        ?>
                    </div>
                </div>

                <!-- portfolio_links -->
                <div class="form-group form-url-load">
                    <label class="col-lg-3 control-label" for="profile-portfolio_links">Ссылки на работы</label>
                    <?= Html::activeHiddenInput($model, 'portfolio_links') ?>
                    <div class="col-lg-9">

                        <ul class="portfolio_links-list">
                            <?php foreach ($model->getPortfolioLinks() as $link) { ?>
                                <?php
                                if (empty($link)) {
                                    continue;
                                }
                                ?>
                                <li>
                                    <?= Html::a($link, $link, ['target' => '_blank']) ?>
                                    &nbsp;&nbsp;<?=
                                    Html::a('x', $link, ['target' => '_blank', 'class' => 'remove-link',
                                        'onclick' => 'hackathon.portfolio.link.remove(event, "'.$link.'"); return false;'])
                                    ?>
                                </li>
                            <?php } ?>
                        </ul>

                        <div>
                            <div style="padding: 0px;" class="col-xs-10"><input name="link" type="text" class="form-control" placeholder="URL"></div>
                            <div style="padding: 0px;" class="col-xs-2">
                                <button type="button" class="btn btn-default mini" onclick="hackathon.portfolio.link.add()" title="Добавить ссылку">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </button>
                            </div>
                            <div class="clearfix"></div>
                            <p class="help-block">http://сайт</p>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <hr>

                <div class="btn-wrap">                    
                    <?= \yii\helpers\Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-success']) ?><br>
                </div>

                <?php \yii\widgets\ActiveForm::end(); ?>                
            </div>
        </div>
    </div>
</div>



<div class="row" style="margin-top: 0px;">
    <div class="col-md-9 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= 'Настройки аккаунта' ?> <span id="show-account" class="plus-open glyphicon glyphicon-plus" aria-hidden="true"></span></h3>
            </div>
            <div class="panel-body show-account" style="display: none;">
                <?=
                $this->render('account', [
                    'account' => $account
                ]);
                ?>        
            </div>
        </div>
    </div>
</div>


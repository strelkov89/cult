<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

$model = new \app\models\ContactForm();
?>

<a class="menuancor" name="contacts"></a>
<section id="contactsSec">
    <div id="map"></div>
    <div class="bg bgdark">
        <div class="container">
            <div class="up">
                <button id="contactBut">КОНТАКТЫ</button>
                <div class="logo"><a href="http://www.bokovfactory.ru/" target="_blank"><img src="/img/_index/contacts/bokov.png" alt="BokovFactory" title="BokovFactory" /></a></div>
                <div class="logo"><img src="/img/_index/contacts/start.png" alt="StartFactory" title="StartFactory" /></div>
                <div class="logo"><a href="http://apps4all.ru/" target="_blank"><img src="/img/_index/contacts/apps4all.png" alt="Apps4All" title="Apps4All" /></a></div>
            </div>

            <div id="form">
                <div class="col-sm-6 col-xs-12">
                    <img src="/img/logo/logo.png" width="159">
                    <button id="contactButMap">На карте</button>
                    <p>
                        ИНСТИТУТ «СТРЕЛКА»<br />
                        Берсеневская набережная, 14, стр. 5а                        
                    </p>
                    <div class="block-contact">
                        <p class="p-contact">
                            <span>+7 903 542 15 29</span><br/>
                            info@apps4all.ru
                        </p>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <?php
                    $form = ActiveForm::begin([
                            'action' => Url::toRoute(['/']),
                    ]);
                    ?>

                    <div><?= $form->field($model, 'email')->textInput(['placeholder' => 'email'])->label(false); ?></div>
                    <div><?= $form->field($model, 'message')->textArea(['placeholder' => 'Введите сообщение', 'rows' => '7'])->label(false); ?></div>
                    <div>
                        <?=
                        $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                            'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                        ])->label(false);
                        ?>
                    </div>

                    <div><button type="submit" id="contactButMes">ОТПРАВИТЬ СООБЩЕНИЕ</button></div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>
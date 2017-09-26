<?php
/*
 * Modal window
 */
?>

<!-- Login -->
<?php $loginModel = \Yii::createObject(dektrium\user\models\LoginForm::className()); ?>
<div class="modal fade " id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog authmodal">
        <div class="modal-content">
            <div class="modal-header" style="height: 30px;">
                ВХОД
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                            
            </div>
            <div class="modal-body">
                <?= $this->render('@app/views/user/security/login', ['model' => $loginModel]) ?>
            </div>
        </div>
    </div>
</div>
<!-- Registration -->
<?php $regModel = \Yii::createObject(app\models\user\RegistrationForm::className()); ?>
<div class="modal fade " id="reg-modal0" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="chooseReg">
            <div onclick="$('#reg-modal').modal('show');"><img src="/img/_index/registration/item1.png" /><span>ЗАРЕГИСТРИРОВАТЬСЯ<br/> НА ХАКАТОН</span></div>
            <div onclick="$('#reg-modal2').modal('show');"><img src="/img/_index/registration/item2.png" /><span>ЗАРЕГИСТРИРОВАТЬСЯ<br/> НА ДЕМОКЕМП</span></div>
        </div>

    </div>
</div>
<div class="modal fade " id="reg-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog authmodal">
        <div class="modal-content">
            <div class="modal-header">
                РЕГИСТРАЦИЯ НА ХАКАТОН
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                            
            </div>
            <div class="modal-body">
                <?= $this->render('@app/views/user/registration/register', ['model' => $regModel, 'type' => \app\models\user\User::TYPE_HACKATHON]) ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="reg-modal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog authmodal">
        <div class="modal-content">
            <div class="modal-header">
                РЕГИСТРАЦИЯ НА ДЕМОКЕМП
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                            
            </div>
            <div class="modal-body">
                <?= $this->render('@app/views/user/registration/register', ['model' => $regModel, 'type' => \app\models\user\User::TYPE_DEMOCAMP]) ?>
            </div>
        </div>
    </div>
</div>
<!-- System message -->
<?php if (Yii::$app->session->getFlash('sMessage')) { ?>
    <!-- Modal -->
    <div class="modal in" id="sMessage" style="margin-top:50px;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                            
                </div>
                <div class="modal-body">
                    <p style="padding: 15px 30px; color: #fff;">
                        <?php
                        if (is_array(Yii::$app->session->getFlash('sMessage'))) {
                            echo @Yii::$app->session->getFlash('sMessage')[0];
                        } else {
                            echo @Yii::$app->session->getFlash('sMessage');
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Brief Modals -->
<div class="modal fade briefs-modal-auto" id="nom-platinental" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="brief-dialog-auto">
        <div class="modal-content-brief-auto">
            <div class="modal-header-auto">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                            
            </div>            
            <div class="modal-body-auto">
                <?= $this->render('@app/views/briefs/_nom-platinental') ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade briefs-modal-auto" id="nom-vector" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="brief-dialog-auto">
        <div class="modal-content-brief-auto">             
            <div class="modal-header-auto">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                            
            </div>
            <div class="modal-body-auto">
                <?= $this->render('@app/views/briefs/_nom-vector') ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade briefs-modal-auto" id="nom-ginza" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="brief-dialog-auto">
        <div class="modal-content-brief-auto">             
            <div class="modal-header-auto">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                            
            </div>
            <div class="modal-body-auto">
                <?= $this->render('@app/views/briefs/_nom-ginza') ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade briefs-modal-auto" id="nom-oneapi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="brief-dialog-auto">
        <div class="modal-content-brief-auto">             
            <div class="modal-header-auto">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                            
            </div>
            <div class="modal-body-auto">
                <?= $this->render('@app/views/briefs/_nom-oneapi') ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade briefs-modal-auto" id="nom-patriki" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="brief-dialog-auto">
        <div class="modal-content-brief-auto">             
            <div class="modal-header-auto">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                            
            </div>
            <div class="modal-body-auto">
                <?= $this->render('@app/views/briefs/_nom-patriki') ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade briefs-modal-auto" id="nom-mapsme" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="brief-dialog-auto">
        <div class="modal-content-brief-auto">             
            <div class="modal-header-auto">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                            
            </div>
            <div class="modal-body-auto">
                <?= $this->render('@app/views/briefs/_nom-mapsme') ?>
            </div>
        </div>
    </div>
</div>

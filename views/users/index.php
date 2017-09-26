<?php

/**
 * Форма регистрации
 * 
 * @var \yii\data\ActiveDataProvider $registrationsProvider
 * @var int $confirmedCount
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use app\models\user\Profile;
use yii\grid\GridView;
use app\models\Registration;
use yii\helpers\Url;
use app\assets\AdminAsset;

$this->title = 'Участники';
$this->params['breadcrumbs'][] = $this->title;
?>


<?= $this->render('/user/_alert') ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('../user/settings/_menu', []) ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php 
                    $role = \Yii::$app->request->get('role');
                    $selected = 'selected="selected"';
                ?>
                <select id="roleType" class="select" name="type" style="float:right; font-size: 14px;">
                    <option value="/users">Все</option>
                    <option <?php if($role == 1){ echo $selected; } ?> value="/users?role=1">Программист</option>
                    <option <?php if($role == 2){ echo $selected; } ?> value="/users?role=2">Дизайнер</option>
                    <option <?php if($role == 3){ echo $selected; } ?> value="/users?role=3">Автор идеи</option>
                </select>
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body projects-list">

                <?php if ($userProvider && count($userProvider->getModels()) >= 1) { ?>
                    <?= $this->render('/users/_list_users', ['userProvider' => $userProvider]); ?>
                    <?php
                } else {
                    echo "К сожалению, нет ни одного пользователя";
                }
                ?>

            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs("
(function($){    
    $('#roleType').on('change', function(e) {        
    
        window.location.href = $(this).val();
        
        return false;
    });  
    
    return false;
})( jQuery );
", yii\web\View::POS_END, 'roleType');
?>
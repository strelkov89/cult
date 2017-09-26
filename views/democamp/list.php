<?php
/*
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Democamp;

$this->title = 'Демокемпы';
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
                <?php if (Democamp::userHasOwnDemocamp($userProfile->user->id)) { ?>
                <h3 class="panel-title"><?= Html::encode($this->title) ?> <span class="panel-h-right"><a href="/democamp"><b>Мой демокемп</b></a></span></h3>
                <?php } else { ?>
                <div class="panel-title"><?= Html::encode($this->title) ?> <span class="panel-h-right"><a href="/democamp"><b>+ Создать демокемп</b></a></span></div>                    
                <?php } ?>
            </div>
            <div class="panel-body projects-list">
                <?php if ($democampProvider && count($democampProvider->getModels()) >= 1) { ?>
                    <?= $this->render('/democamp/_list_democamp', ['democampProvider' => $democampProvider, 'userProfile' => $userProfile]); ?>
                <?php } else { echo "К сожалению, нет ни одного демокемпа"; }?>

            </div>
        </div>
    </div>
</div>

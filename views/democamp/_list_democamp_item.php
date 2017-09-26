<?php
/*
 * 
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\user\Profile;
use app\models\Democamp;
use yii\data\ActiveDataProvider;
?>

<div class="media">
    <div class="media-left">
        &nbsp;       
    </div>
    <div class="media-body">
        <h4 class="media-heading"><?= Html::encode($model->title) ?></h4>
        <div style="float:left; margin-right: 10px;" ><b>Направление:</b></div>
        <div style="float:left;"><?= Democamp::getDirection($model->direction); ?></div>
        <div style="clear: both;"></div>
        <div style="float:left; margin-right: 10px;" ><b>Стадия проекта:</b></div>
        <div style="float:left;"><?= Democamp::getStage($model->stage); ?></div>

        <div style="clear: both;"></div>
        <div style="" ><b>Краткое резюме:</b></div>
        <p style="clear: both;"><?= nl2br(Html::encode($model->description)) ?></p>
    </div>
    <p class="help-block"></p>
</div>

<?php
/*
 * Форма создания Проектов
 * 
 * @var Profile $teamProfile
 * 
 * 
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Project;
use app\models\ProjectManager;
use app\models\user\Profile;
use app\models\ProjectRequest;
use yii\data\ActiveDataProvider;
use app\models\MailToUser;

$projectManager = new ProjectManager;
?>

<div class="participants-popup">
    <?php if (isset($isAuthor)) { ?>
        <div class="col-xs-12"><b>Автор проекта</b></div>
    <?php } ?>
    <div class="col-sm-2 col-xs-12"><b>Имя:</b></div>
    <div class="col-sm-10 col-xs-12">
        <?= Html::encode($teamProfile->name).' '.Html::encode($teamProfile->lastName)."&nbsp;"; ?>
        <span href="#" onclick="$('#participant-<?= $teamProfile->user_id; ?>').modal('show'); return false;" title="Отправить сообщение" class="glyphicon glyphicon-envelope part-email" aria-hidden="true"></span>
    </div>
    <div class="col-sm-2 col-xs-12"><b>Город:</b></div>
    <div class="col-sm-10 col-xs-12"><?= Html::encode($teamProfile->city)."&nbsp;"; ?></div>
    <div class="col-sm-2 col-xs-12"><b>О себе:</b></div>
    <div class="col-sm-10 col-xs-12"><?= nl2br(Html::encode($teamProfile->bio))."&nbsp;"; ?></div>
    <?php
    $skills = '&nbsp;';
    if (count($teamProfile->getSkills()) >= 1) {
        $skills = '<ul style="padding-left: 15px;">';
        foreach ($teamProfile->getSkills() as $attribute) {
            $skills .= '<li>'.$teamProfile->getAttributeLabel($attribute).'</li>';
        }
        $skills .= '</ul>';
    }
    ?>
    <div class="col-sm-2 col-xs-12"><b>Роль:</b></div>
    <div class="col-sm-10 col-xs-12"><?= $skills; ?></div>
</div>

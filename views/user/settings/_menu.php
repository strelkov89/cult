<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\widgets\Menu;
use app\models\user\Profile;

/** @var dektrium\user\models\User $user */
$user = Yii::$app->user->identity;
$profile = Profile::findOne(['user_id' => $user->id]);
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
        <?= $user->username; ?>
    </div>
    <div class="panel-body">
        <?=
        Menu::widget([
            'options' => [
                'class' => 'nav nav-pills nav-stacked'
            ],
            'items' => [
                ['label' => 'Профиль', 'url' => ['/user/settings/profile']],
                //['label' => Yii::t('user', 'Account'), 'url' => ['/user/settings/account']],
                //['label' => 'Проекты', 'url' => ['/project/message']],
                //['label' => Yii::t('user', 'Networks'), 'url' => ['/user/settings/networks'], 'visible' => $networksVisible],
                //['label' => $projectLabel, 'url' => '/project', 'visible' => $projectIndex, 'active' => (Yii::$app->controller->id == 'project' && Yii::$app->controller->action->id == 'index')],
                ['label' => 'Проекты', 'url' => '/project/list', 'visible' => $user->is_hackathon() == 1, 'active' => (Yii::$app->controller->id == 'project' )],
                ['label' => 'Участники', 'url' => '/users', 'visible' => $user->is_hackathon() == 1, 'active' => (Yii::$app->controller->id == 'users' && Yii::$app->controller->action->id == 'index')],
                // DEMOCAMP
                ['label' => 'Демокемпы', 'url' => '/democamp/list', 'visible' => $user->is_democamp() == 1, 'active' => (Yii::$app->controller->id == 'democamp')],
                // ADMIN
                ['label' => 'Админка пользователей', 'url' => ['/admin/index'], 'visible' => $user->is_myadmin() == 1],
                ['label' => 'Админка проектов', 'url' => ['/admin/projects'], 'visible' => $user->is_myadmin() == 1],
                ['label' => 'Админка демокемпов', 'url' => ['/admin/democamps'], 'visible' => $user->is_myadmin() == 1],
                //['label' => 'Добавить пользователя', 'url' => ['/user/registration/newuser'], 'visible' => $user->is_myadmin() == 1],
            ]
        ])
        ?>
    </div>
</div>
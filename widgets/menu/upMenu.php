<?php

/**
 * upMenu widget
 *
 */

namespace app\widgets\menu;

use Yii;

class upMenu extends \yii\base\Widget
{
    public $items = [];

    public function run()
    {
        $this->items = [
            [
                'label' => 'РАСПИСАНИЕ',
                'url' => ['/#shedule'],
            ],
            [
                'label' => 'ЭКСПЕРТЫ',
                'url' => ['/#experts'],
            ],
            [
                'label' => 'ХАКАТОН И ДЕМОКЕМП',
                'url' => ['/#hackathon'],
            ],
            [
                'label' => 'ПАРТНЕРЫ',
                'url' => ['/#partners'],
            ],
            [
                'label' => 'КОНТАКТЫ',
                'url' => ['/#contacts'],
            ],
            [
                'label' => 'ВОЙТИ',
                'url' => ['#'],
                'linkOptions' => ['onclick' => '$("#login-modal").modal("show"); return false;', 'class' => 'auth'],
                'visible' => Yii::$app->user->isGuest
            ],
            [
                'label' => 'РЕГИСТРАЦИЯ',
                'url' => ['/#'],
                'linkOptions' => ['onclick' => '$("#reg-modal0").modal("show"); return false;', 'class' => 'auth'],
                'visible' => Yii::$app->user->isGuest
            ],
            // User authorized
            [
                'label' => 'КАБИНЕТ',
                'url' => [Yii::$app->urlManager->createUrl('/user/settings/profile')],
                'linkOptions' => ['class' => 'auth'],
                'visible' => !Yii::$app->user->isGuest
            ],
            [
                'label' => 'ВЫЙТИ',
                'url' => [Yii::$app->urlManager->createUrl('/user/security/logout')],
                'linkOptions' => ['class' => 'auth'],
                'visible' => !Yii::$app->user->isGuest
            ],
        ];

        return $this->render('upMenu', ['items' => $this->items]);
    }

}
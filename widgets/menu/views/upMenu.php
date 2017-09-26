<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

NavBar::begin([
    'brandLabel' => '<img src="/img/logo/logo.png" width="159" />',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-fixed-top',
    ],
]);

echo Nav::widget([
    'items' => $items,
    'options' => ['class' => 'nav navbar-nav navbar-right'],
]);

NavBar::end();
?>
<div class="navbarFixMargin"></div>
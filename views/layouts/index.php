<?php

use yii\helpers\Html;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>

        <!-- favicons -->
        <link rel="shortcut icon" href="/img/favicons/favicon.ico"/>
        <link rel="apple-touch-icon-precomposed" href="/img/favicons/favicon.ico"/>
        <meta name="msapplication-TileColor" content="#FFFFFF">
        <meta name="msapplication-TileImage" content="/img/favicons/favicon.ico">

        <meta name="viewport" content="width=device-width, initial-scale=0.85; maximum-scale=0.85; user-scalable=0;">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <meta name="description" content="Культурный код">
        <meta property="og:image" name="" content="<?= Yii::$app->urlManager->createAbsoluteUrl('/img/logo/logosoc.png');?>" />
        <?php $this->head() ?>
    </head>
    <body class="<?= ($this->context->id === 'site' && $this->context->action->id == 'index') ? '' : 'inner-page' ?>">

        <?php $this->beginBody() ?>
        <?= app\widgets\modalWindow\modalWindow::widget(['layout' => $this->context->layout]); ?>

        <div class="wrap qwerty2" id="top">
            <header class="navbar">
                <?= app\widgets\menu\upMenu::widget(); ?>
            </header>

            <div class="main-content">
                <?= $content ?>
            </div>
        </div>

        <script src='https://maps.googleapis.com/maps/api/js'></script>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
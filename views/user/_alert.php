<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var $module dektrium\user\Module
 */
?>
<section class="message">
    <div class="row message">
        <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
            <?php if (in_array($type, ['success', 'danger', 'warning', 'info'])): ?>
                <div class="alert alert-<?= $type ?>">
                    <?php
                    if (is_string($message)) {
                        echo $message;
                    } else if (isset($message[0])) {
                        echo $message[0];
                    } else {
                        echo "Ошибка при регистрации, обратитесь в службу поддержки";
                    }
                    ?>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    </div>
</section>
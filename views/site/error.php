<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>



<?php
/*
  <h1><?= Html::encode($this->title) ?></h1>

  <div class="alert alert-danger">
  <?= nl2br(Html::encode($message)) ?>
  </div>

  <p>
  The above error occurred while the Web server was processing your request.
  </p>
  <p>
  Please contact us if you think this is a server error. Thank you.
  </p>
 * 
 */
// There are 3 variables in error view: $name, $message, $exception
// 404 is $exception->statusCode.
?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-3">

            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Ошибка <?= $exception->statusCode ?>
                    </div>
                    <div class="panel-body">
                        <?php if ($exception->statusCode == 404) { ?>
                            Страница не найдена
                        <?php } else { ?>
                            <?= nl2br(Html::encode($message)) ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
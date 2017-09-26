<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii2masonry\yii2masonry;
use app\models\user\User;

/**
 * @var \yii\web\View $this
 * @var app\models\user\Profile $profile
 */
$this->title = empty($profile->name) ? Html::encode($profile->user->username) : Html::encode($profile->name);
$this->params['breadcrumbs'][] = $this->title;
$user = User::findOne(['id' => $profile->user_id]);

$images = $profile->getPortfolioImages();
$links = $profile->getPortfolioLinks();
$skills = $profile->getSkills();
?>
<div class="row">
    <div class="col-md-3">

    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= $profile->name.' '.$profile->lastName ?>
            </div>
            <div class="panel-body">

                <ul style="padding: 0; list-style: none outside none;" class="show-user">
                    <li><i class="glyphicon glyphicon-time text-muted"></i> <?= Yii::t('user', 'Joined on {0, date}', $profile->user->created_at) ?></li>
                    <li><i class="glyphicon glyphicon-envelope text-muted"></i> <?= Html::a(Html::encode($user->email), 'mailto:'.Html::encode($user->email)) ?></li>
                    <?php if (!empty($profile->city)): ?>
                        <li><i class="glyphicon glyphicon-map-marker text-muted"></i> <?= Html::encode($profile->city) ?></li>
                    <?php endif; ?>
                </ul>
                
                <!-- skills -->
                <?php if (count($skills)) { ?>
                    <h4>Навыки</h4>
                    <ul>
                        <?php
                        foreach ($skills as $attribute) {
                            echo '<li>'.$profile->getAttributeLabel($attribute).'</li>';
                        }
                        ?>
                    </ul>
                <?php } else { ?>
                    <h4>Навыки не указаны</h4>
                <?php } ?>                    
                
                <?php if (!empty($profile->bio)): ?>
                    <h4>О себе:</h4>
                    <p><?= Html::encode($profile->bio) ?></p>
                <?php endif; ?>

                

                <!-- portfolio images -->
                <?php if (count($images)) { ?>
                    <h4>Портфолио: изображения</h4>

                    <?php
                    // masonry
                    yii2masonry::begin([
                        'clientOptions' => [
                            'columnWidth' => 50,
                            'itemSelector' => 'thumbnail'
                        ]
                    ]);
                    foreach ($images as $image) {
                        ?>
                        <a style="width: 250px; margin-right: 20px;" href="#" class="thumbnail">
                            <img src="<?= Html::encode($image) ?>" alt="Работа пользователя <?= Html::encode($profile->name) ?>">
                        </a>
                        <?php
                    }

                    yii2masonry::end();
                }
                ?>

                <!-- portfolio links -->
                <?php if (count($links)) { ?>
                    <h4>Портфолио: ссылки</h4>
                    <ul>
                        <?php
                        foreach ($links as $link) {
                            if (empty($link))
                                continue;
                            echo '<li>'.Html::a(Html::encode($link), Html::encode($link), ['target' => '_blank']).'</li>';
                        }
                        ?>
                    </ul>
                <?php } ?>

                <!-- empty portfolio -->
                <?php /* if (count($links) === 0 && count($images) === 0) { ?>
                  <h4>Портфолио не заполнено</h4>
                  <?php } */ ?>

            </div>
        </div>
    </div>
</div>
<?php

/**
 * Форма регистрации
 * 
 * @var \yii\data\ActiveDataProvider $registrationsProvider
 * @var int $confirmedCount
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use app\models\user\Profile;
use yii\grid\GridView;
use app\models\Registration;
use yii\helpers\Url;
use app\assets\AdminAsset;

$this->title = 'Админка пользователей';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="row offline" style="display:none;">
    <div class="col-md-12">
        <div class="panel-default alert alert-danger">
            <div class="panel-body">Отсутствует подключение к интернету!</div>
        </div>
    </div>            
</div>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('../user/settings/_menu', []) ?>
    </div>

</div>


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?>&nbsp;<small>всего: <?= $userProvider->getTotalCount() ?>, с билетом: <?= $confirmedCount ?>, пришедшие: <?= $visitedCount; ?></small></h3>
            </div>
            <div class="panel-body" id="regUsers" style="overflow: auto;">
                <?php if (Yii::$app->session->hasFlash('success')) { ?>
                    <div class="alert alert-success">Билет успешно отправлен</div>
                <?php } elseif (Yii::$app->session->hasFlash('error')) { ?>
                    <div class="alert alert-danger">Ошибка при формировании билета. Обратитесь куда-нибудь...</div>
                <?php } ?>

                <?php
                echo GridView::widget([
                    'dataProvider' => $userProvider,
                    'filterModel' => $searchModel,
                    'options' => [
                        'class' => 'admin-index'
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'email',
                            'value' => function ($data) {
                                return $data['email'];
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'phone',
                            'value' => function ($data) {
                                return $data['phone'];
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'firstName',
                            'value' => function ($data) {
                                return $data['firstName'];
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'lastName',
                            'value' => function ($data) {
                                return $data['lastName'];
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'Город',
                            'value' => function ($data) {
                                $userProfile = Profile::findOne(['user_id' => $data['id']]);
                                return $userProfile->city;
                            },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'О себе',
                                'value' => function ($data) {
                                    $userProfile = Profile::findOne(['user_id' => $data['id']]);
                                    return $userProfile->bio;
                                },
                                    'format' => 'raw',
                                ],
                                [
                                    'attribute' => 'type',
                                    'label' => 'Тип',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        if ($data['type'] == 1) {
                                            return 'хакатон';
                                        } elseif ($data['type'] == 2) {
                                            return 'демокемп';
                                        } else {
                                            return '-';
                                        }
                                    },
                                ],
                                [
                                    'attribute' => 'visited',
                                    'filter' => false,
                                    'label' => 'Посетил(а)',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        if ($data['is_visited']) {
                                            return '<img src="/img/ajax-loader.gif" width="30" height="30" style="display:none;" />'.Html::a('<span class="glyphicon glyphicon-ok visited-yes" aria-hidden="true"></span>', ['admin/visited'], ['id' => $data['id'], 'class' => 'visited_link']);
                                        } else {
                                            return '<img src="/img/ajax-loader.gif" width="30" height="30" style="display:none;" />'.Html::a('<span class="glyphicon glyphicon-ok visited-no" aria-hidden="true"></span>', ['admin/visited'], ['id' => $data['id'], 'class' => 'visited_link']);
                                        }
                                    },
                                    ],
                                    [
                                        'attribute' => 'удалить',
                                        'filter' => false,
                                        'label' => 'удалить',
                                        'format' => 'raw',
                                        'value' => function ($data) {

                                            return '<img src="/img/ajax-loader.gif" width="30" height="30" style="display:none;" />'.Html::a('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>', ['admin/remove'], ['id' => $data['id'], 'class' => 'remove']);
                                        },
                                        ],
                                    ],
                                ]);
                                ?>
                            </div>            
                        </div>        
                    </div>    
                </div>

                <?php
                $this->registerJs("
(function($){    
    $('#regUsers .remove').on('click', function(e) {
        var a = $(e.currentTarget);
        var td = a.parent();
        var url = a.attr('href');
        var id = a.attr('id');
        var span = a.find('span');
        var img = td.find('img');
        
        img.show();
        a.hide();

        $.ajax({
            url: url,
            type: 'post',
            data: {id: id},
            success: function(data) {
                img.hide();
                a.show();
                if (data){
                    a.hide();                    
                } else{ 
                    alert('Error deleted('+id+')'); 
                }
            }
        });
        
        return false;
    });  
    
    $('#regUsers .visited_link').on('click', function(e) {
        var a = $(e.currentTarget);
        var td = a.parent();
        var url = a.attr('href');
        var id = a.attr('id');
        var span = a.find('span');
        var img = td.find('img');
        
        img.show();
        a.hide();

        $.ajax({
            url: url,
            type: 'post',
            data: {id: id},
            success: function(data) {
                img.hide();
                a.show();
                if (data){
                    if (span.hasClass('visited-no'))
                        span.toggleClass('visited-no visited-yes');
                    else
                        span.toggleClass('visited-yes visited-no');
                } else{ 
                    alert('Error visited('+id+')'); 
                }
            }
        });
        
        return false;
    }); 
    
    $('#regUsers .moderate_link').on('click', function(e) {
        if (!confirm('Отправить билет?')) { return false; }
        var a = $(e.currentTarget);
        var td = a.parent();
        var url = a.attr('href');
        var id = a.attr('id');
        
        var img = \"<img src='/img/ajax-loader.gif' width='30' height='30' />\";
        var tmpData = td.html();
        td.html(img);

        $.ajax({
            url: url,
            type: 'post',
            data: {id: id},
            success: function(data) {
                if (data){
                    td.html(data);
                } else{ 
                    td.html(tmpData);
                    alert('Error moderate('+id+')'); 
                }
            }
        });
        
        return false;
    });     
    
    return false;
})( jQuery );
", yii\web\View::POS_END, 'regUsers');
                ?>

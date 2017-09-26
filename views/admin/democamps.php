<?php

/**
 * Форма регистрации
 * 
 * @var \yii\data\ActiveDataProvider $registrationsProvider
 * @var int $confirmedCount
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\user\User;
use app\models\user\Profile;
use yii\grid\GridView;
use app\models\Registration;
use yii\helpers\Url;
use app\assets\AdminAsset;
use app\models\ProjectRequest;

$this->title = 'Админка демокемпов';
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
                <h3 class="panel-title"><?= Html::encode($this->title) ?>&nbsp;<small>всего: <?= $democampProvider->getTotalCount() ?></small></h3>
            </div>
            <div class="panel-body" id="regUsers" style="overflow: auto;">
                <?php if (Yii::$app->session->hasFlash('success')) { ?>
                    <div class="alert alert-success">Билет успешно отправлен</div>
                <?php } elseif (Yii::$app->session->hasFlash('error')) { ?>
                    <div class="alert alert-danger">Ошибка при формировании билета. Обратитесь куда-нибудь...</div>
                <?php } ?>

                <?php
                echo GridView::widget([
                    'dataProvider' => $democampProvider,
                    'options' => [
                        'class' => 'admin-index'
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'title',
                            'value' => function ($data) {
                                return $data['title'];
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'description',
                            'value' => function ($data) {
                                return $data['description'];
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'direction',
                            'value' => function ($data) {
                                $arr = \app\models\Democamp::DIRECTIONARR;
                                return $arr[$data['direction']];
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'stage',
                            'value' => function ($data) {
                                $arr = \app\models\Democamp::STAGEARR;
                                return $arr[$data['stage']];
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'Автор',
                            'value' => function ($data) {
                                $user = User::findOne(['id' => $data['author_id']]);
                                return $user->email;
                            },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'удалить',
                                'filter' => false,
                                'label' => 'удалить',
                                'format' => 'raw',
                                'value' => function ($data) {

                                    return '<img src="/img/ajax-loader.gif" width="30" height="30" style="display:none;" />'.Html::a('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>', ['admin/removedemocamp'], ['id' => $data['id'], 'class' => 'remove']);
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
        if (!confirm('Удалить демокемп?')) { return false; }
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
    
    return false;
})( jQuery );
", yii\web\View::POS_END, 'regUsers');
        ?>

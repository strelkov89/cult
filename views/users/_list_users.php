<?php

/*
 * Форма создания Проектов
 * 
 * @var Project $project
 * 
 * 
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Project;
use app\models\user\Profile;

$userProfile = Profile::findOne(['user_id' => Yii::$app->user->identity->id]);
?>

<?php

echo yii\widgets\ListView::widget([
    'dataProvider' => $userProvider,
    'itemView' => '_list_users_item',
    'viewParams' => ['userProfile' => $userProfile],
]);
?>
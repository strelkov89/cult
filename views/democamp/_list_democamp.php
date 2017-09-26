<?php

/*
 *
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\user\Profile;
?>

<?php

echo yii\widgets\ListView::widget([
    'dataProvider' => $democampProvider,
    'itemView' => '_list_democamp_item',
    'viewParams' => ['userProfile' => $userProfile],
]);
?>
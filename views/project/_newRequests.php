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
?>

<?php

echo yii\widgets\ListView::widget([
    'dataProvider' => $newRequestsProvider,
    'itemView' => '_newRequests_item',
    'viewParams' => ['projectId' => $projectId, 'disabledButtons' => $disabledButtons],
]);
?>
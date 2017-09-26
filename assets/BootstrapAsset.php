<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\bootstrap\BootstrapAsset as OriginalBootstrapAsset;

class BootstrapAsset extends OriginalBootstrapAsset
{
    public $js = [
        'js/bootstrap.min.js',
    ];

}
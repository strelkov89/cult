<?php

/**
 * Modal window widget
 *
 */

namespace app\widgets\modalWindow;

class modalWindow extends \yii\base\Widget
{
    public $layout;
    public $view = 'index';

    public function run()
    {
        switch ($this->layout) {
            case 'index':
                $this->view = 'index';
                break;
            case 'main':
                $this->view = 'main';
                break;
        }

        return $this->render($this->view);
    }

}
<?php
namespace app\modules\admin\widgets;

use yii\base\Widget;

class HeaderWidget extends Widget
{
    public function run()
    {
        return $this->render('header');
    }
}

<?php

namespace app\modules\admin\widgets;

use yii\base\Widget;

class SidebarWidget extends Widget
{
    public function run()
    {
        return $this->render('_sidebar');
    }
}

<?php

use app\modules\admin\service\ContentService;
use yii\helpers\Url;

$controller = Yii::$app->controller->uniqueid;

?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Kun.uz cms</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column">
                <li class="nav-item menu-open">
                    <a href="<?= Url::to(['default/']) ?>"
                       class="nav-link <?= $controller == 'cabinet/default' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Content
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php foreach (ContentService::contentTypes() as $type): ?>
                            <li class="nav-item">
                                <a href="<?= Url::to(['content/', 'type' => $type]) ?>"
                                   class="nav-link <?= (Yii::$app->controller->id == 'content' && Yii::$app->controller->action->id == 'index' && Yii::$app->request->get('type') == $type) ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p><?= ucfirst($type) ?></p>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>

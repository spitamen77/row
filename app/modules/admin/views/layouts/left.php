<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
<!--                <img src="--><?//= $directoryAsset ?><!--/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>-->

                <img src="/web/<?=Yii::$app->user->identity->image?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <a href="<?=Yii::$app->UrlManager->createUrl('/admin/.')?>"
                <p>Admin panel</p>
                </a>
                <a href="<?=Yii::$app->UrlManager->createUrl('/admin/.')?>"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <a href="<?=Yii::$app->UrlManager->createUrl('/admin/user/user')?>">
        <p style="color: white" align="center"><?=Yii::$app->user->identity->fio?></p>
        </a>
        <!-- search form -->
        <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form> -->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Menu', 'icon' => 'file-code-o', 'url' => ['/admin/menu/index']],
                    ['label' => 'Maqolalar', 'icon' => 'file-code-o', 'url' => ['/admin/menu-item/index']],
                    ['label' => 'Tarjimalar', 'icon' => 'file-code-o', 'url' => ['/admin/text-translate/index']],
                    ['label' => 'Rasm', 'icon' => 'file-code-o', 'url' => ['/admin/photo/index']],
                    ['label' => 'Teacher', 'icon' => 'dashboard', 'url' => ['/admin/teacher/index']],
                    ['label' => 'Contact', 'icon' => 'dashboard', 'url' => ['/admin/contact/index']],
                    ['label' => 'Zayavkalar', 'icon' => 'dashboard', 'url' => ['/admin/zayavka/index']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    // [
                    //     'label' => 'Some tools',
                    //     'icon' => 'share',
                    //     'url' => '#',
                    //     'items' => [
                    //         ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                    //         ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                    //         [
                    //             'label' => 'Level One',
                    //             'icon' => 'circle-o',
                    //             'url' => '#',
                    //             'items' => [
                    //                 ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                    //                 [
                    //                     'label' => 'Level Two',
                    //                     'icon' => 'circle-o',
                    //                     'url' => '#',
                    //                     'items' => [
                    //                         ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                    //                         ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                    //                     ],
                    //                 ],
                    //             ],
                    //         ],
                    //     ],
                    // ],
                ],
            ]
        ) ?>

    </section>

</aside>

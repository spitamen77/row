<?php
use yii\helpers\Html;
use app\models\Lang;
use app\models\dilshod\Zayavka;
use app\models\ContactForm;
/* @var $this \yii\web\View */
/* @var $content string */

$contact = ContactForm::getNew();
$zayavka = Zayavka::getNew();
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
<li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning"><?=$zayavka+$contact?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"><?=Lang::t("Ma'lumot")?></li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">

                                <li>
                                    <a href="#">
                                        <i class="fa fa-eye text-aqua"></i> <?=$zayavka?> ta Kursga qiziqish bor
                                    </a>
                                </li>
                                
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-red"></i> <?=$contact?> ta Xatlar bor
                                    </a>
                                </li>

                                
                            </ul>
                        </li>
                        <!-- <li class="footer"><a href="#">View all</a></li> -->
                    </ul>
                </li>


                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/web/<?=Yii::$app->user->identity->image?>" class="user-image" alt="User Image"/>
                        <span id="och" class="hidden-xs"><?=Yii::$app->user->identity->fio?></span>
                    </a>
                    <ul class="dropdown-menu">

                        <!-- User image -->
                        <li class="user-header">
                            <img src="/web/<?=Yii::$app->user->identity->image?>" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                <?=Yii::$app->user->identity->fio?>
                                <small><?=Yii::$app->user->identity->tel?></small>
                            </p>
                        </li>

                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?=Yii::$app->UrlManager->createUrl('/admin/user/user')?>" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

               
            </ul>
        </div>
    </nav>
</header>

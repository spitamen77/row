<?php
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use app\models\maxpirali\Menu;
use yii\helpers\Url;
use app\models\Lang;
// use app\models\dilshod\Menu;
if (isset($_GET['slug'])) {
    $action= '';
}
else $action = Yii::$app->controller->action->id;
?>

<!-- Header _________________________________ -->
<header class="main-header">


    <div class="top-header">
        <div class="container">
            <div class="left-side float-left">
                <ul>
                    <li><span class="icon round-border"><i class="ficon flaticon-signs"></i></span> <a href="<?=Url::to('/site/contact')?>" class="tran3s"><?=Lang::t('Address')?></a></li>
                    <li><span class="icon round-border"><i class="ficon flaticon-multimedia"></i></span> <a href="mailto:<?=Lang::t('emailto')?>" class="tran3s"><?=Lang::t('emailto')?></a></li>
                    <li><span class="icon round-border"><i class="ficon flaticon-technology"></i></span> <a href="tel:<?=Lang::t('telefon')?>" class="tran3s"><?=Lang::t('telefon')?></a></li>
                    <li><span class="icon round-border"><i class="ficon flaticon-translation"></i></span>
                        <?= Html::a(Lang::t('Uz'), ['site/lang',['id'=>'uz-UZ', 'url'=>Url::current()]]) ?>
                        <span> | </span>
                        <?= Html::a(Lang::t('Ru'), ['site/lang',['id'=>'ru-RU', 'url'=>Url::current()]]) ?>
                        <span> | </span>
                        <?= Html::a(Lang::t('En'), ['site/lang',['id'=>'en-US', 'url'=>Url::current()]]) ?>
                    </li>
                </ul>
            </div> <!-- /.left-side -->
            <div class="right-side float-right">
                <ul>
                    <li><a href="https://www.facebook.com/groups/934843233533389/" target="_blank" class="tran3s round-border icon"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    
                    <li><a href="https://t.me/outcometree" target="_blank" class="tran3s round-border icon"><i class="fa fa-paper-plane" aria-hidden="true"></i></a></li>
                </ul>
            </div> <!-- /.right-side -->
        </div>
    </div> <!-- /.top-header -->

    <!-- _______________________ Theme Menu _____________________ -->

    <div class="container">
        <div class="main-menu-wrapper clear-fix">
            <div class="container">
                <div class="logo float-left"><a href="<?=Url::to('/')?>" style="vertical-align:middle;"><img src="/themes/edutech/images/logo3.png" alt="<?=Lang::t('Training center Outcome Tree')?>"></a></div>

                <form action="<?=Url::to('/site/search')?>" class="float-right">
                    <input type="text" name="search" placeholder="<?=Lang::t('Search')?>">
                    <button><i class="fa fa-search-minus" aria-hidden="true"></i></button>
                </form>

                <!-- Menu -->
                <nav class="navbar float-right">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="dropdown-holder <?=($action=='index')?'current-page-item':''?>"><a href="<?=Url::to('/')?>"><?=Lang::t('bosh sahifa')?></a>
                            <li class="dropdown-holder <?=($action=='about')?'current-page-item':''?>"><a href="<?=Url::to('/site/about')?>"><?=Lang::t('About us')?></a>
                            </li>
                            <?php PrintMenu(Menu::menus()); ?>
                            <li class="dropdown-holder <?=($action=='contact')?'current-page-item':''?>"><a href="<?=Url::to('/site/contact')?>"><?=Lang::t('Contact us')?></a>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </nav>
            </div>
        </div> <!-- /.main-menu-wrapper -->
    </div>
</header>
<?php function PrintMenu($menu){ ?>
    <? foreach ($menu as $value) { ?>
        <li class="dropdown-holder <?=($_GET['slug']==$value['slug'])?'current-page-item':''?>"><a href="<?=Url::to(['site/index', 'slug' => $value['slug']])?>"><?=$value['title']?></a>
            <?  if ($value['children']) {   ?>
                <ul class="sub-menu">
                    <? PrintMenu($value['children']); ?>
                    <li><a href="<?=Url::to('/site/teachers')?>"><?=Lang::t('Teacher')?></a>  </li>
                </ul>
            <?} ?>
        </li>
        <? } ?>  
   <? }?>

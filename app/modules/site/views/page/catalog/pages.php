<?php

use app\models\maxpirali\MenuItem;
use yii\helpers\Url;
use app\models\Lang;
use yii\widgets\LinkPager;

$this->title = $menu->title;
$this->params['desc'] = $this->title.' - '.$this->title;
?>
<!-- Page Breadcrum __________________________ -->
<div class="page-breadcrum">
    <div class="container">
        <ul>
            <li><a href="<?=Url::to('/')?>"><?=Lang::t('Home')?></a></li>
            <li>-</li>
            <li><?=Lang::t('Pages')?></li>
        </ul>
    </div> <!-- /.container -->
</div> <!-- /.page-breadcrum -->

<div class="course-page-single course-v1">
    <!-- Course Finder  ______________________________ -->

    <!-- Popular Course _________________________ -->
    <div class="popular-course wow fadeInUp theme-bg-color">
        <div class="container">
            <div class="row">
                <div class="course-item-wrapper">
                    <?php foreach ($model as $value):?>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                        <div class="hvr-float-shadow single-course-item">
                            <div class="img-holder">
                                <a href="<?=Url::to('/?slug='.$value->template->slug.'&item_slug='.$value->slug)?>">
                                <img src="<?=$value->photo?>" alt="<?=$value->translate->title?>">
                                </a>
                            </div>
                            <div class="text">
                                <h4><a href="<?=Url::to('/?slug='.$value->template->slug.'&item_slug='.$value->slug)?>"><?=$value->translate->title?></a></h4>
                                <div class="img round-border"><img src="<?=$value->teacher->photo?>" alt="<?=$value->teacher->name?>"></div>
                                <h6><?=$value->teacher->name?></h6>

                                <p><?=$value->translate->short?></p>
                                <div class="clear-fix">
                                    <ul class="float-left">
                                        <li><i class="fa fa-calendar" aria-hidden="true"></i> <?=$value->sale?> <?=Lang::t('Month')?>,</li>
<!--                                        <li><i class="fa fa-comment" aria-hidden="true"></i> 5</li>-->
                                        <li><i class="fa fa-money" aria-hidden="true"></i> <?=Lang::t('Price')?> (сум)</li>
                                    </ul>

                                    <a href="<?=Url::to('/?slug='.$value->template->slug.'&item_slug='.$value->slug)?>" class="tran3s p-color-bg themehover"><?= number_format($value->price, 0, ',', ' '); ?></a>
                                </div>
                            </div> <!-- /.text -->
                        </div>
                    </div> <!-- /.item -->
                    <?php endforeach;?>
                </div> <!-- /.course-slider -->
            </div> <!-- /.row -->

            <!-- __________________________ Page Indicator __________________ -->
            <div class="page-indicator">
                <?= LinkPager::widget([
                    'pagination' => $pages,
                ]);?>
            </div>
        </div> <!-- /.container -->
    </div> <!-- /.popular-course -->
</div> <!-- /.course-page-single -->


<!-- Latest Event Slider Section _______ -->
<div class="latest-event-slider event-section wow fadeInUp bg-color-fix">
    <div class="container">
        <h3><?=Lang::t('Event')?></h3>
        <div class="row">
            <div class="theme-slider">
                <?php foreach (MenuItem::getXit(12) as $item): ?>
                <div class="item hvr-float-shadow">
                    <div class="single-event theme-bg-color">
                        <div class="date p-color"><?=date("j",$item->created_date)?> <span><?=date("M",$item->created_date)?></span></div>
                        <a href="<?=Url::to('/?slug='.$item->template->slug.'&item_slug='.$item->slug)?>"><h6><?=$item->translate->title?></h6></a>
                        <p><?=$item->translate->short?></p>
                        <ul>
                            <li><i class="fa fa-money" aria-hidden="true"></i> <?=number_format($item->price, 0, ',', ' ')?></li>
                            <li><i class="fa fa-clock-o" aria-hidden="true"></i> <?=$item->time?></li>
                        </ul>
                    </div> <!-- /.single-event -->
                </div> <!-- /.item -->

                <?php endforeach;?>
            </div> <!-- /.theme-slider -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</div> <!-- /.latest-event-slider -->

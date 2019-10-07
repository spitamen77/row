<?php

/* @var $this yii\web\View */

use app\models\Lang;
use app\models\maxpirali\MenuItem;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Lang::t('About us');
$this->params['breadcrumbs'][] = $this->title;
$this->params['desc']=$this->title;
?>
<!-- Page Breadcrum __________________________ -->
<div class="page-breadcrum">
    <div class="container">
        <ul>
            <li><a href="<?=Url::to('/')?>"><?=Lang::t('Home')?></a></li>
            <li>-</li>
            <li><?=$this->title?></li>
        </ul>
    </div> <!-- /.container -->
</div> <!-- /.page-breadcrum -->

<!-- Welcome Section ___________________________ -->
<div class="welcome-section">
    <div class="container">
        <div class="section-title wow fadeInUp">
            <h2 class="p-color">Welcome to edutech</h2>
            <h5>awesome success with student</h5>
            <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem </p>
        </div> <!-- /.section-title -->

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 wow fadeInUp">
                <h3><i class="fa fa-graduation-cap" aria-hidden="true"></i> LEARN COUSES first</h3>
                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia con- sequuntur magni dolores eos qui ratione </p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 wow fadeInUp">
                <h3><i class="fa fa-tags" aria-hidden="true"></i> 440 Courses available</h3>
                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia con- sequuntur magni dolores eos qui ratione </p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 wow fadeInUp">
                <h3><i class="fa fa-diamond" aria-hidden="true"></i> Everything you need</h3>
                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia con- sequuntur magni dolores eos qui ratione </p>
            </div>
        </div>
    </div> <!-- /.container -->
</div> <!-- /.welcome-section -->

<!-- course Progress  __________________________ -->
<div class="course-progress wow fadeInUp mFix">
    <div class="opacity">
        <div class="container">
            <h2>GET 100 COURSES FOR <span class="p-color">FREE</span></h2>
            <p>Tech you how to build a complete learning management system upcoming education for student</p>
            <h6>WE'RE GOOD AT some member</h6>

            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div class="icon"> <i class="ficon flaticon-crowdfunding"></i> </div>
                    <p>CERTIFIED TEACHERS</p>
                    <div class="number"><span class="timer" data-from="0" data-to="117" data-speed="1500" data-refresh-interval="5">0</span></div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div class="icon"><i class="ficon flaticon-teamwork"></i></div>
                    <p>COURSES COMPLETE</p>
                    <div class="number"><span class="timer" data-from="0" data-to="12456" data-speed="1500" data-refresh-interval="5">0</span></div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div class="icon"><i class="ficon flaticon-medical"></i></div>
                    <p>Students Enrolled</p>
                    <div class="number"><span class="timer" data-from="0" data-to="220234" data-speed="1500" data-refresh-interval="5">0</span></div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div class="icon"><i class="ficon flaticon-book"></i></div>
                    <p>Students Enrolled</p>
                    <div class="number"><span class="timer" data-from="0" data-to="100" data-speed="1500" data-refresh-interval="5">0</span>%</div>
                </div>
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </div> <!-- /.opacity -->
</div> <!-- /.course-progress -->


<!-- Our Teacher ________________________ -->
<div class="our-teacher wow fadeInUp">
    <div class="container">
        <h2><?=Lang::t('Our teachers')?></h2>
        <div class="theme-title">
            <p>Our talent tainer with 10 years experience professional</p>
        </div>

        <div class="row">
            <div class="theme-slider">
                <?php foreach ($model as $item) :?>
                    <div class="item">
                        <div class="item-wrapper theme-bg-color tran3s hvr-float-shadow">
                            <div class="img-holder round-border">
                                <img src="../<?=$item->photo?>" alt="<?=$item->name?>">
                                <div class="overlay round-border tran4s">
                                    <ul>
                                        <li><a href="<?=$item->facebook?>" target="_blank" class="tran3s round-border icon"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li><a href="tel:<?=$item->phone?>" class="tran3s round-border icon"><i class="fa fa-phone" aria-hidden="true"></i></a></li>
                                        <li><a href="mailto:<?=$item->email?>" class="tran3s round-border icon"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div> <!-- /.img-holder -->
                            <a href="<?=Url::to('/site/teacher?id='.$item->id)?>"><h6><?=$item->name?></h6></a>
                            <p><?=$item->fan?></p>
                        </div>
                    </div> <!-- /.item -->
                <?php endforeach;?>

            </div>
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</div> <!-- /.our-teacher -->


<!-- Latest Event Slider Section _______ -->
<div class="latest-event-slider event-section wow fadeInUp">
    <div class="container">
        <h3><?=Lang::t('Latest Events')?></h3>

        <div class="row">
            <div class="theme-slider">
                <?php foreach (MenuItem::getXits(12,11,6) as $item): ?>
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
                <?php endforeach; ?>

            </div> <!-- /.theme-slider -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</div> <!-- /.latest-event-slider -->


<!-- Our Certifications __________________-->
<div class="our-certification">
    <div class="container">
        <h3>our certifications</h3>

        <div class="row">
            <div class="theme-slider">
                <div class="item hvr-float-shadow">
                    <img src="/web/themes/edutech/images/logo3.jpg" alt="">
                </div> <!-- /.item -->

                <div class="item hvr-float-shadow">
                    <img src="/web/themes/edutech/images/logo3.jpg" alt="">
                </div> <!-- /.item -->

                <div class="item hvr-float-shadow">
                    <img src="/web/themes/edutech/images/logo3.jpg" alt="">
                </div> <!-- /.item -->

                <div class="item hvr-float-shadow">
                    <img src="/web/themes/edutech/images/logo3.jpg" alt="">
                </div> <!-- /.item -->

                <div class="item hvr-float-shadow">
                    <img src="/web/themes/edutech/images/logo3.jpg" alt="">
                </div> <!-- /.item -->


            </div> <!-- /.theme-slider -->
        </div> <!-- /.row -->
    </div> <!-- /.containr -->
</div> <!-- /.our-ertifications -->
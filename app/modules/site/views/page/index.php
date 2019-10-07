<?php

use app\models\maxpirali\MenuItem;
use yii\helpers\Url;
use app\models\Lang;
/* @var $this yii\web\View */
use app\models\dilshod\Photo;
$this->title = Lang::t('Training center Outcome Tree');
$images = Photo::getPhoto();

?>

<!-- Theme Banner ________________________________ -->
<div id="banner">
    <div class="rev_slider_wrapper">
        <!-- START REVOLUTION SLIDER 5.0.7 auto mode -->
        <div id="main-banner-slider" class="rev_slider" data-version="5.0.7">
            <ul>
            <? foreach($images->rasm as $photo): ?>
                <!-- SLIDE1  -->
                <li data-index="<?=$photo->id?>" data-transition="zoomout" data-slotamount="<?=$photo->id?>" data-easein="Power4.easeInOut" data-easeout="Power4.easeInOut" data-masterspeed="2000" data-rotate="0" data-saveperformance="off" data-title="<?=$photo->photo->info?>" data-description="">
                    <!-- MAIN IMAGE -->
                    <img src="<?=$photo->src?>" alt="<?=$photo->photo->info?>" class="rev-slidebg" data-bgparallax="3" data-bgposition="center center" data-duration="20000" data-ease="Linear.easeNone" data-kenburns="on" data-no-retina="" data-offsetend="0 0" data-offsetstart="0 0" data-rotateend="0" data-rotatestart="0" data-scaleend="100" data-scalestart="140">
                    <!-- LAYERS -->

                    <!-- LAYER NR. 1 -->
                    <div class="tp-caption" data-x="['left','left','left','left']" data-hoffset="['0','25','35','15']" data-y="['middle','middle','middle','middle']" data-voffset="['-56','-56','-45','-150']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];" data-mask_out="x:inherit;y:inherit;" data-start="1000" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 6; white-space: nowrap;">
                        <!-- <h5><?=$photo->photo->info?> </h5> -->
                    </div>

                    <!-- LAYER NR. 2 -->
                    <div class="tp-caption" data-x="['left','left','left','left']" data-hoffset="['0','25','35','15']" data-y="['middle','middle','middle','middle']" data-voffset="['20','25','30','-85']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];" data-mask_out="x:inherit;y:inherit;" data-start="2000" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 6; white-space: nowrap;">
                        <h1><?=$photo->photo->info?>  </h1>
                        <!-- <span class="p-color"><?=$photo->photo->info?></span> -->
                    </div>


                    <!-- LAYER NR. 3 -->
                    <!-- <div class="tp-caption" data-x="['left','left','left','left']" data-hoffset="['0','25','35','15']" data-y="['middle','middle','middle','middle']" data-voffset="['205','205','210','80']" data-transform_idle="o:1;" data-transform_hover="o:1;rX:0;rY:0;rZ:0;z:0;s:300;e:Power1.easeInOut;" data-transform_in="x:[-100%];z:0;rX:0deg;rY:0deg;rZ:0deg;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2500;e:Power3.easeInOut;" data-transform_out="auto:auto;s:1000;e:Power2.easeInOut;" data-start="3000" data-splitin="none" data-splitout="none" data-responsive_offset="on">
                        <a href="course-v1.html" class="course-button">View courses</a>
                    </div> -->
                    
                    <!-- LAYER NR. 4 -->
                    <!-- <div class="tp-caption" data-x="['left','left','left','left']" data-hoffset="['192','217','227','15']" data-y="['middle','middle','middle','middle']" data-voffset="['205','205','210','155']" data-transform_idle="o:1;" data-transform_hover="o:1;rX:0;rY:0;rZ:0;z:0;s:300;e:Power1.easeInOut;" data-transform_in="x:[100%];z:0;rX:0deg;rY:0deg;rZ:0deg;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2500;e:Power3.easeInOut;" data-transform_out="auto:auto;s:1000;e:Power2.easeInOut;" data-start="3000" data-splitin="none" data-splitout="none" data-responsive_offset="on">
                        <a href="contact-us.html" class="buy-button p-color-bg">BUY NOW</a>
                    </div> -->
                
                </li>
            <?php endforeach;?>
            
            </ul>
         
        </div>
    </div><!-- END REVOLUTION SLIDER -->
</div> <!--  /#banner -->


<!-- Manage Section _________________________ -->
<div class="theme-manage-area">
    <div class="container">
        <div class="item-part float-left item1 p-color-bg">
            <h3><i class="fa fa-graduation-cap" aria-hidden="true"></i> LEARN COUSES first</h3>
            <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequun- tur magni dolores eos qui ratione </p>
            <a href="?slug=programms" class="tran3s"><?=Lang::t('Read more')?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
        </div>
        <div class="item-part float-left item2">
            <img src="/themes/edutech/images/1 (1).jpg" alt="Image">
        </div>
        <div class="item-part float-left item1 p-color-bg">
            <h3><i class="fa fa-book" aria-hidden="true"></i> BOOK LIBRARY</h3>
            <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequun- tur magni dolores eos qui ratione </p>
            <a href="/site/books" class="tran3s">Rede more <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
        </div>
    </div> <!-- /.container -->
</div> <!-- /.theme-manage-area -->


<!-- Course Finder  ______________________________ -->
<div class="course-search-option wow fadeInUp">
    
</div> <!-- /.course-search-option -->



<!-- Welcome Section ___________________________ -->
<div class="welcome-section">
    <div class="container">
        <div class="section-title wow fadeInUp">
            <h2 class="p-color">Welcome to outcome tree</h2>
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



<!-- Popular Course _________________________ -->
<div class="popular-course wow fadeInUp theme-bg-color">
    <div class="container">
        <h2><?=Lang::t('POPULAR COURSES')?></h2>

        <div class="row">
            <div class="theme-slider course-item-wrapper">
                <?php foreach ($model as $value):?>
                <div class="item hvr-float-shadow">
                    <div class="img-holder"><img src="<?=$value->photo?>" alt="<?=$value->translate->title?>"></div>
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

                            <a href="<?=Url::to('/?slug='.$value->template->slug.'&item_slug='.$value->slug)?>" class="tran3s p-color-bg themehover"><?=number_format($value->price, 0, ',', ' ');?></a>
                        </div>
                    </div> <!-- /.text -->
                </div> <!-- /.item -->
                <?php endforeach;?>
            </div> <!-- /.course-slider -->
        </div>
    </div> <!-- /.container -->
</div> <!-- /.popular-course -->


<!-- course Progress  __________________________ -->
<div class="course-progress">
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



<!-- Event Section _______________________ -->
<div class="event-section wow fadeInUp">
    <div class="container">
        <div class="theme-title">
            <h2><?=Lang::t('Events')?></h2>
            <p><?=Lang::t('Our upcoming event you should mind always')?></p>
        </div>

        <div class="row">
            <?php foreach (MenuItem::getXit(12,6) as $item): ?>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 wow fadeInUp hvr-float-shadow">
                <div class="single-event theme-bg-color">
                    <div class="date p-color"><?=date("j",$item->created_date)?> <span><?=date("M",$item->created_date)?></span></div>
                    <a href="<?=Url::to('/?slug='.$item->template->slug.'&item_slug='.$item->slug)?>"><h6><?=$item->translate->title?></h6></a>
                    <p><?=$item->translate->short?></p>
                    <ul>
                        <li><i class="fa fa-money" aria-hidden="true"></i> <?=number_format($item->price, 0, ',', ' ')?></li>
                        <li><i class="fa fa-clock-o" aria-hidden="true"></i> <?=$item->time?></li>
                    </ul>
                </div> <!-- /.single-event -->
            </div>
            <?php endforeach;?>

        </div> <!-- /.row -->
    </div> <!-- /.container -->
</div> <!-- /.event-section -->



<!-- Latest News ___________________________ -->
<div class="latest-news wow fadeInUp theme-bg-color">
    <div class="container">
        <div class="theme-title">
            <h2><?=Lang::t('Latest news')?></h2>
            <p>Something for education news,latest news feed</p>
        </div>

        <div class="post-wrapper row">
            <?php foreach ($news as $key => $value) : ?>
            <div class="single-post wow fadeInUp col-lg-4 col-md-4 col-sm-6 col-xs-6">
                <div class="img-holder">
                    <div class="date wow fadeInUp p-color-bg"><?=date("j",$value->created_date)?> <span><?=date("M",$value->created_date)?></span></div>
                    <img src="<?=$value->photo?>" alt="<?=$value->translate->title?>">
                    <a href="<?=Url::to('/?slug='.$value->template->slug.'&item_slug='.$value->slug)?>" class="tran4s"></a>
                </div>
                <div class="text-wrapper">
                    <div class="text tran4s">
                        <a href="<?=Url::to('/?slug='.$value->template->slug.'&item_slug='.$value->slug)?>"><?=$value->translate->title?> </a>
                        <p><?=$value->translate->short?> </p>
                    </div> <!-- /.text -->
                </div> <!-- /.text-wrapper -->
            </div> <!-- /.single-post -->
            <?php endforeach;?>    
           
        </div> <!-- /.post-wrapper -->
    </div> <!-- /.container -->
</div> <!-- /.latest-news -->



<!-- Testimonial And FAQ Section _________________________ -->
<div class="test-faq">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 testimonial wow fadeInLeft">
                <div class="wrapper">
                    <h3>TESTIMONIALS</h3>
                    <div id="testimonial-carousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#testimonial-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#testimonial-carousel" data-slide-to="1"></li>
                            <li data-target="#testimonial-carousel" data-slide-to="2"></li>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <div class="single-box theme-bg-color">
                                    <div class="img round-border"><img src="images/home/2.png" alt="Image"></div>
                                    <h6>ghost riad <span>(Sir.Principal)</span></h6>
                                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolo- rem ipsum</p>
                                </div> <!-- /.single-box -->

                                <div class="single-box theme-bg-color">
                                    <div class="img round-border"><img src="images/home/3.png" alt="Image"></div>
                                    <h6>Masum nodi <span>(Sir.Principal Fohinni)</span></h6>
                                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolo- rem ipsum</p>
                                </div> <!-- /.single-box -->
                            </div>

                            <div class="item">
                                <div class="single-box theme-bg-color">
                                    <div class="img round-border"><img src="images/home/2.png" alt="Image"></div>
                                    <h6>ghost riad <span>(Sir.Principal)</span></h6>
                                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolo- rem ipsum</p>
                                </div> <!-- /.single-box -->

                                <div class="single-box theme-bg-color">
                                    <div class="img round-border"><img src="images/home/3.png" alt="Image"></div>
                                    <h6>Masum nodi <span>(Sir.Principal Fohinni)</span></h6>
                                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolo- rem ipsum</p>
                                </div> <!-- /.single-box -->
                            </div>

                            <div class="item">
                                <div class="single-box theme-bg-color">
                                    <div class="img round-border"><img src="images/home/2.png" alt="Image"></div>
                                    <h6>ghost riad <span>(Sir.Principal)</span></h6>
                                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolo- rem ipsum</p>
                                </div> <!-- /.single-box -->

                                <div class="single-box theme-bg-color">
                                    <div class="img round-border"><img src="images/home/3.png" alt="Image"></div>
                                    <h6>Masum nodi <span>(Sir.Principal Fohinni)</span></h6>
                                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolo- rem ipsum</p>
                                </div> <!-- /.single-box -->
                            </div>
                        </div>
                    </div> <!-- /#testimonial-carousel -->
                </div> <!-- /.wrapper -->
            </div> <!-- /.testimonial -->

            
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</div> <!-- /.test-faq -->




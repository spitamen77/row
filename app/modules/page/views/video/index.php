<?
use uni\components\manager\Url;

//var_dump($mostlasts);exit;
// echo Uni::$app->controller->access('ADMIN');exit;
?>
<div class="row page-bar">
    <div class="container">
        <div class="row ">
            <div class="col-md-7 col-sm-7 col-xs-12 blog-title">
                <h1>O'zingiz uchun mos kasb tanglang</h1>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3 blog_crumb">
              
                <a class="change-prof" href="<?=(!Uni::$app->user->isGuest)?$this->to('users/course/search'):$this->to('users/auth/join?user=0')?>">Kasbni tanlash</a>
            </div>
            <div class="col-md-1"></div>

        </div>
    </div>
</div>
<!-- End Title Outer Div -->

<div class="container">

</div>



<div class="container">
    <div class="row sidebar-on-rigth">
        <div class="col-md-12">
            <div class="row">
                <div class="jw-element   jw-animate-gen animated fadeIn" data-gen="fadeIn"
                     data-gen-offset="100%" style="">
                    <div class="jw-title-container"><h2 class="jw-title jw-title-5230">Trend kasblar</h2>
                    </div>
                    <? if($trendkasbl){ ?>
                    <?$i=1;foreach ($trendkasbl as $mostlast) {
                        if ($i==7){echo "<div class='clearfix'></div>";$i=1;}
                        $i++;
                        ?>
                        
                    <div class="col-md-2 col-sm-3 col-xs-3 video-box-holder video-list  grid-size-4">
                        <div class="">
                            <div class="video-image-holder " style="height:140px !important; ">
                                <img class="video-aq-thumb" src="<?=$mostlast->img?>" alt="<?=$mostlast->title?>" height="50px !important">
                                
                                
                            </div>
                            <div class="video-meta-holder ">
                                <div class="row">
                                    
                                    
                                        <a href="<?=$this->to('page/profession/view/').$mostlast->id?>"><?=$mostlast->title?></a>
                                    
                                </div>
                            </div>
                            <div class="col-sm-12">
                            </div>
                        </div>
                    </div>

                    <?}}?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        
    </div>
</div>


<div class="container">
    <div class="row sidebar-on-rigth">
        <div class="col-md-12">
            <div class="row">
                <div class="jw-element   jw-animate-gen animated fadeIn" data-gen="fadeIn"
                     data-gen-offset="100%" style="">
                    <div class="jw-title-container"><h2 class="jw-title jw-title-5230">Trend kurslar</h2>
                    </div>
                    <? if($trendkursl){ ?>
                    <?$i=1;foreach ($trendkursl as $mostlast) {
                        if ($i==7){echo "<div class='clearfix'></div>";$i=1;}
                        $i++;
                        ?>
                        
                    <div class="col-md-2 col-sm-3 col-xs-3 video-box-holder video-list  grid-size-4">
                        <div class="">
                            <div class="video-image-holder " style="height:140px !important; ">
                                <img class="video-aq-thumb" src="<?=$mostlast->image?>" height="140px !important">
                                
                                
                            </div>
                            <div class="video-meta-holder ">
                                <div class="row">
                                    
                                    
                                        <a href="#!"><?=$mostlast->title?></a>
                                    
                                </div>
                            </div>
                            <div class="col-sm-12">
                            </div>
                        </div>
                    </div>

                    <?}}?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<div class="container">
    <div class="row sidebar-on-rigth">
        <div class="col-md-12">
            <div class="row">
                <div class="jw-element   jw-animate-gen animated fadeIn" data-gen="fadeIn"
                     data-gen-offset="100%" style="">
                    <div class="jw-title-container"><h2 class="jw-title jw-title-5230">Trend videolar</h2>
                    </div>
                    <?if($mostviews){?>
                    <?$i=1;foreach ($mostviews as $mostlast) {
                        if ($i==7){echo "<div class='clearfix'></div>";$i=1;}
                        $i++;
                        ?>
                        
                    <div class="col-md-2 col-sm-3 col-xs-3 video-box-holder video-list  grid-size-4">
                        <div class="">
                            <div class="video-image-holder " style="height:140px !important; ">
                                <img class="video-aq-thumb" src="<?=$mostlast->img?>" alt="<?=$mostlast->img?>" height="100%">
                                
                                
                            </div>
                            <div class="video-meta-holder ">
                                <div class="row">
                                    
                                    
                                        <a href="#!"><?=$mostlast->title?></a>
                                    
                                </div>
                            </div>
                            <div class="col-sm-12">
                            </div>
                        </div>
                    </div>

                    <?}}?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        
    </div>
</div>




















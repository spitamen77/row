<?
use uni\components\manager\Url;

//var_dump($mostlasts);exit;
?>
<div class="full-topbar-recover"></div>
<div class="row page-bar">
    <div class="container">
        <div class="row ">
            <div class="col-md-7 col-sm-7 col-xs-12 blog-title">
                <h1>O'zingiz uchun mos kasb tanglang</h1>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3 blog_crumb">
                <a class="btn btn-success btn-block" href="<?=$this->to('users/course/search')?>">Kasbni tanlash</a>
            </div>
            <div class="col-md-1"></div>

        </div>
    </div>
</div>
<!-- End Title Outer Div -->

<div class="container">
</div>




<div class="container">
    <div class="row grid-holder">
        <?$i=1;foreach ($mostviews as $mostview) {
            //print_r($mostview);exit;
        if($i==6) break;
        if($i==1){   ?>

        <div class="col-md-6 col-sm-12 col-xs-12  video-box-holder video-list sticky-grid-video grid-size-6">
            <div class=" wow pulse" data-wow-duration="1s">
                <div class="video-image-holder">
                    <div class="top-shadow">
                        <span><?=$mostview->publish?></span>
                        <span><i class="fa fa-vimeo"></i><?=$mostview->user->username?></span>
                        <span><i class="fa fa-eye"></i><?=$mostview->view?></span>
                    </div>
                    <img class="videi-ft-thumb"
                         src="/themes/kasb/img/shoes-555x453.jpg"
                         alt="Mark Of the Dragon &#8211; Epic Trailer">
                                <span class="play-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 294.843 294.843" xml:space="preserve" width="512px" height="512px" class="img-responsive play-svg svg replaced-svg"><g><path d="M278.527,79.946c-10.324-20.023-25.38-37.704-43.538-51.132c-2.665-1.97-6.421-1.407-8.392,1.257s-1.407,6.421,1.257,8.392 c16.687,12.34,30.521,28.586,40.008,46.983c9.94,19.277,14.98,40.128,14.98,61.976c0,74.671-60.75,135.421-135.421,135.421 S12,222.093,12,147.421S72.75,12,147.421,12c3.313,0,6-2.687,6-6s-2.687-6-6-6C66.133,0,0,66.133,0,147.421 s66.133,147.421,147.421,147.421s147.421-66.133,147.421-147.421C294.842,123.977,289.201,100.645,278.527,79.946z" fill="#FFFFFF"></path><path d="M109.699,78.969c-1.876,1.067-3.035,3.059-3.035,5.216v131.674c0,3.314,2.687,6,6,6s6-2.686,6-6V94.74l88.833,52.883 l-65.324,42.087c-2.785,1.795-3.589,5.508-1.794,8.293c1.796,2.786,5.508,3.59,8.294,1.794l73.465-47.333 c1.746-1.125,2.786-3.073,2.749-5.15c-0.037-2.077-1.145-3.987-2.93-5.05L115.733,79.029 C113.877,77.926,111.575,77.902,109.699,78.969z" fill="#FFFFFF"></path></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                    </span>
                    <a href="/themes/kasb/video/allo.mp4"
                       class="video-quickply html5lightbox" data-videoid="22611216"></a>
                    <h3 class="grid-author">
            <span>
              <a href="#" title="<?=$mostview->user->makeFIO()?>"><?=$mostview->user->makeFIO()?></a></span>
                        <span class="clearfix"></span>
                        <a href="http://kamyab.tv/mytube/video/nightmare-malaria-game-teaser/"><?=$mostview->title?></a>
                    </h3>
                    <div class="bottom-shadow"></div>

                </div>
            </div>
        </div>

        <?}else{?>
        
        <div class="col-md-3 col-sm-6 col-xs-12  video-box-holder video-list small-grid grid-size-3">
            <div class=" wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.1s">
                <div class="video-image-holder ">
                    <div class="top-shadow">
                        <span><?=$mostview->publish?></span>
                        <span><i class="fa fa-vimeo"></i><?=$mostview->user->username?></span>
                        <span><i class="fa fa-eye"></i><?=$mostview->view?></span>
                    </div>
                    <img class="videi-ft-thumb"
                         src="<?=($mostview->img)?$mostview->img:$mostview->tmpimg?>"
                         alt="<?=$mostview->title?>">
                                <span class="play-icon play-small-icon">
                          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 294.843 294.843" xml:space="preserve" width="512px" height="512px" class="img-responsive play-svg svg replaced-svg"><g><path d="M278.527,79.946c-10.324-20.023-25.38-37.704-43.538-51.132c-2.665-1.97-6.421-1.407-8.392,1.257s-1.407,6.421,1.257,8.392 c16.687,12.34,30.521,28.586,40.008,46.983c9.94,19.277,14.98,40.128,14.98,61.976c0,74.671-60.75,135.421-135.421,135.421 S12,222.093,12,147.421S72.75,12,147.421,12c3.313,0,6-2.687,6-6s-2.687-6-6-6C66.133,0,0,66.133,0,147.421 s66.133,147.421,147.421,147.421s147.421-66.133,147.421-147.421C294.842,123.977,289.201,100.645,278.527,79.946z" fill="#FFFFFF"></path><path d="M109.699,78.969c-1.876,1.067-3.035,3.059-3.035,5.216v131.674c0,3.314,2.687,6,6,6s6-2.686,6-6V94.74l88.833,52.883 l-65.324,42.087c-2.785,1.795-3.589,5.508-1.794,8.293c1.796,2.786,5.508,3.59,8.294,1.794l73.465-47.333 c1.746-1.125,2.786-3.073,2.749-5.15c-0.037-2.077-1.145-3.987-2.93-5.05L115.733,79.029 C113.877,77.926,111.575,77.902,109.699,78.969z" fill="#FFFFFF"></path></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                       </span>
                    <a href="https://player.vimeo.com/video/26600961?title=0&#038;byline=0&#038;portrait=0"
                       class="video-quickply html5lightbox" data-videoid="26600961"></a>

                    <h3 class="grid-author">
            <span>
              <a href="#" title="<?=$mostview->user->makeFIO()?>"><?=$mostview->user->makeFIO()?></a></span>
                        <span class="clearfix"></span>
                        <a href="#"><?=$mostview->title?></a>
                    </h3>
                    <div class="bottom-shadow"></div>

                </div>
            </div>
        </div>
        <?}$i++;}?>

        
    </div>
    <div class="clearfix"></div>
</div>








<div class="container">
    <div class="row sidebar-on-rigth">
        <div class="col-md-9">
            <div class="row">
                <div class="jw-element   jw-animate-gen animated fadeIn" data-gen="fadeIn"
                     data-gen-offset="100%" style="">
                    <div class="jw-title-container"><h2 class="jw-title jw-title-5230">Yangi yuklangan videolar</h2>
                    </div>
                    <?$i=1;foreach ($mostlasts as $mostlast) {
                        if ($i==7) break;
                        $i++;
                        ?>
                        
                    <div class="col-md-4 col-sm-6 col-xs-12 video-box-holder video-list  grid-size-4">
                        <div class="">
                            <div class="video-image-holder ">
                                <div class="top-shadow">
                                    <span><?=$mostlast->publish?></span>
                                    <span class="fa fa-vimeo"><?=$mostlast->user->username?></span>
                                    <span><i class="fa fa-eye"></i><?=$mostlast->view?></span>
                                </div>
                                <img class="video-aq-thumb" <?=($mostlast->img)?$mostlast->img:$mostlast->tmpimg?>" alt="<?=$mostlast->title?>">
                                <span class="play-icon quick-play play-small-icon" data-video_id="986"></span>
                                <a href="https://player.vimeo.com/video/22611216?title=0&amp;byline=0&amp;portrait=0"
                                   class="video-quickply html5lightbox" data-videoid="22611216"></a>
                            </div>
                            <div class="video-meta-holder ">
                                <div class="row">
                                    <div class="author-name">
                                        By
                                        <span><a href="#"
                                                 title="<?=$mostlast->user->makeFIO()?>"><?=$mostlast->user->makeFIO()?></a></span>
                                    </div>
                                    <h3>
                                        <a href="http://kamyab.tv/mytube/video/nightmare-malaria-game-teaser/"><?=$mostlast->title?></a></h3>
                                    <div class="meta-right ">
                                        <span>Publish:<?=$mostlast->publish?></span> / 
                                        <span>Views:<?=$mostlast->view?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                            </div>
                        </div>
                    </div>
                    <?}?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="row">
                <div class="jw-element col-md-4  jw-animate-gen animated fadeInRight">
                    <aside class="widget widget_video_list_widget" id="video_list_widget-5">    <h2 class="widget-title">Trend kasblar
                        <span class="widtbor"></span>
                        </h2>
                        <?$i=0;foreach ($trendkasblar as $trendkasb) {
                            $i++; if($i==4) break;
                            ?>
                            
                        <div class="widget-video-list">
                            <div class="row">
                                <div class="col-xs-4">
                                    <a href="#">
                                        <img src="/themes/kasb/img/shoes-84x62.jpg"
                                        alt="Mark Of the Dragon – Epic Trailer">
                                        <span class="play-icon"></span>
                                    </a>
                                </div>
                                <div class="col-xs-8">
                                    <h5>
                                        <a href="#"><?=$trendkasb['title']?></a></h5>
                                    <div class="widget-meta">
                                        <span><i class="fa fa-eye"></i> <?=$trendkasb['n']?></span>
                                        <span><i class="fa fa-comment "></i> 4</span>
                                        <span class="fa fa-vimeo"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?}?>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</div>
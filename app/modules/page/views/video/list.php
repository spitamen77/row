<div class="row-container row-container-1 inside   bg-color">
    <div class="container">
        <br>
    </div>
    <div class="container">
        <div class="row sidebar-on-left">
            <div class="col-md-3 ">
                <div class="row">
                    <div class="jw-title-container"><h2 class="jw-title jw-title-5271">Kurs xaqida</h2></div>
                    <nav class="navbar navbar-default sidebar">

                        <ul class="nav nav-stacked">
                            <li class="active"><a href="#">Kurs nomi: <?=$course->title?></a></li>
                            <li><a href="#">Kasblar</a></li>
                            <li><a href="#">Mualliflar</a></li>
                            <li><a href="#">Tez tez beriladigan savollar</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-md-9 ">

                <div class="row">
                    <div class="jw-element   jw-animate-gen animated fadeIn" data-gen="fadeIn" data-gen-offset="100%"
                         style="">
                        <div class="jw-title-container"><h2 class="jw-title jw-title-5271">Videolar</h2></div>
                        <?$i=1;foreach ($videos as $video) {
                        if ($i==7) break;
                        $i++;
                        ?>
                        
                    <div class="col-md-4 col-sm-6 col-xs-12 video-box-holder video-list  grid-size-4">
                        <div class="">
                            <div class="video-image-holder ">
                                <div class="top-shadow">
                                    <span><?=$video->publish?></span>
                                    <span class="fa fa-vimeo"><?=$video->user->username?></span>
                                    <span><i class="fa fa-eye"></i><?=$video->view?></span>
                                </div>
                                <img class="video-aq-thumb" <?=($video->img)?$video->img:$video->tmpimg?>" alt="<?=$video->title?>">
                                <span class="play-icon quick-play play-small-icon" data-video_id="986"></span>
                                <a href="<?=$this->to('page/video/view').$video->id?>"
                                   class="video-quickply html5lightbox" data-videoid="22611216"></a>
                            </div>
                            <div class="video-meta-holder ">
                                <div class="row">
                                    <h3>
                                        <a href="<?=$this->to('page/video/view/').$video->id?>"><?=$video->title?></a></h3>
                                    <div class="author-name">
                                        F.I.SH.
                                        <span><a href="#"
                                                 title="<?=$video->user->makeFIO()?>"><?=$video->user->makeFIO()?></a></span>
                                    </div>
                                    
                                    <div class="meta-right ">
                                        <span>Publish:<?=$video->publish?></span> / 
                                        <span>Views:<?=$video->view?></span>
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
    </div>
</div>
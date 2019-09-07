<?

use app\components\widgets\VideoJs;
?>
<br>
<div class="container single-content-area">
    <div class="row right-sidebar">
        <div class="col-md-9 col-sm-12 col-xs-12">
            <!-- Video Detail Start -->
            <div class="video-play video-play-single fixed-play" style="min-height: 295px;">
                <div class="video-close">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </div>
                <div class="fluid-width-video-wrapper2">
                    <div class="fluid-width-video-wrapper">
                        <?=VideoJs::widget([
                            'options' => [
                                'class' => 'video-js vjs-default-skin vjs-big-play-centered',
                                'poster' => "http://www.kasb.uz/img/poster.jpg",
                                'controls' => true,
                                'preload' => 'auto',
                                'width' => '500px',
                                'height' => '300px ',
                            ],
                            'tags' => [
                                'source' => [
                                    ['src' => $video->source_file, 'type' => 'video/mp4'],
                                ],
                            ]
                        ])?>
                        <!-- <iframe src="#$video->source_file"
                                frameborder="0" allowfullscreen="" id="fitvid0"></iframe> -->
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="post-category-holder">
                <div class="cate-link">
                </div>
                <div class="single-post-author">
                    <span class="meta-author">
                        <img width="25px;" height="25px;" src="<?=$video->user->avatar?>" alt="Video yuklovchi rasmi">
                        <a href="#">
                        F.I.SH.: <?=$video->user->makeFIO()?></a>
                    </span>
                </div>
                <div class="aclearfix"></div>
            </div>
            <div class="single-meta clearfix">
                <h2> <?=$video->title?></h2>
            </div>
            <div class="clearfix"></div>
                <div class="single-video-content">
                    <div class="meta-more">
                        <span class="meta-date">
                        <i class="fa fa-calendar"></i> <?=$video->publish?>                    </span>
                        <span><i class="fa fa-eye"></i> <?=$video->view?></span>
                        <span><i class="fa fa-thumbs-up"></i> <?=$video->like?></span>
                        <span><i class="fa fa-comments"></i> <?=$video->view?> </span>
                        <span><i class="fa fa-vimeo"></i> </span>
                        <span class="share-this">Do'stlaringiz bilan ulashing <i class="fa fa-share-alt"></i> </span>
                    </div>
                    <div class="social-share">
                        <section>
                            <div class="social-share-holder">
                                <div class="facebook">
                                    <a href="#">
                                    <span><i class="fa fa-facebook"></i></span></a>
                                </div>
                            </div>
                            <div class="social-share-holder">
                                <div class="twitter">
                                    <a href="#"><span><i
                                        class="fa fa-twitter"></i></span></a>
                                </div>
                            </div>
                            <div class="social-share-holder">
                                <div class="instagram">
                                    <a href="#"><span><i class="fa fa-pinterest"></i></span></a></div>
                            </div>
                            <div class="social-share-holder">
                                <div class="google"><a href="#"><span><i
                                        class="fa fa-google-plus"></i></span></a></div>
                            </div>

                            <div class="social-share-holder">
                                <div class="linkedin"><a href="#"><span><i
                                        class="fa fa-linkedin"></i></span></a></div>
                            </div>
                            <div class="clearfix"></div>
                        </section>
                    </div>
                    <div class="clearfix"></div>
                    <div class="video-content">
                        <?=$video->description?>

                        <div class="clearfix"></div>
                        <div class="comments-form-holder">
                            <div id="comments">

                        <?=app\modules\comments\widgets\Comment::widget([
                            'model' => $video,
                        ]); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                    <!-- Video Detail End -->
            </div>

        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="row">
                <section id="sidebar" style="height: 4300px;">
                    <aside class="widget widget_media_image" id="media_image-3"
                    <img width="267" height="250" src="img/ban-250x250.jpg" class="image wp-image-1438  attachment-full size-full" alt="" style="max-width: 100%; height: auto;">
                    </aside>
                    <aside class="widget widget_video_list_widget" id="video_list_widget-5">
                        <h2 class="widget-title">Top videolar<span class="widtbor"></span></h2>
                         <?$i=1;foreach ($mostviews as $mostview) {
                            //print_r($mostview);exit;
                        if($i==5) break;?>
                        <div class="widget-video-list">
                            <div class="row">
                                <div class="col-xs-4">
                                    <a href="<?=$this->to('page/video/view/').$mostview->id?>">
                                        <img src="<?=$mostview->tmpimg?>"
                 alt="<?=$mostview->title?>">
                                    </a>
                                </div>
                                <div class="col-xs-8">
                                    <h5>
                                        <a href="<?=$this->to('page/video/view/').$mostview->id?>"><?=$mostview->title?></a>
                                    </h5>
                                    <div class="widget-meta">
                                        <span class="fa fa-calendar"> <?=$mostview->publish?></span>
                                        <span><i class="fa fa-eye"></i> <?=$mostview->view?></span>
                                        <span><i class="fa fa-comment "></i> <?=($mostview::countVideoComment($mostview->id))?$mostview::countVideoComment($mostview->id):0?></span>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?$i++;}?>
                    </aside>
                    <aside class="widget widget_video_list_widget" id="video_list_widget-4">
                        <h2 class="widget-title">Trend kasblar<span class="widtbor"></span></h2>
                        <?$i=0;foreach ($trendkasblar as $trendkasb) {
                    $i++; if($i==4) break;
                    ?>
                        <div class="widget-video-list">
                            <div class="row">
                                <div class="col-xs-4">
                                    <a href="http://kamyab.tv/mytube/video/nightmare-malaria-game-teaser/">
                                        <img src="/themes/kasb/img/dance-party-265x212.jpg"
                                             alt="<?=$trendkasb['title']?>">
                                         </a>
                                </div>
                                <div class="col-xs-8">
                                    <h5><a href="<?=$this->to('page/profession/view/').$trendkasb['id']?>"><?=$trendkasb['title']?></a></h5>
                                    <div class="widget-meta">
                                        <span class="fa fa-calendar">  <?=date('Y-m-d',$trendkasb['created_date'])?></span>
                                        <span><i class="fa fa-eye"></i> <?=$trendkasb['n']?></span>
                                        <span><i class="fa fa-comment "></i> 0</span>
                                        
                                    </div>
                                </div>
                            </div>
                        </div><?}?>
                    </aside>
                </section>
            </div>
        </div>
    </div>
</div><!--container-->
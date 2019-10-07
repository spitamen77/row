<?php
use app\models\maxpirali\Menu;
use app\models\maxpirali\MenuItem;
use yii\helpers\Url;
use app\models\Lang;
?>
<!-- Footer ______________________________ -->
<footer>
    <div class="top-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 footer-about">
                    <h4><?=Lang::t('About us')?></h4>
                    <p>EDUTECH Mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the sys- tem, and expound the actual teachings of the great explorer</p>
                    <a href="<?=Url::to('/site/about')?>" class="tran3s"><i class="fa fa-caret-right" aria-hidden="true"></i> <?=Lang::t('About us')?></a>
<!--                    <a href="our-teacher.html" class="tran3s"><i class="fa fa-caret-right" aria-hidden="true"></i> Team Member</a>-->
                    <ul>
                        <li><a href="https://www.facebook.com/groups/934843233533389/" target="_blank" class="tran3s round-border icon"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                       
                        <li><a href="https://t.me/outcometree" target="_blank" class="tran3s round-border icon" title="Telegram"><i class="fa fa-paper-plane" aria-hidden="true"></i></a></li>
                        <li><a href="http://websar.uz" target="_blank" class="tran3s round-border icon" title="Sayt yaratuvchi"><i class="fa fa-copyright" aria-hidden="true"></i></a></li>
                    </ul>
                </div> <!-- /.footer-about -->

                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12 footer-quick-link">
                    <h4><?=Lang::t('Quick link')?></h4>
                    <ul>
                        <?php PrintMenu2(Menu::menus()); ?>
                        <li><a href="<?=Url::to('/site/teachers')?>"><i class="fa fa-caret-right" aria-hidden="true"></i>
                                <?=Lang::t('Teachers')?></a>
                        </li>
                    </ul>
                </div> <!-- /.footer-quick-link -->

                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 footer-event">
                    <h4><?=Lang::t('Latest events')?></h4>

                    <div id="footer-event-carousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#footer-event-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#footer-event-carousel" data-slide-to="1"></li>
                            <li data-target="#footer-event-carousel" data-slide-to="2"></li>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <ul>
                                    <?php foreach (MenuItem::getXits(10,11,3) as $items) :?>
                                    <li>
                                        <div class="date p-color-bg"><?=date("j",$items->created_date)?> <span><?=date("M",$items->created_date)?></span></div>
                                        <a href="<?=Url::to('/?slug='.$items->template->slug.'&item_slug='.$items->slug)?>"><h6><?=$items->title?></h6></a>
                                        <ul>
                                            <li><i class="fa fa-clock-o" aria-hidden="true"></i> <?=$items->time?></li>
<!--                                            <li><i class="fa fa-tags" aria-hidden="true"></i> Gpur Academy</li>-->
                                        </ul>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div> <!-- /.item -->

                            <div class="item">
                                <ul>
                                    <?php foreach (MenuItem::getXits(11,12,3) as $items) :?>
                                        <li>
                                            <div class="date p-color-bg"><?=date("j",$items->created_date)?> <span><?=date("M",$items->created_date)?></span></div>
                                            <a href="<?=Url::to('/?slug='.$items->template->slug.'&item_slug='.$items->slug)?>"><h6><?=$items->title?></h6></a>
                                            <ul>
                                                <li><i class="fa fa-clock-o" aria-hidden="true"></i> <?=$items->time?></li>
                                                <!--                                            <li><i class="fa fa-tags" aria-hidden="true"></i> Gpur Academy</li>-->
                                            </ul>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div> <!-- /.item -->

                            <div class="item">
                                <ul>
                                    <?php foreach (MenuItem::getXits(10,12,3) as $items) :?>
                                        <li>
                                            <div class="date p-color-bg"><?=date("j",$items->created_date)?> <span><?=date("M",$items->created_date)?></span></div>
                                            <a href="<?=Url::to('/?slug='.$items->template->slug.'&item_slug='.$items->slug)?>"><h6><?=$items->title?></h6></a>
                                            <ul>
                                                <li><i class="fa fa-clock-o" aria-hidden="true"></i> <?=$items->time?></li>
                                                <!--                                            <li><i class="fa fa-tags" aria-hidden="true"></i> Gpur Academy</li>-->
                                            </ul>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div> <!-- /.item -->
                        </div>
                    </div> <!-- /#footer-event-carousel -->
                </div> <!-- /.footer-event -->

                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 footer-contact">
                    <h4><?=Lang::t('Contact us')?></h4>
                    <ul>
                        <li>
                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                            <a href="mailto:<?=Lang::t('emailto')?>" class="tran3s"><?=Lang::t('emailto')?></a>
                        </li>
                        <li>
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <a href="tel:<?=Lang::t('telefon')?>" class="tran3s"><?=Lang::t('telefon')?></a>
                        </li>
                        <li><i class="fa fa-map-marker" aria-hidden="true"></i><?=Lang::t('Address')?></li>
                    </ul>
                </div> <!-- /.footer-contact -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </div> <!-- /.top-footer -->

   
</footer>

<!-- Scroll Top Button -->
<button class="scroll-top tran3s p-color-bg">
    <i class="fa fa-angle-up" aria-hidden="true"></i>
</button>
<!-- pre loader  -->
<div id="loader-wrapper">
    <div id="loader"></div>
</div>
<?php function PrintMenu2($menu){ ?>
    <? foreach ($menu as $value) { ?>
        <li><a href="<?=Url::to(['site/index', 'slug' => $value['slug']])?>"><i class="fa fa-caret-right" aria-hidden="true"></i>
            <?=$value['title']?></a>
            <?// if ($value['children']) { ?>
                <!-- <ul class="sub-menu"> -->
                    <? //PrintMenu($value['children']); ?>
                <!-- </ul> -->
            <?//} ?>
        </li>
        <? } ?>  
   <? }?>
   <script>
window.replainSettings = { id: '5da0916d-0c87-4369-8595-7f2bab0612f7' };
(function(u){var s=document.createElement('script');s.type='text/javascript';s.async=true;s.src=u;
var x=document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);
})('https://widget.replain.cc/dist/client.js');
</script>
<?php
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



			<!-- Blog V2 __________________________ -->
			<div class="blog-v2">
				<div class="container">
					<div class="row">
						
						<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
							<div class="row latest-news blog-v1">
								<?php foreach ($model as $value) :?>
								<div class="single-post wow fadeInUp col-lg-6 col-md-6 col-sm-6 col-xs-6">
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
		        				<?php endforeach; ?>
		        				<?= LinkPager::widget([
								    'pagination' => $pages,
								]);?>
							</div>
						</div>
						<!-- _______________ SideBar ___________________ -->
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sidebarOne">
	        				<div class="wrapper-left">

	        					<div class="sidebar-box talent-teacher">
	        						<div class="box-wrapper">
	        							<h4><?=Lang::t('Talent teacher')?></h4>
	        							
	        							<div id="talent-teacher-carousel" class="carousel slide" data-ride="carousel">
										  	  <!-- Indicators -->
											  <ol class="carousel-indicators">
											    <li data-target="#talent-teacher-carousel" data-slide-to="0" class="active"></li>
											    <li data-target="#talent-teacher-carousel" data-slide-to="1"></li>
											    <li data-target="#talent-teacher-carousel" data-slide-to="2"></li>
											  </ol>

											  <!-- Wrapper for slides -->
											<div class="carousel-inner" role="listbox">
											    <?php foreach ($teacher as $key => $tech) :?>
											    <div class="item <?=($key==0)?'active':''?>">
											      <img src="<?=$tech->photo?>" alt="<?=$tech->name?>">
											      <h6><?=$tech->name?></h6>

											      <ul class="organize-list">
                                                      <li><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?=$tech->fan?></li>
                                                      <li><i class="fa fa-envelope-o" aria-hidden="true"></i> <?=$tech->email?></li>
                                                      <li><i class="fa fa-phone" aria-hidden="true"></i> <?=$tech->phone?></li>
                                                       <li><i class="fa fa-facebook" aria-hidden="true"></i> <?=$tech->facebook?></li>
				        							</ul>

													<a href="<?=Url::to('/site/teacher?id='.$tech->id)?>" class="theme-bg-color view-profile tran3s"><?=Lang::t('View Profile')?></a>
											    </div> <!-- /.item -->
												<?php endforeach;?>   
											</div>
										</div> <!-- /#talent-teacher-carousel -->
	        						</div> <!-- /.box-wrapper -->
	        					</div> <!-- /.sidebar-box.talent-teacher -->

                                <div class="sidebar-box feature-event feature-course-sidebar">
                                    <div class="box-wrapper">
                                        <h4><?=Lang::t('Featured courses')?></h4>
                                        <?php foreach ($kurs as $zurs) :?>
                                            <div class="single-event clear-fix">
                                                <div class="date float-left p-color-bg">
                                                    <?=date("j",$zurs->created_date)?> <span><?=date("M",$zurs->created_date)?></span>
                                                </div> <!-- /.date -->
                                                <div class="post float-left">
                                                    <a href="<?=Url::to('/?slug='.$zurs->template->slug.'&item_slug='.$zurs->slug)?>" class="tran3s"><?=$zurs->translate->title?></a>
                                                    <ul>
                                                        <li><i class="fa fa-eye" aria-hidden="true"></i> <?=$zurs->views?></li>
                                                        <li><a ><?=number_format($zurs->price, 0, ',', ' ')?> сум</a></li>
                                                    </ul>
                                                </div> <!-- /.post -->
                                            </div> <!-- /.single-event -->
                                        <?php endforeach; ?>
                                    </div> <!-- /.box-wrapper -->
                                </div> <!-- /.sidebar-box.feature-event.feature-course-sidebar -->

	        					<div class="sidebar-box feature-event">
	        						<div class="box-wrapper">
	        							<h4><?=Lang::t('Latest news')?></h4>
	        							<?php foreach ($news as $item) : ?>
	        							<div class="single-event clear-fix">
	        								<div class="date float-left p-color-bg">
	        									<?=date("j",$item->created_date)?> <span><?=date("M",$item->created_date)?></span>
	        								</div> <!-- /.date -->
	        								<div class="post float-left">
	        									<a href="<?=Url::to('/?slug='.$item->template->slug.'&item_slug='.$item->slug)?>" class="tran3s"><?=$item->translate->title?></a>
	        									<ul>
	        										<li><i class="fa fa-eye" aria-hidden="true"></i> <?=$item->views?></li>
	        										<!-- <li><i class="fa fa-tag" aria-hidden="true"></i>Golf Club</li> -->
	        									</ul>
	        								</div> <!-- /.post -->
	        							</div> <!-- /.single-event -->
	        							<?php endforeach; ?>
	        							
	        						</div> <!-- /.box-wrapper -->
	        					</div> <!-- /.sidebar-box.feature-event -->
	        				</div> <!-- /.wrapper -->
	        			</div> <!-- /.sidebarOne -->
					</div>
				</div> <!-- /.container -->
			</div> <!-- /.blog-v2 -->



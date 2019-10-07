<?php
use app\models\Lang;
use yii\helpers\Url;
use yii\helpers\Html;
// echo "<pre>";var_dump($model);
$this->title= $model->translate->title;
$this->params['desc'] = $model->translate->short;
$this->params['img'] = $model->photo;
?>

<!-- Page Breadcrum __________________________ -->
<div class="page-breadcrum">
    <div class="container">
        <ul>
            <li><a href="<?=Url::to('/')?>"><?=Lang::t('Home')?></a></li>
            <li>-</li>
            <li><?=Lang::t('Details')?></li>
        </ul>
    </div> <!-- /.container -->
</div> <!-- /.page-breadcrum -->

<div class="course-details-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="course-details-content clear-fix">
                    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
                        <div class="alert alert-success">
                            <?=Lang::t('Thank you for contacting us. We will respond to you as soon as possible')?>.
                        </div>

                        <p>

                        </p>
                    <?php endif; ?>
                    <div class="img">
                        <img src="<?=$model->photo?>" alt="Image">
                        <span class="p-color-bg"><?=number_format($model->price, 0, ',', ' ')?> сум</span>
                    </div>
                    <h3><?=$model->translate->title?></h3>

                    <ul class="post-info">
                        <li><i class="fa fa-calendar" aria-hidden="true"></i><?=date("j-m-Y",$model->created_date)?></li>
                        <!-- <li><i class="fa fa-tags" aria-hidden="true"></i> School Language</li> -->
                        <!-- <li><i class="fa fa-user" aria-hidden="true"></i> Mahfuz Riad</li> -->
                        <li><i class="fa fa-eye" aria-hidden="true"></i> <?=$model->views?></li>
                    </ul>

                    <div class="sub-text">
                        <?=$model->translate->text?>
                    </div> <!-- /.sub-text -->
                    <div class="sub-text course-instructor">
                        <h4><?=Lang::t('INSTRUCTOR')?></h4>

                        <div class="single-box-content clear-fix">
                            <div class="item float-left">
                                <div class="theme-bg-color">
                                    <div class="img-holder round-border"><img src="<?=$model->teacher->photo?>" alt="<?=$model->teacher->name?>"></div>
                                    <span><?=$model->teacher->name?></span>

                                    <p><?=$model->teacher->fan?></p>

                                    <ul class="contact-list">
                                        <li><i class="fa fa-phone" aria-hidden="true"></i> <?=$model->teacher->phone?></li>
                                        <li><i class="fa fa-envelope-o" aria-hidden="true"></i> <?=$model->teacher->email?></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item float-left">
                                <div class="table-wrapper">
                                    <table>
                                        <tr>
                                            <td><i class="fa fa-buysellads" aria-hidden="true"></i></td>
                                            <td>Lectures</td>
                                            <td><?=$model->sale?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-calendar" aria-hidden="true"></i></td>
                                            <td><?=Lang::t('Start date')?></td>
                                            <td><?=$model->time?></td>
                                        </tr>

                                        <tr>
                                            <td><i class="fa fa-check-square" aria-hidden="true"></i></td>
                                            <td><?=Lang::t('Format')?></td>
                                            <td><?=Lang::t('Live')?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-money" aria-hidden="true"></i></td>
                                            <td><?=Lang::t('Price')?></td>
                                            <td><?=number_format($model->price, 0, ',', ' ')?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-file" aria-hidden="true"></i></td>
                                            <td><?=Lang::t('File')?></td>
                                            <td><a href="/web/<?=$model->file?>" target="_blank"><?=($model->file!=null)?Lang::t('Download'):Lang::t('No file')?></a> </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                            <div class=" float-right">
                                <div class="float-right ya-share2" data-services="facebook,twitter,telegram"></div>
                            </div> <!-- /.sub-text -->
                        </div> <!-- /.single-box-content -->

                    </div> <!-- /.sub-text -->



                    <hr>
                    <a href="#" type="button" data-toggle="modal" data-target="#exampleModal" class="take-course-button tran3s"><?=Lang::t('Take this course')?></a>
                </div> <!-- /.course-details-content -->
            </div> <!-- /.col- -->

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><?=Lang::t('Take this course')?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="w0" action="/site/zayavka" method="post">
                                <?=Html::hiddenInput(Yii::$app->getRequest()->csrfParam, Yii::$app->getRequest()->getCsrfToken(), []);?>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group field-contactform-name required">

                                            <input type="text" id="contactform-name" class="form-control" name="Zayavka[name]" placeholder="<?=Lang::t('Name')?>" aria-required="true">

                                            <p class="help-block help-block-error"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group field-contactform-email required">

                                            <input type="text" pattern="[8-9]{3}[0-9]{9}" maxlength="12" id="contactform-email" class="form-control" value="998" name="Zayavka[phone]" placeholder="998YYXXXXXXX" aria-required="true">

                                            <p class="help-block help-block-error"></p>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group field-contactform-body required">

                                            <textarea id="contactform-body" class="form-control" name="Zayavka[message]" rows="6" aria-required="true"></textarea>

                                            <p class="help-block help-block-error"></p>
                                        </div>

                                        <button type="submit" class="btn btn-primary center-block" title="Send"><?=Lang::t('Send')?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
<!--                        <div class="modal-footer">-->
<!--                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
<!--                            <button type="button" class="btn btn-primary">Save changes</button>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>
            <!-- _________________ SideBar _________________ -->
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
                            <?php foreach ($news as $key => $item) : ?>
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
    </div>
</div>


<script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
<script src="https://yastatic.net/share2/share.js"></script>
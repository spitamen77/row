<div class="row-container row-container-1 inside   bg-color"
     style="background-attachment:scroll;background-repeat:repeat;background-position:left top;">
    <div class="container" style="width:inside">
        <div class="row sidebar-on-left">
            <div class="col-md-3 ">
                <div class="row">
                    <nav class="navbar navbar-default sidebar" style="border:none;border-radius:0">
                        <ul class="nav nav-stacked">
                            <li><img src="<?=$model->img?>" alt="<?=$model->title?>"></li>
                            <li class="active"><a href="#">Kasb nomi: <b><?=$model->title?></b></a></li>
                            <li><a href="#">Tez tez beriladigan savollar</a></li>
                            <? if (Uni::$app->access('STD')) {?>
                                <li><a href="<?=$this->to('page/profession/kasbchoose/').$model->id?>">Tanlash</a></li>
                            <?} ?>
                            
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-md-9 ">

                <div class="row">
                    <div class="jw-element   jw-animate-gen animated fadeIn" data-gen="fadeIn" data-gen-offset="100%"
                         style="">
                        <div class="jw-title-container"><h2 class="jw-title jw-title-5271">Kasb haqida</h2></div>
                        <div class="col-md-5">
                            <p>Nomi:<br><?= $model->title ?></p>
                            <p>Soha:<br><?= $model->speciality->title ?></p>
                            <p>Oquvchilar: 0</p>
                        </div>
                        <div class="col-md-7">
                            <p>Qisqacha:<br><?= $model->short ?></p>
                            <p>To'liq ma'lumot:<br><?= $model->description ?></p>
                            <p>Yaratilgan sana:<br><?= $model->created_date ?></p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="jw-element   jw-animate-gen animated fadeIn" data-gen="fadeIn" data-gen-offset="100%"
                         style="">
                        <div class="jw-title-container"><h2 class="jw-title jw-title-8407">Fanlar</h2></div>
                        <div class="col-md-12 col-sm-12 col-xs-12 video-box-holder video-list  grid-size-12">

                            <div class="row">
                                <? foreach ($model->attached as $cours) { ?>
                                    <div class="col-md-6 col-sm-12 col-xs-12 no-right-padding">
                                        <a href="<?=$this->to('page/subject/course/').$cours->subject->id?>"><?=$cours->subject->title?></a>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
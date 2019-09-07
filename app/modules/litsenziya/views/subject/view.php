<div class="row-container row-container-1 inside   bg-color">
    <div class="container">
        <br>
    </div>
    <div class="container">
        <div class="row sidebar-on-left">
            <div class="col-md-3 ">
                <div class="row">
                    <nav class="navbar navbar-default sidebar" style="border:none;border-radius:0">
                        <ul class="nav nav-stacked">
                            <li class="active"><b>Nomi: </b><?= $subject->title ?></li>
                            <li><b>Kategoriya: </b><?= $subject->category->title ?></li>
                            <li><b>Soha: </b><?= $subject->speciality->title ?></li>
                            <li><b>Yo'nalish: </b><?= $subject->direction->title ?></li>
                            <li><b>Qisqacha ma'lumot:</b><br><?= $subject->short ?></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-md-9 ">
                <div class="row">
                    <div class="jw-element   jw-animate-gen animated fadeIn">
                        <div class="jw-title-container">
                            <h2 class="jw-title jw-title-8407">Fanga kiritilgan kurslar</h2>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                        
                        <? if($courseCount>0){
                        foreach ($courses as $cours) { ?>
                            <div class="media list">
                              <div class="media-left media-middle  col-md-2">
                                <a href="#" class="media-object">
                                  <img  src="<?=($cours->image) ? $cours->image : '/themes/extra/img/banner.jpg'; ?>" alt="...">
                                </a>
                              </div>
                              <div class="media-body col-md-9" style="margin-left: 20px;">
                                <h4 class="media-heading"><a href="<?=$this->to('page/course/view/').$cours->id?>"><?=$cours->title?></a></h4>
                                 <?=$cours->short?><br>
                                 <span class="fa fa-calendar" style="color: #428C99;font-size: 18px;"></span> <?=$cours->create_date?> / <?=($cours->kasb)?$cours->kasb->title:Uni::t('app','Not Found')?> / status
                              </div>
                            </div>
                            <? }} ?>        
            </div>
        </div>
    </div>
</div>
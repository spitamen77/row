
<!-- UI - X Starts -->
<div class="ui-139">
    <div class="container">
        <div class="alert alert-info" role="alert">
            <? if ($message=="hasKasb") {
                echo "Bu kasbni oldin tanlagansiz !!!"; 
            }else{
                echo "Bu kasbni yangi tanlagansiz !!!"; 
            } ?>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <!-- Item -->
                <div class="ui-item">
                            <!-- Heading -->
                            <div class="ui-heading clearfix">
                                <!-- Main Heading -->
                                <h2><a href="#"><?= $model->title ?></a></h2>
                                <!-- Price -->
                                <h3 class="blue"><span></span>24<span> Fanlar</span></h3>
                            </div>
                            <!-- Border -->
                            <div class="ui-border bg-red"></div>
                            <!-- Paragraph -->
                            <p><?= $model->short ?></p>
                            <!-- Listing Starts -->
                            <!-- Heading -->
                            <h4>O'rganiladigan fanlar</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-6 col-mob">
                                    <!-- Unordered Listing -->
                                    <ul>
                                        <?$i=0; foreach ($model->attached as $cours) { $i++; 
                                            if($i==19){ $i=0; ?>
                                            </ul></div>
                                            <div class="col-md-6 col-sm-12 col-xs-6 col-mob">
                                            <!-- Unordered Listing -->
                                            <ul>
                                            <?}?>
                                                <a href="<?=$this->to('page/subject/course/').$cours->subject->id?>"><li><span><?=$cours->subject->title?></span> <b>100 ta kurs</b></li></a>
                                            
                                        
                                        <? } ?>
                                        
                                    </ul>
                                </div>
                            </div>
                            <!-- Listing Ends -->
                            <!-- Button -->
                            <a href="#" class="btn btn-info">Kursni davom etish</a> &nbsp; 
                        </div>
            </div>
        </div>
    </div>
</div>


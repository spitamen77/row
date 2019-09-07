<?php
use app\components\manager\Url;
use app\models\Notification;

\app\components\widgets\SweetAlertAsset::register($this);
\app\assets\PortfolioAsset::register($this);

?>
  <br>
  <br>
<div class="container" id="main">
    
    <div class="row">
      
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div id="content">
          <!-- start:main content -->
          <div class="main-content">
            <ul class="timeline">
                                <!-- start:resume -->
                  <li id="id-resume">
                    <div class="timeline-badge default"><i class="fa fa-file"></i></div>
                    <h1 class="timeline-head">Xabarlar</h1>
                  </li>
                  <li id="resume">
                      <div class="timeline-badge warning"></div>
                      <div class="timeline-panel">
                        <!-- <h1>Work Experience</h1> -->
                        <div class="hr-left"></div>
                        <? foreach ($data as $val) {?>
                          <div class="work-experience">
                              <h3><?=Notification::$type_names[$val->type]?></h3>
                              <small><i class="fa fa-calendar"></i><?=$val->created_date?></small>
                              <p><a href="<?=$this->to($val->action_page)?>"><?=$val->message?></a></p>
                          </div>
                          <hr> 
                        <?}?>

                          
                      </div>
                  </li>
                  
                  
                  <!-- end:resume -->  
            </ul>
          </div>
          <!-- end:main content -->
        </div>
      </div>
    </div>
  </div>
  <? $this->registerCss('.widget-title{
    background-color: #f4f4f4;
  }')?>

<?php
use yii\helpers\Url;
use app\models\Lang;

$this->title = $menu->title;
$this->params['desc']=$this->title.' - '.$this->title;
?>


<!-- Event Section _______________________ -->
<div class="event-section wow fadeInUp">
    <div class="container">
        <div class="theme-title">
            <h2><?=$menu->title?></h2>
            <!-- <p>Our upcoming event you should mind always</p> -->
        </div>

        <div class="row">
        	<?php foreach ($child as $key => $value) :?>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 wow fadeInUp hvr-float-shadow">
                <div class="single-event theme-bg-color">
                    <!-- <div class="date p-color">25 <span>June</span></div> -->
                    <a href="<?=Url::to('/?slug='.$value->slug)?>"><h6><?=$value->title?></h6></a>
                    
                    
                </div> <!-- /.single-event -->
            </div>
          	<?php endforeach;?>  
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</div> <!-- /.event-section -->

<?php
use yii\helpers\Url;
use app\models\Lang;
$this->title = Lang::t('Search');
$this->params['desc']=$this->title;
?>
<!-- Event Section _______________________ -->
<div class="event-section wow fadeInUp">
    <div class="container">
        <div class="theme-title">
            <h2><?=$this->title?></h2>
            <!-- <p>Our upcoming event you should mind always</p> -->
        </div>

        <div class="row">
        	<?php if ($model):?>
        		<?php foreach ($model as $key => $item):?>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 wow fadeInUp hvr-float-shadow">
                <div class="single-event theme-bg-color">
                    <div class="date p-color"><?=date("j",$item->updated_date)?> <span><?=date("M",$item->updated_date)?></span></div>
                    <a href="<?=Url::to('/?slug='.$item->item->template->slug.'&item_slug='.$item->item->slug)?>"><h6><?=$item->title?></h6></a>
                    <p><?=$item->short?></p>
                   
                </div> <!-- /.single-event -->
            </div>
            	<?php endforeach;?>
           	<?php else: ?>
           	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 wow fadeInUp hvr-float-shadow">
           		<div class="single-event theme-bg-color">
           			<?=Lang::t('Nothing found')?>
           		</div>
           	</div>	
           <?php endif;?>
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</div> <!-- /.event-section -->
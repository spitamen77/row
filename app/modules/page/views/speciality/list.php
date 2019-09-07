<?
use app\components\manager\Url;
$this->registerCss('
.glyphicon { margin-right:5px; }
.thumbnail
{
    margin-bottom: 10px;
    padding: 0px;
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    border-radius: 0px;
}

.item.list-group-item
{
    float: none;
    width: 100%;
    background-color: #fff;
    margin-bottom: 10px;
}
.item.list-group-item:nth-of-type(odd):hover,.item.list-group-item:hover
{
    background: #428bca;
}

.item.list-group-item .list-group-image
{
    margin-right: 10px;
}
.item.list-group-item .thumbnail
{
    margin-bottom: 0px;
}
.item.list-group-item .caption
{
    padding: 9px 9px 0px 9px;
}
.item.list-group-item:nth-of-type(odd)
{
    background: #eeeeee;
}

.item.list-group-item:before, .item.list-group-item:after
{
    display: table;
    content: " ";
}

.item.list-group-item img
{
    float: left;
}
.item.list-group-item:after
{
    clear: both;
}
.list-group-item-text
{
    margin: 0 0 11px;
}
.blog-list-container img{
	max-height:240px;
}

	');
$this->registerJs('$(document).ready(function() {
    $("#list").click(function(event){event.preventDefault();$("#products .item").addClass("list-group-item");});
    $("#grid").click(function(event){event.preventDefault();$("#products .item").removeClass("list-group-item");$("#products .item").addClass("grid-group-item");});
});');
?>
<div class="tab-content">
	<div class="row page-bar main-white-color margin-bottom-0">
	  <div class="container">
	    <div class="col-md-8 col-sm-8 col-xs-12 blog-title">
	      <h1><?=$soha->title?></h1>
	    </div>
	    <div class="col-md-4 blog_crumb">
	        <ul id="breadcrumbs" class="breadcrumbs">
	          <li class="item-home">
	            <a class="bread-link bread-home" href="<?=Url::to('')?>" title="Home"><?=Uni::t('app','Bosh sahifa')?></a>
	          </li>
	          <li class="separator separator-home"> / </li>
	          <li class="item-current item-698">
	            <strong class="bread-current bread-698"> <?=$soha->title?></strong>
	          </li>
	        </ul> 
	    </div>
	  </div>
	</div>
	<br>
	
    <div class="container">
        <div class="col-md-12 btn-group pull-right clearfix" style="margin-bottom:5px;">
            <a href="#" id="list" class="btn btn-default btn-md"><span class="glyphicon glyphicon-th-list">
            </span>Ro'yhat</a>
            <a href="#" id="grid" class="btn btn-default btn-md"><span
                class="glyphicon glyphicon-th"></span>Jadval</a>
        </div>

        <br>
        <div class="row"><hr></div>
        	
	    <div id="products" class="row list-group">
	        <?$i=1;foreach ($kasblar->models as $value) {?>
	        <div class="item  col-xs-2 col-lg-3 col-md-3">
	            <div class="thumbnail blog-list-container"  style="min-height:300px;max-height:300px;">
	                <img class="group list-group-image" src="<?=($value->img)?$value->img:$value->tmpimg?>" alt="" />
	                <div class="caption">
	                    <h4 class="group inner list-group-item-heading">
	                        <?=$value->title?></h4><a href="<?=Url::to('page/profession/view/'.$value->id)?>">Batafsil...</a>
	                    
	                </div>
	            </div>
	        </div>
	        <?}?>
	        
	    </div>
	    <div class="clearfix"></div>
	    <?
				$kasblar->pagination->pageSize =4;
			?>	
			<?= uni\widgets\LinkPager::widget([
                'pagination' => $kasblar->pagination,
                
            ]) ?>
	</div>

</div>
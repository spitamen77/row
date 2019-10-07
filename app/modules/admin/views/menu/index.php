<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Lang;
/* @var $this yii\web\View */
/* @var $searchModel app\models\dilshod\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Lang::t('Menyu');
// echo "<pre>";var_dump($dataProvider); exit;
?>
<div class="col-md-8"> 
<div class="menu-index">

    <?php // echo $this->render('_search', ->model' => $searchModel]); ?>

    <p>
            <?= Html::a(Lang::t('Menyu yaratish'), ['create'], ['class' => 'btn btn-success']) ?>
        
    </p>
<table class="table table-striped table-bordered">
    <thead>
<tr>
    <th>#</th>
    <th><a data-sort="menu_id"><?=Lang::t('Menyu')?></a></th>
    <th><a data-sort="title"><?=Lang::t("slug")?></a></th>
    <th><a data-sort="tree"><?=Lang::t("Tartib")?></a></th>
    <th><a data-sort="child"><?=Lang::t("Child")?></a></th>
    <th><a data-sort="child"><?=Lang::t("Til")?></a></th>
    <th><a data-sort="short"><?=Lang::t("Amallar")?></a></th>
    
</thead>
<tbody>
<?php $i=0; foreach ($dataProvider as $key => $value) : $i++;?>
<tr data-key="<?=$i?>">
    <td><?=$i?></td>
    <td><?=$value->title?></td>
   
    <td><?=$value->slug?></td>
    <td><?=$value->tree?></td>
    <td><?php 
        if ($value->child==0) echo Lang::t('Main menu');
        else {
            echo Lang::t('Child')." (".$value->getOta($value->child).")";
        }
    ?></td>
    <td><?php foreach ($value->getMenuTrans($value->id) as $key => $item) :?>
            <?php if ($item->lang=="uz-UZ") continue; ?>
           <a class="myModal" href="#" title="<?=$item->title?>" data-id="<?=$item->id?>" til-id="<?=$value->id?>" data-toggle="modal" data-target="#myModal"><?=($item->lang=="ru-RU")?"RU":"EN"?></a>&nbsp;
        <?php endforeach; ?></td>
    <td>
        <a href="#" title="View" aria-label="View" data-id="<?=$value->id?>" data-pjax="0" data-toggle="modal"data-target='#addModal' class="addModal">
            <span class="glyphicon glyphicon-plus"></span></a>
        <a href="view?id=<?=$value->id?>" title="View" aria-label="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a> 
        <a href="update?id=<?=$value->id?>" title="Update" aria-label="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a> 
        <a href="delete?id=<?=$value->id?>" title="Delete" aria-label="Delete" data-pjax="0" data-confirm="Are you sure you want to delete this item?" data-method="post"><span class="glyphicon glyphicon-trash"></span>
        </a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
 <!-- <a href='javascript:history.back()' class='btn btn-danger'>ortga</a> -->
</div>

<!-- Modal update -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?=Lang::t('Til')?></h4>
            </div>
            <div class="modal-body">
                <label data-success="left" for="matn" id="title"></label>
                <input type="text" id="matn" class="form-control validate">
            </div>
            <div class="modal-footer">
                <button type="button" id="til" class="btn btn-success" data-content=""><?=Lang::t('Saqlash')?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=Lang::t('Yopish')?></button>
            </div>
        </div>

    </div>
</div>
<!-- Modal add  -->
<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?=Lang::t('Til')?></h4>
            </div>
            <div class="modal-body">
                <label data-success="left" for="matn" id="title3"></label>
                <select name="tanla" id="tanla" class="form-control validate">
                    <option value="ru-RU" selected>Русский</option>
                    <option value="en-US">English</option>
                </select>
            
                <label data-success="left" for="matn" id="title2"></label>
                <input type="text" id="matn2" class="form-control validate">
            </div>
            <div class="modal-footer">
                <button type="button" id="tilqoshish" class="btn btn-success" data-content=""><?=Lang::t('Saqlash')?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=Lang::t('Yopish')?></button>
            </div>
        </div>

    </div>

</div>
<?php

$this->registerJs('
    //tahrirlashdan oldiin
    $(".myModal").click(function(e){
        var data = $(this).attr("data-id");
        //console.log(data);
        $.get("gettext",{til: data},function(response){
            if(response.result=="success") {
                $("#matn").val(response.matn);
                $("#til").attr("data-content", data);
            }
            else console.log(response.result);
        });
        
    });

    $("#til").click(function(e){
        e.preventDefault();
        var data = $(this).attr("data-content");
        var value = $("#matn").val(); 
//        console.log(data);
        $.get("updatetext",{til: data, val:value},function(response){
            if(response.result=="success") {
            window.location.reload();}
            else console.log(response.result);
        });
        
    });

    // qo`shisdam oldin
    $(".addModal").click(function(e){
        var data = $(this).attr("data-id");
        $("#tilqoshish").attr("data-content", data);
        $("#matn2").val("");
        
    });

    $("#tilqoshish").click(function(e){
        e.preventDefault();
        var data = $(this).attr("data-content");
        var value = $("#matn2").val(); 
        var tanla = $("#tanla").val(); 
        // console.log(value);
        $.get("createtext",{til: data, val:value, select:tanla},function(response){
            switch(response) {
              case "success":
                window.location.reload();
                break;
              case "value":
                alert("'.Lang::t("Qiymat kiritilmagan!").'");
                break;
            case "dublicate":
                alert("'.Lang::t("Dublikat!").'");
                break;
              default:
                // code block
            }
           
        });
        
    });


');

?>

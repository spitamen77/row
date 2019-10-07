<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\dilshod\TextTranslateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use app\models\Lang;
$this->title = Lang::t('Tarjimalar');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-translate-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Lang::t("Yangi so`z qo`shish"), ['create'], ['class' => 'btn btn-success']) ?>
        <a href='javascript:history.back()' class='btn btn-danger'>ortga</a>
    </p>
    
<!-- <div class="col-md-8"> -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'lang',
            'slug',
            'text',
//            'status',
            //'updated_date',
            [
                'label' => Lang::t('Til'),
                'format' => 'raw',
                'value' => function($data){
                 $til = Lang::find()->where(['slug'=>$data->slug, 'status'=>1])->andWhere(['not', ['lang' => 'uz-UZ']])->orderBy(['lang'=>SORT_DESC])->all();
                 $xxx='';
                 foreach ($til as $item){
                     switch ($item->lang){
                         case "ru-RU":
                             $xxx.= Html::a(
                         'RU',
                         "#",
                             [
                                 'title' => 'Русская версия',
                                 'data-id'=>$item->id,
                                 'class'=>'myModal',
                                 'til-id'=>$data->id,
                                 'data-toggle'=>'modal',
                                 'data-target'=>'#myModal'
                             ]
                         )."&nbsp;";
                         break;
                         case "en-US":
                             $xxx.= Html::a(
                                 'EN',
                                 "#",
                                 [
                                     'title' => 'English version',
                                     'data-id'=>$item->id,
                                     'class'=>'myModal',
                                     'til-id'=>$data->id,
                                     'data-toggle'=>'modal',
                                     'data-target'=>'#myModal'
                                 ]
                             )."&nbsp;";
                             break;
                     }
                 }
                 return $xxx;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>Lang::t('Amallar'),
                'headerOptions' => ['width' => '120'],
                'template' => '{link}  {update} {delete}',
                'buttons' => [
                    'link' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-plus"></span>',
                            "#",
                            [
                                'title' => Lang::t('Til qo`shish'),
                                'class'=>'addModal',
                                'data-id'=>$model->slug,
                                'data-toggle'=>'modal',
                                'data-target'=>'#addModal'
                            ]
                            );
                    },

                ],
            ],
        ],
    ]); ?>

<!-- </div> -->
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

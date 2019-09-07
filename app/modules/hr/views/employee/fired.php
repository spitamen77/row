<?
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs("
$('.changestat').click(function(){
    var id=$(this).attr('data-pk');
    $.post('/hr/employee/changestatus/'+id,function(data){
        if(data=='ok'){
        location.reload();
        }
    });
    });

    $('.deletebtn').click(function(){
        var pk=$(this).attr('data-pk');
        var url='/hr/employee/drop/'+pk;
swal({
  title: '".Yii::t('app','Are you sure')."',
  text: '".Yii::t('app','You dont backup this document')."',
  type: 'warning',
  showCancelButton: true,
  confirmButtonClass: 'btn-danger',
  confirmButtonText: '".Yii::t('app','Yes, delete!')."',
  cancelButtonText: '".Yii::t('app','Cancel')."',
  closeOnConfirm: false
},function(){
    $.post(url,{id:pk,_csrf:'".Yii::$app->request->getCsrfToken()."'},function(data){
            if(data=='success'){
                    $('#row_'+pk).remove();
                    swal('".Yii::t('app','Deleted')."', '".Yii::t('app','Information delete')."', 'success');
            }else{
                swal('".Yii::t('app','Not delete')."', '".Yii::t('app','Information not delete')."', 'error');
            }
    });
});});
");
$this->registerJs("
function bindFilterForm(){
$('#filterForm :input').on('change',function(){
    console.log('end1s');
    $(this).closest('form').submit(function () {
    $(this)
        .find('input[name]')
        .filter(function () {
            return !this.value;
        })
        .prop('name', '');
        return true;
});

$(this).submit();
});
}
bindFilterForm();
 $('#filterData').on('pjax:end', function() {
    	console.log('end');
        $.pjax.reload({container:'#listData'});
        bindFilterForm();
    });
");
$this->title = Uni::t('app','Human recources')." | ".Uni::t('app','Employee work out');
$model=new \app\models\SedPersonal();
?>
<?=$this->render('/blocks/top')?>
<div class="panel-body">
    <div class="tab-content">
        <div class="tab-pane fade in active" id="tab1default">
            <div class="row">
                <div class="col-lg-12">
                    <?=$this->render('_filter',['provider'=>$dataProvider,'columns'=>$model->getAttributesWithoutValue()])?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="responsive-table">
                        <?php Pjax::begin(['id' => 'listData']); ?>
                        <table class="table">
                            <thead class="blue">
                            <tr>
                                <th style="width: 50px">№</th>
                                <th style="width: 50px;display: none"><input type="checkbox" id="checkAll"/></th>
                                <th style="width: 70px;"><?=Yii::t('app','Image')?></th>
                                <?if(Yii::$app->controller->access("ADMIN")){?>
                                    <th  style="width: 70px;"><?=Yii::t('app','Login')?></th>
                                <?}?>
                                <th><?=Yii::t('app','FIO')?></th>
                                <th><?=Yii::t('app','Department')?></th>
                                <th><?=Yii::t('app','Position')?></th>
                                <th style="width:150px">Действие</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $i=1;if($dataProvider->models){foreach($dataProvider->models as $model){?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td style="display: none"><input type="checkbox" data-id="<?=$model->per_id?>"/></td>
                                    <td><img class='img-rounded' src='/filemanager/uploads/?module=hr&folder=avatars&file=<?=$model->personal_picture?>&mode=minicon'/></td>
                                    <?if(Yii::$app->controller->access("ADMIN")){?>
                                        <td><?=($model->user)?$model->user->login:""?></td>
                                    <?}?>
                                    <td><?=$model->surename?> <?=$model->name?> <?=$model->middle_name?></td>
                                    <td><? if($model->department){
                                            echo  $model->department->department_name;
                                        }else{
                                            echo Yii::t("app",'Not set');
                                        }?>
                                    </td>
                                    <td><? if($model->positionm){
                                            echo $model->positionm->title;
                                        }else{
                                            echo Yii::t('app','Not set');
                                        }?>
                                    </td>
                                    <td style="width:150px">
                                        <div class="btn-group">
                                            <a href="<?=$this->to("hr/employee/view/".$model->per_id)?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                            <a href="<?=$this->to("hr/employee/edit/general/".$model->per_id)?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                            <button data-pjax=false data-pk='<?=$model->per_id?>'  class=' deletebtn btn btn-danger'><i class='fa fa-trash-o'></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <?$i++;}}else{?>
                                <tr><td colspan="10"><?=Yii::t('app','No data found!')?></td></tr>
                            <?}?>

                            </tbody>
                        </table>
                        <?=\yii\widgets\LinkPager::widget([
                            'pagination'=>$dataProvider->pagination,
                        ]);?>
                        <? Pjax::end()?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
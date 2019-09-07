<?
use kartik\grid\GridView;
use uni\helpers\Html;
use uni\helpers\ArrayHelper;
use uni\widgets\Pjax;
//use Uni;
\app\components\widgets\SweetAlertAsset::register($this);
//$model=new \app\models\SedPersonal();
$this->title = Uni::t('app','Human recources')." | ".Uni::t('app','All employees');
?>

<?=Uni::$app->controller->renderPartial("/default/menu")?>

<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-1-1 uk-row-first">
                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-hover uk-table-align-vertical">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th><?=Uni::t('app','Image')?></th>
                                <th><?=Uni::t('app','Email')?></th>
                                <th><?=Uni::t('app','User')?></th>
                                 <? if (Uni::$app->controller->access('HEAD')||Uni::$app->controller->access('ADMIN')) {?>
                                    <th><?=Uni::t('app','Region')?></th>
                                    <th><?=Uni::t('app','Town')?></th>
                                <?} if (Uni::$app->controller->access('ADMIN_VIL')) {?>
                                    <th><?=Uni::t('app','Town')?></th>
                                <?} ?>
                                <th><?=Uni::t('app','Hudud')?></th>
                                <!-- <th><?#=Uni::t('app','Phone')?></th> -->
                                <th><?=Uni::t('app','Created date')?></th>
                                <!-- <th><?=Uni::t('app','Role')?></th> -->
                                <th><?=Uni::t('app','Action')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; foreach ($data->models as $model) : $i++;?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><img class="img_thumb" src="/themes/ui/assets/img/ecommerce/s6_edge_1.jpg" alt=""></td>
                                    <td class="uk-text-large uk-text-nowrap"><?=($model->user)?$model->user->email:Uni::t('app','Not defined')?></td>
                                    <td class="uk-text-large uk-text-nowrap"><?=$model->makeFIO()?></td>
                                    <? if (Uni::$app->controller->access('HEAD')||Uni::$app->controller->access('ADMIN')) {?>
                                        <td class="uk-text-nowrap"><?=($model->viloyat)?$model->viloyat->name:Uni::t('app','Viloyat not found')?></td>
                                        <td class="uk-text-nowrap"><?=($model->tuman)?$model->tuman->name:Uni::t('app','Tuman not found')?></td>
                                    <?} if (Uni::$app->controller->access('ADMIN_VIL')) {?>
                                        <td class="uk-text-nowrap"><?=($model->tuman)?$model->tuman->name:Uni::t('app','Tuman not found')?></td>
                                    <?} ?>
                                    <td class="uk-text-nowrap"><?=$model->getHududList()?></td>
                                    <td class="uk-text-nowrap"><?=date('d-m-Y',$model->created_at)?></td>
                                    <!-- <td><?#=($model->user->roles)?$model->user->roles->groupp:Uni::t('app','Role not attached')?></td> -->
                                    <td class="uk-text-nowrap">
                                        <a href="#"><i class="material-icons md-24"></i></a>
                                        <!-- <a href="#"><i class="material-icons md-24 changestat"></i></a> -->
                                        <a href="<?=$this::to('hr/employee/edit/'.$model->per_id)?>"><i class="material-icons md-24">edit</i></a>
                                        <a href="#" data-id="<?=$model->per_id?>" class="changestat"><i class="material-icons md-24">replay</i></a>
                                    </td>
                                </tr>
                            <? endforeach; ?>
                            
                        </tbody>
                    </table>
                </div>
                
                <?= uni\widgets\LinkPager::widget([
                    'pagination' => $data->pagination
                ]) ?>
            </div>
        </div>
    </div>
</div>
<?
$this->registerJs("
$('.changestat').click(function(){
    var id=$(this).attr('data-id');
    $.post('/hr/employee/changestatus/'+id,function(data){
        
        if(data=='ok')
        window.location.reload();
        
        
    });
    

    });
");
?>
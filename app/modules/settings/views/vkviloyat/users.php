<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\helpers\ArrayHelper;
$this->title = Uni::t('app','Users list');
\app\components\widgets\SweetAlertAsset::register($this);
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
$v = \app\models\Viloyat::findOne(Uni::$app->getUser()->identity->viloyat_id);
?>
<div class="md-card">
    <div class="md-card-toolbar"><p></p>
    <h3><?=$v->name_uz?>: <?=$this->title?></h3>
</div>
    <div class="md-card-content">
        <div class="uk-overflow-container">
            <table class="uk-table uk-table-nowrap table_check">
                <thead>

                <tr>
                    <th class="uk-width-1-10 uk-text-center small_col">
                        <input type="checkbox" data-md-icheck class="check_all"></th>

                    <th class="uk-width-2-10"><?=Uni::t('app','FIO')?></th>
                    <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app','Created')?></th>
                    <th class="uk-width-1-10 uk-text-left"><?=Uni::t('app','Phone')?></th>
                    <th class="uk-width-2-10 uk-text-left"><?=Uni::t('app','role')?></th>
                    <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app','Status')?></th>
                    <th class="uk-width-2-10 uk-text-center"><?=Uni::t('app','Actions')?></th>
                </tr>
                </thead>
                <tbody>
                
                <?php foreach ($dataProvider->models as $model) {?>
                    <tr id="row_<?=$model->id ?>">
                        <td class="uk-text-center uk-table-middle small_col">
                            <input type="checkbox" data-md-icheck class="check_row"/>
                        </td>
                        <td><?=$model->username?> <?=$model->middlename?> <?=$model->lastname?></td>
                        <td class="uk-text-center"><?=date('d-m-Y',$model->created)?></td>
                        <td class="uk-text-left"><?=$model->phone?></td>
                        <td class="uk-text-left"><?=$model->roles->title?></td>
                        <td class="uk-text-center">
                        <a class="modal-edit-status" >
                                <i data-id="<?=$model->id?>" class="md-icon material-icons uk-text-primary chstatus"><?=($model->status==1)?"&#xE834;":"&#xE835;"?></i>
                            </a>
                        </td>
                        <td class="uk-text-center">
                            <a href="<?#=$this->to('cpanel/users/edit/'.$model->id)?>"><i class="md-icon material-icons uk-text-primary">&#xE254;</i></a>
                            <a href="<?#=$this->to('reference/users/view/'.$model->id)?>"><i class="md-icon material-icons uk-text-primary">&#xE417;</i></a>
                            <a class="modal-delete-direction" type="button" data-id="<?=$model->id ?>" data-uk-modal="{target:'#modal_delete'}"><i
                                        class="md-icon material-icons uk-text-danger">&#xE5CD;</i></a>
                        </td>
                    </tr>
                <?}?>
                </tbody>
            </table>
        </div>

        <?= uni\widgets\LinkPager::widget([
            'pagination' => $dataProvider->pagination
        ]) ?>

    </div>
</div>
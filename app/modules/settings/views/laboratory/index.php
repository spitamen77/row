<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\helpers\ArrayHelper;
$this->title = Uni::t('app','Diagnose list');
\app\components\widgets\SweetAlertAsset::register($this);
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
?>
<div class="md-card">
    <div class="md-card-toolbar"><p></p>
    <h3><?=$this->title?></h3>
</div>
    <div class="md-card-content">
        <div class="uk-overflow-container">
            <table class="uk-table uk-table-nowrap table_check">
                <thead>

                <tr>
                    <th class="uk-width-1-10 uk-text-center small_col">
                        <input type="checkbox" data-md-icheck class="check_all"></th>

                    <th class="uk-width-2-10"><?=Uni::t('app','Kasal nomi')?></th>
                    <th class="uk-width-1-10 uk-text-left"><?=Uni::t('app','Kasal darajasi')?></th>
                    <th class="uk-width-1-10 uk-text-left"><?=Uni::t('app','Uchastka')?></th>
                    <th class="uk-width-2-10 uk-text-center"><?=Uni::t('app','Created')?></th>
                    <th class="uk-width-2-10 uk-text-center"><?=Uni::t('app','Actions')?></th>
                </tr>
                </thead>
                <tbody>
                
                <?php foreach ($dataProvider->models as $model) {?>
                    <tr id="row_<?=$model->id ?>">
                        <td class="uk-text-center uk-table-middle small_col">
                            <input type="checkbox" data-md-icheck class="check_row"/>
                        </td>
                        <td class="uk-text-left"><?=$model->kasal->name_ru?></td>
                        <td class="uk-text-left"><?=$model->kasal_daraja?></td>
                        <td class="uk-text-left"><?=isset($model->uchastka)?$model->uchastka->makeFIO():"not found"?></td>
                        <td class="uk-text-center"><?=$model->created_date?></td>
                        <td class="uk-text-center">
                            <a href="<?=$this->to('settings/diagnose/view/'.$model->id)?>"><i class="md-icon material-icons uk-text-primary">&#xE417;</i></a>
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
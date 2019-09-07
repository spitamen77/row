<?
use app\components\manager\Url;
$this->title = Uni::t('app', 'successfully added');
?>
<div class="md-card">
<div class="md-card-content large-padding">
    <div class="uk-grid">

        <div class="alert alert-success"><i class="glyphicon glyphicon-check"></i> <?=Uni::t('app','Employee')?> <?=$model->lastname?>  <?=$model->firstname?>  <?=$model->middlename?>  <?=Uni::t('app','successfully added')?>!        </div>

            <div class="uk-width-medium-1-6">
            <a href="<?=$this->to("hr/employee/list")?>" class="btn btn-success btn-sm" rel="tooltip" data-toggle="tooltip" data-placement="bottom" data-original-title="">
                <button class="md-btn md-btn-block"><?=Uni::t('app','Main page')?> </button>
            </a></div>
            <div class="uk-width-medium-1-6">
            <a href="<?=$this->to("hr/employee/edit/general/".$model->per_id)?>" class="btn btn-success btn-sm" rel="tooltip" data-toggle="tooltip" data-placement="bottom" data-original-title="Открыть профиль">
                <button class="md-btn md-btn-block md-btn-success"><?=Uni::t('app','Continue')?></button>
            </a>
            </div>
            <div class="uk-width-medium-1-6">
            <a href="<?=$this->to("hr/employee/add")?>" class="btn btn-success btn-sm" rel="tooltip" data-toggle="tooltip" data-placement="bottom" data-original-title="Добавить ещё">
                <button class="md-btn md-btn-block md-btn-primary"><?=Uni::t('app','Add other employee')?></button>
            </a></div>
        </div>
</div>

</div>
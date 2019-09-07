<? use app\components\manager\Url;?>
<div class="uk-grid">
    <div class="uk-width-medium-1-6">

            <button onclick="window.history.back();" class="md-btn md-btn-block md-btn-success"><?=Uni::t('app','Back')?></button>

    </div>
    <div class="uk-width-medium-1-6">
        <a href="<?=$this->to("hr/employee/add")?>">
            <button class="md-btn md-btn-block md-btn-primary"><?=Uni::t('app','Add employee')?></button>
        </a>    
    </div>
    <div class="uk-width-medium-1-6">
        <a href="<?=$this->to("hr/employee/list")?>">
            <button class="md-btn md-btn-block"><?=Uni::t('app','All employees')?></button>
        </a>
    </div>
    <div class="uk-width-medium-1-6">
        <a href="<?=$this->to("hr/employee/fired")?>">
            <button class="md-btn md-btn-block md-btn-danger"><?=Uni::t('app','Employee work out')?></button>
        </a>
    </div>
    <!-- <div class="uk-width-medium-1-6">
            <button href="#" class="md-btn md-btn-block md-btn-warning"><?=Uni::t('app','Others')?></button>
    </div> -->
    <?if(Uni::$app->controller->access('ADMIN_TUM')){?>
        <div class="uk-width-medium-1-6">
            <a href="<?=$this->to("reference/hudud/index")?>">
                <button class="md-btn md-btn-block md-btn-warning"><?=Uni::t('app','Add uchastka')?></button>
            </a>
        </div>
    <?}?>
</div>
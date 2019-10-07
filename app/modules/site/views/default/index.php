<?
use app\components\manager\Url;
$this->title = Uni::t('app', 'Control Panel');
?>

<div class="uk-grid">
    <div class="uk-width-1-1">
        <div>

            <div class="" >
                <h3>
                    <?=Uni::t('app','Control Panel')?>
                </h3>
            </div>
            <div>

                <?=Uni::$app->controller->renderPartial("/default/menu")?>
            </div>

        </div>

    </div>
</div>
<div class="uk-grid">
        <div class="uk-width-2-4">
            <div class="md-card">
                <?=(new \app\components\widgets\SysInfo())->sysinfo()?>
            </div>
        </div>
</div>

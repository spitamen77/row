<?php $this->title = Uni::t('app', 'Control panel')." | ".Uni::t('app', 'Modules') ?>
<?=Uni::$app->controller->renderPartial("/default/menu")?>
<div class="uk-grid">
    <div class="uk-width-8-10">
        <!-- start: CONDENSED TABLE PANEL -->
        <div class="md-card">
            <div class="md-card-head-text">
                <?=Uni::t('app','List of modules')?>
            </div>
            <div class="md-card-content">
                <table class="uk-table">
                    <thead>
                    <tr>
                        <th><?=Uni::t('app','Name')?></th>
<!--                        <th class="hidden-xs">--><?//=Uni::t('app','Code Name')?><!--</th>-->
                        <th class="hidden-xs"><?=Uni::t('app','Description')?></th>
                        <th><i class="fa fa-time"></i> <?=Uni::t('app','Date of creation')?></th>
                        <th class="hidden-xs"><?=Uni::t('app','Status')?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?foreach($modules as $m){
                        if ($m->active==9) continue;
                        ?>
                        <tr>

                            <td>
                                <a href="#">
                                    <?=$m->title?>
                                </a></td>
                            <td class="hidden-xs"><?=$m->description?></td>
                            <td><?=date("d.m.Y",$m->created)?></td>
                            <td class="hidden-xs">
                                <?if($m->active==1){?>
                                    <span class="label label-sm label-success"><?=Uni::t('app','Active')?></span><?}else{?>
                                    <span class="label label-sm label-danger"><?=Uni::t('app','Blocked')?></span>
                                <?}?>

                            </td>

                        </tr>
                    <?}?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- end: CONDENSED TABLE PANEL -->
    </div>
</div>

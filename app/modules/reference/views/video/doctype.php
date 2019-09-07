<?
use app\components\manager\Url;
?>
<div class="block-process" style="margin-bottom:10px;">
    <a class="md-btn md-btn-success" href="<?=Url::to('reference/default/index')?>"><?=Uni::t('app','Back')?></a>
</div>
<div class="md-card uk-margin-medium-bottom">
    <div class="md-card-content">
        <div class="uk-overflow-container">
            <table class="uk-table uk-table-nowrap table_check">
                <thead>

                    <tr>
                        <th class="uk-width-1-10 uk-text-center small_col">
                            <input type="checkbox" data-md-icheck class="check_all"></th>

                        <th class="uk-width-2-10">Title</th>
                        <th class="uk-width-2-10 uk-text-center">Created</th>
                        <th class="uk-width-1-10 uk-text-center">Data</th>
                        <th class="uk-width-1-10 uk-text-center">Status</th>
                        <th class="uk-width-2-10 uk-text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <? foreach ($data->models as $model) {?>
                    <tr>
                        <td class="uk-text-center uk-table-middle small_col">
                            <input type="checkbox" data-md-icheck class="check_row"/>
                        </td>
                        <td><?=$model->title?></td>
                        <td class="uk-text-center"><?=date('d-m-Y',$model->created)?></td>
                        <td class="uk-text-center">25-06-1975</td>
                        <td class="uk-text-center">
                           <?if($model->status){?> <span class="uk-badge">Active</span><?}else{?>
                               <span class="uk-badge uk-badge-danger">inActive</span>
                           <?}?>
                        </td>
                        <td class="uk-text-center">
                            <a href="<?=$this->to('reference/doctype/edit/'.$model->id)?>"><i class="md-icon material-icons">&#xE254;</i></a>
                            <a href="<?=$this->to('reference/doctype/view/'.$model->id)?>"><i class="md-icon material-icons">&#xE88F;</i></a>
                        </td>
                    </tr>
                <?}?>
                </tbody>
            </table>
        </div>
        <?= uni\widgets\LinkPager::widget([
            'pagination' => $data->pagination
        ]) ?>

    </div>
</div>

<div class="md-fab-wrapper">
    <a class="md-fab md-fab-primary" href="<?=$this->to('reference/doctype/create')?>" data-uk-tooltip="{pos:'right'}" title="Create new doc type"><i class="material-icons">&#xE145;</i></a>

</div>
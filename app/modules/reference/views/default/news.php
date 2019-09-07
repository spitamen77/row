<?
use app\components\manager\Url;
?>
<div class="block-process" style="margin-bottom:10px;">
    <a class="md-btn md-btn-success" href="<?=Url::to('reference/default/index')?>"><?=Uni::t('app','Back')?></a>
    <a class="md-btn md-btn-primary" href="<?=Url::to('reference/news/add')?>"><?=Uni::t('app','Add')?></a>
</div>
<div class="md-card uk-margin-medium-bottom">
    <div class="md-card-content">
        <div class="uk-overflow-container">
            <table class="uk-table uk-table-nowrap table_check">
                <thead>

                <tr>
                    <th class="uk-width-1-10 uk-text-center small_col">
                        <input type="checkbox" data-md-icheck class="check_all"></th>

                    <th class="uk-width-1-10">Image</th>
                    <th class="uk-width-2-10 uk-text-center">Created</th>
                    <th class="uk-width-1-10 uk-text-center">Title</th>
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
                        <td><img src="<?=$model->image?>"/></td>
                        <td class="uk-text-center"><?=date('d-m-Y',$model->created)?></td>
                        <td class="uk-text-center"><?=$model->short?></td>
                        <td class="uk-text-center">
                            <?=$model->published?>
                        </td>
                        <td class="uk-text-center">
                            <a href="<?=$this->to('reference/news/edit/'.$model->id)?>"><i class="md-icon material-icons">&#xE254;</i></a>
                            <a href="<?=$this->to('reference/news/view/'.$model->id)?>"><i class="md-icon material-icons">&#xE88F;</i></a>
                            <a href="<?=$this->to('reference/news/delete/'.$model->id)?>"><i class="md-icon material-icons">&#xE88F;</i></a>
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
<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
$message=new \app\models\Message;
$m=new \app\models\Video;
$languages=\app\models\Lang::find()->all();
\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Muxr.saveVideo();Muxr.openClearedVideo();Muxr.openVideoForm();');
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
?>
<div class="block-process" style="margin-bottom:10px;">
    <div class="uk-grid">
        <div class="uk-width-1-2">
        <a class="md-btn md-btn-success md-btn-small" href="<?=Url::to('reference/default/index')?>"><?=Uni::t('app','Back')?></a>
        <a class="md-btn md-btn-primary md-btn-small" href="<?=$this->to('reference/default/translation')?>"><?=Uni::t('app','All')?></a>
        <button id="modal_add_video_btn" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app','Add')?></button>
        </div>
        <div class="uk-width-1-2">
            <form method="get">
                <div class="uk-grid">
                    <div class="uk-width-3-4">
                        <input class="md-input" placeholder="<?=Uni::t('app','Search')?>" <?=$q?" value='".$q."'":""?> name="q" type="text">
                    </div>
                    <div class="uk-width-1-4">
                        <button type="submit" class="md-btn md-btn-success"><i class="material-icons">search</i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="md-card">
    <div class="md-card-content">
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
                        <td><?=$model->title?></td>
                        <td class="uk-text-center"><?=date('d-m-Y',$model->fan_id)?></td>
                        <td class="uk-text-center"><?=$model->short?></td>
                        <td class="uk-text-center">
                            <?=$model->publish?>
                        </td>
                        <td class="uk-text-center">
                            <a href="<?=$this->to('reference/video/edit/'.$model->id)?>"><i class="md-icon material-icons">&#xE254;</i></a>
                            <a href="<?=$this->to('reference/video/view/'.$model->id)?>"><i class="md-icon material-icons">&#xE88F;</i></a>
                            <a href="<?=$this->to('reference/video/delete/'.$model->id)?>"><i class="md-icon material-icons">&#xE88F;</i></a>
                        </td>
                    </tr>
                <?}?>
                </tbody>
            </table>
        <?= uni\widgets\LinkPager::widget([
            'pagination' => $data->pagination,
            'options'=>['class' => 'uk-pagination']
        ]) ?>
    </div>
    </div>

<!--- Modal New Video Add -->
<div class="uk-modal" id="modal_add_video">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
         <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formVideo']); ?>
                <div class="uk-form-row">
                    <?= $form->field($m, 'title')->textInput() ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'slug')->textInput() ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'short')->textInput() ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'fan_id')->textInput() ?>
                </div>
                <br/>
                <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveVideo']) ?>
        <?php Form::end(); ?>
    </div>
</div>
<!--  Modal Notification after adding New Video -->
<div class="uk-modal" id="modal_notification">
    <div class="uk-modal-dialog" style="min-height: 400px">
        <button type="button" class="uk-modal-close uk-close"></button>
        <a class="md-btn md-btn-primary" href='<?=Url::to('reference/default/video')?>'><?=Uni::t('app','Video list')?></a>
        <button class="md-btn md-btn-primary" id='addAnother'><?=Uni::t('app','Add')?></button> 
    </div>
</div>
<!---   Modal Video Edit -->

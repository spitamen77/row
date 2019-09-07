<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use app\models\Kasb;
use app\models\Subject;
$m=new \app\models\Attach;
$languages=\app\models\Lang::find()->all();
\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Muxr.saveAttach();Muxr.openClearedAttach();Muxr.openAttachForm();Muxr.openEditAttachForm();Muxr.openDeleteAttachForm();Muxr.editAttachStatus();Muxr.changeAttachOrder();Muxr.viewAttach();
    $("#mselect").selectize({});
    $("#kasb-fan").selectize({});');
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
$kasb = array();
$s = \app\models\Kasb::find()->where(['status' => 1])->asArray()->all();
foreach ($s as $key => $value) {
    $kasb[$value['id']] = $value['title'];
}
$fan = array();
$s = \app\models\Subject::find()->where(['status' => 1])->asArray()->all();
foreach ($s as $key => $value) {
    $fan[$value['id']] = $value['title'];
}
?>
<div class="block-process" style="margin-bottom:10px;">
    <div class="uk-grid">
        <div class="uk-width-1-2">
        <a class="md-btn md-btn-success md-btn-small" href="<?=Url::to('reference/default/index')?>"><?=Uni::t('app','Back')?></a>
        <a class="md-btn md-btn-primary md-btn-small" href="<?=$this->to('reference/default/attach')?>"><?=Uni::t('app','All')?></a>
        <button id="modal_add_attach_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app','Add')?></button>
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

                    <th class="uk-width-1-10">Kasb</th>
                    <th class="uk-width-2-10">Course</th>
                    <th class="uk-width-1-10 uk-text-center">Order</th>
                    <th class="uk-width-1-10 uk-text-center">Created date</th>
                    <th class="uk-width-2-10 uk-text-center">Status</th>
                    <th class="uk-width-2-10 uk-text-center">Order</th>
                    <th class="uk-width-2-10 uk-text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($data->models as $model) {?>
                    <tr id='row_<?=$model->id?>'>
                    <? $st = $model->status; ?>
                        <td class="uk-text-center uk-table-middle small_col">
                            <input type="checkbox" data-md-icheck class="check_row"/>
                        </td>
                        <td class="uk-width-2-10"><?=($model->kasb)?$model->kasb->title:Uni::t('app', 'Not Found')?></td>
                        <td class="uk-width-1-10"><?=($model->subject)?$model->subject->title:Uni::t('app', 'Not Found')?></td>
                        <td class="uk-width-2-10 uk-text-center"><?=$model->order_number?></td>
                        <td class="uk-width-2-10 uk-text-center"><?=$model->created_date?></td>
                        
                        <td class="uk-width-2-10 uk-text-center"><a class="modal-edit-status" data-id="<?=$model->id?>"><i class="md-icon material-icons uk-text-primary"><?=($st==0)?"&#xE835;":"&#xE834;"?></i></a></td>
                        
                        <td class="uk-width-2-10 uk-text-center">
                            
                            <a class="modal-edit-order" data-id="<?=$model->id?>" data-move="down"><i class="md-icon material-icons uk-text-primary">&#xE5DB;</i></a>
                            
                            <a class="modal-edit-order" data-id="<?=$model->id?>" data-move="up"><i class="md-icon material-icons uk-text-primary">&#xE5D8;</i></a>
                        
                        </td>
                        <td class="uk-text-center">
                            
                            <a class="modal-edit-attach" data-id="<?=$model->id?>" data-kasb="<?=$model->kasb_id?>" data-fan="<?=$model->fan_id?>" data-order="<?=$model->order_number?>"><i class="md-icon material-icons uk-text-primary">&#xE254;</i></a>
                            

                            <a href="<?=Url::to('reference/kasb/view/').$model->kasb_id?>" class="modal-view-atach" data-id="<?=$model->kasb_id?>"><i class="md-icon material-icons uk-text-primary">&#xE417;</i></a>

                            <a class="modal-delete-attach" data-id="<?=$model->id?>"><i class="md-icon material-icons uk-text-danger">&#xE612;</i></a>

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


<div class="uk-notify uk-notify-top-center" style="display: none;"></div>

<!--- Modal New Attach Add -->
<div class="uk-modal" id="modal_add_attach">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
         <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formAttach']); ?>
                <div class="uk-form-row">
                    <?= $form->field($m, 'kasb_id')->dropDownList($kasb) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'fan_id')->dropDownList($fan,['id'=>'mselect','multiple'=>'multiple']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'order_number')->textInput() ?>
                </div>
                <input type="hidden" id="attachAdd"/>
                <br/>
                <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveAttach']) ?>
        <?php Form::end(); ?>
    </div>
</div>

<!--  Modal Notification after adding New Attach -->
<div class="uk-modal" id="modal_notificationAttach">
    <div class="uk-modal-dialog" style="min-height: 400px">
        <button type="button" class="uk-modal-close uk-close"></button>
        <a class="md-btn md-btn-primary" href='<?=Url::to('reference/default/attach')?>'>
        	<?=Uni::t('app','Video list')?></a>
        <button class="md-btn md-btn-primary" id='addAnotherAttach'>
        	<?=Uni::t('app','Add')?>
        </button> 
    </div>
</div>

<!---   Modal Attach Edit -->
<div class="uk-modal" id="modal_edit_attach">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
         <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formAttachEdit']); ?>
                <div class="uk-form-row">
                    <?= $form->field($m, 'kasb_id')->dropDownList($kasb,['id' => 'kasb-kasb']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'fan_id')->dropDownList($fan,['id' => 'kasb-fan','multiple'=>'multiple']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'order_number')->textInput(['id' => 'kasb-order']) ?>
                </div>
                <br/>
                <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block', 'id'=>'saveAttachEdit']) ?>
        <?php Form::end(); ?>
    </div>
</div>

<!--  Modal Attach after deletion -->
<div class="uk-modal" id="modal_deleteAttach">
    <div class="uk-modal-dialog" style="min-height: 400px">
        <button type="button" class="uk-modal-close uk-close"></button>
        <a class="md-btn md-btn-primary">
        	<?=Uni::t('app','Back to List')?>
        </a>
        <button class="md-btn md-btn-primary" id='deleteAnotherAttach'>
        	<?=Uni::t('app','Confirm')?>
        </button> 
    </div>
</div>

<!--  Modal Attach View -->
<div class="uk-modal" id="modal_viewAttach">
    <div class="uk-modal-dialog" style="min-height: 400px">
        <button type="button" class="uk-modal-close uk-close"></button>
        <a class="md-btn md-btn-primary">
            <?=Uni::t('app','Back to List')?>
        </a>
        <button class="md-btn md-btn-primary" id='deleteAnotherAttach'>
            <?=Uni::t('app','Confirm')?>
        </button> 
    
    </div>
</div>
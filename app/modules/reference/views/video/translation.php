<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
$message=new \app\models\Message;
$m=new \app\models\SourceMessage;
$languages=\app\models\Lang::find()->all();
\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Muxr.saveMessageSrc();Muxr.addMessageSrc(),Muxr.saveSourceMessage();Muxr.addTranslation();Muxr.saveTranslation();Muxr.editTranslation();Muxr.editMessage();Muxr.deleteMessage();');
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
            <button id="modal_add_btn" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app','Add')?></button>
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
        <?php if($data->count > 0) : ?>
            <table class="uk-table uk-table-bordered ">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th><?= Uni::t('app', 'Name') ?></th>
                        <th><?= Uni::t('app', 'Title') ?></th>
                        <th><?= Uni::t('app', 'Translations') ?></th>
                        <th width="200"><?= Uni::t('app', 'Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($data->models as $module) : ?>
                    <tr>
                        <td><?= $module->primaryKey ?></td>
                        <td><b><?= $module->message ?></b></td>
                        <td><?= $module->getCatList()[$module->category] ?></td>
                        <td><? if($module->messages)foreach ($module->messages as $message) {?>
                                <span class="md-icon editTranslation uk-badge-success" style="font-size:14px;float:left;padding: 1px; color:#fff;display: block;line-height: 21px!important;height:21px!important;width: 21px!important;" data-pk="<?=$message->id?>" data-lang="<?=$message->language?>" data-translation="<?=$message->translation?>"><?=$message->language?></span>
                            <?}?>
                        </td>
                        <td class="control">
                            <div class="md-btn-group md-btn-group-sm" role="group">
                                <a href="#" class="editMessage" title="<?= Uni::t('app', 'Source Message') ?>" data-pk="<?=$module->primaryKey?>" data-cat="<?=$module->category?>" data-message="<?=$module->message?>">
                                    <i class="md-icon material-icons uk-text-success">&#xE3C9;</i>
                                </a>
                                <a data-pk="<?=$module->primaryKey?>"  class=" addTranslation " title="<?= Uni::t('app', 'Add translation') ?>">
                                    <i class="md-icon material-icons uk-text-primary">&#xE146;</i>
                                </a>
                                <span data-pk="<?=$module->primaryKey?>" class="deleteMessage uk-text-danger" title="<?= Uni::t('app', 'Delete item') ?>">
                                    <i class="md-icon material-icons uk-text-danger">&#xE15C;</i>
                                </span>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>
            <?= uni\widgets\LinkPager::widget([
                'pagination' => $data->pagination,
                'options'=>['class' => 'uk-pagination']
            ]) ?>
        <?php else : ?>
            <p><?= Uni::t('app', 'No records found') ?></p>
        <?php endif; ?>
    </div>
    </div>

<div class="uk-modal" id="modal_add">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
        <div class="uk-form-row">
            <?php $form = Form::begin(['enableAjaxValidation' => true]); ?>
            <?=$form->field($m,'category')->dropDownList(\app\models\SourceMessage::getCatList(),['id'=>'catListn'])?>
        </div>
        <div class="uk-form-row">
            <?= $form->field($m, 'message')->textInput(['id'=>'srcMessagen']) ?>
        </div>
        <input type="hidden" id="messagePkn"/>
        <br/>
        <?= Html::button(Uni::t('app', 'Save'), ['class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveMessageSrc']) ?>
        <?php Form::end(); ?>
    </div>
</div>

<div class="uk-modal" id="modal_update">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
        <div class="uk-form-row">
            <?php $form = Form::begin(['enableAjaxValidation' => true]); ?>
            <?=$form->field($m,'category')->dropDownList(\app\models\SourceMessage::getCatList(),['id'=>'ucatList'])?>
        </div>
        <div class="uk-form-row">
            <?= $form->field($m, 'message')->textInput(['id'=>'usrcMessage']) ?>
        </div>
        <input type="hidden" id="messagePk"/>
        <br/>
        <?= Html::button(Uni::t('app', 'Save'), ['class' => 'md-btn md-btn-primary md-btn-block','id'=>'updateSourceMessage']) ?>
        <?php Form::end(); ?>
    </div>
</div>

<div class="uk-modal" id="modal_add_translation">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
        <div class="uk-form-row">
            <?php $form = Form::begin(['enableAjaxValidation' => true]); ?>
            <?=$form->field($message,'language')->dropDownList(\app\models\Lang::getDropDown(),['id'=>'langList'])?>
        </div>
        <div class="uk-form-row">
            <?= $form->field($message, 'translation')->textInput(['id'=>'srcTranslation']) ?>
        </div>
        <input id="pk" type="hidden"/>
        <br/>
        <?= Html::button(Uni::t('app', 'Save'), ['class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveMessage']) ?>
        <?php Form::end(); ?>
    </div>
</div>
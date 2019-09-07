<?
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\export\ExportMenu;
use app\components\manager\Url;

?>
<?Pjax::begin(['id'=>'filterData'])?>
    <div class="col-md-10">
        <?php $form = ActiveForm::begin([
            'id' => 'filterForm',
            'method'=>'get',
            'action'=>Url::getMain(),
            'options' => ['class' => 'form-inline', 'data-pjax' => true],
        ]); ?>
        <div class="form-group">
            <input type="text" name="fio" class="form-control"  placeholder="<?=Yii::t('app','FIO')?>">
        </div>
        <div class="form-group">
            <input type="text" name="position" class="form-control" placeholder="<?=Yii::t('app','Position')?>">
        </div>
        <div class="form-group">
            <input type="text" name="department" class="form-control" id="email" placeholder="<?=Yii::t('app','Department')?>">
        </div>
        <?if(Yii::$app->controller->access('ADMIN')){?>
            <div class="form-group">
                <input type="text" name="login" class="form-control" id="email" placeholder="<?=Yii::t('app','Login')?>">
            </div>
        <?}?>

        <div class="form-group">
            <a href="<?=Url::getMain()?>"><button type="btn" class="btn red">СБРОСИТЬ</button></a>
        </div>
        <div class="form-group">
            <button type="button" class="btn yellow">ВСЕ ДАННЫЕ</button>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-md-2">
        <div class="form-group" style="padding-top: 30px; padding-bottom: 20px;padding-right: 20px;">
            <? echo ExportMenu::widget([
                'dataProvider' => $provider,
                'columns' => $columns,
                'target'=>ExportMenu::TARGET_BLANK,
                'showColumnSelector'=>false,
                'dropdownOptions'=>['label'=>'ЭКСПОРТ','class'=>'btn green', 'style'=>'padding: 10px 25px;color: #fff;']

            ]);?>
        </div>
    </div>

<? Pjax::end()?>
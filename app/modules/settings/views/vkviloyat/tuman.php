<?


use app\components\manager\Url;
use app\models\Lang;
use uni\helpers\Html;
use uni\ui\Form;


\app\assets\DashboardAssets::register($this);
\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Vaksina.saveVkTuman();Vaksina.openClearedVkTuman();Vaksina.openVkTumanForm();');

$current = Lang::getCurrent();
if ($current->url=='ru') $name = "name_ru"; else $name = "name_uz";
$viloyat = \app\models\Viloyat::findOne($userId);
$this->title = $viloyat->$name." - ".Uni::t('app','VetControl');
//$languages=\app\models\Lang::find()->all();
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}


?>
<div class="block-process" style="margin-bottom:10px;">
    <div class="uk-grid">
        <div class="uk-width-1-2">
        <a class="md-btn md-btn-success md-btn-small" onclick="window.history.back()"><?=Uni::t('app','Back')?></a>
        <button id="modal_add_VkTuman_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app','Add')?></button>
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
        <h2>Administrator paneli</h2>
    </div>
    <div class="md-card uk-margin-medium-bottom">
        <div class="md-card-content">
            <div class="uk-overflow-container">
                <table class="uk-table uk-table-hover">
                    <thead>
                    <tr>
                        <th>Tuman nomi</th>
                        <th>Rasxod</th>
                        <th>---</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach ($data as $key => $value) : ?>
                    <tr>
                        <td><?=$value['username']?></td>
                        <td><?=$value['miqdor']?></td>
                        <td><a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="<?=Url::to('settings/vkviloyat/uchastka/'.$value['id'])?>">Batafsil</a></td>
                    </tr>
                    <? endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



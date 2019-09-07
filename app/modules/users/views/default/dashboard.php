<?
$this->title = Uni::t('app','VetControl');

//\app\assets\DashboardAssets::register($this);
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use app\models\Viloyat;
use app\models\Vaksina;
use app\models\VkViloyat;

//$languages=\app\models\Lang::find()->all();
\app\components\widgets\SweetAlertAsset::register($this);

$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}


?>
<div class="md-card">
    <div class="md-card-content">
        <h2><?=Uni::t('app', 'Administration panel')?></h2>
    </div>
    <div class="md-card uk-margin-medium-bottom">
        <div class="md-card-content">
            <div class="uk-overflow-container">
                <table class="uk-table uk-table-hover">
                    <thead>
                    <tr>
                        <th><?=Uni::t('app', 'Vaccine name')?></th>
                        <th><?=Uni::t('app', 'Vaccine count')?></th>
                        <th><?=Uni::t('app', 'Vaccine residue')?></th>
                        <th><?=Uni::t('app', 'Status')?></th>
                        <th>---</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach ($data as $value) : $v=Vaksina::findOne($value['vaksina_id']);?>
                    <tr>
                        <td><?=$v->name_uz?></td>
                        <td><?=$value['cnt']?> <span class="uk-badge uk-badge-primary"><?=$v->unit->name_uz?></span></td>
                        <td><?=$value['ostatok']?> <span class="uk-badge uk-badge-primary"><?=$v->unit->name_uz?></span></td>
                        <td><?=$v->status?></td>

                        <td><a  href="<?=Url::to("vaksinatsiya/default/list/".$v->id)?>"><i class="md-icon material-icons uk-text-primary eye">&#xE417;</i></a></td>

                    </tr>
                    <? endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>


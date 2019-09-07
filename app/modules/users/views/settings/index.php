<?
use app\components\manager\Url;
?>

<h4 class="heading_a uk-margin-bottom"><?=Uni::t('app','Templates')?></h4>
<div class="md-card uk-margin-medium-bottom">
<div class="md-card-content">
                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-nowrap table_check">
                            <thead>
                            <tr>
                                <th class="uk-width-1-10 uk-text-center small_col"><div class="icheckbox_md"><input type="checkbox" data-md-icheck="" class="check_all" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></th>
                                <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app','User Image')?></th>
                                <th class="uk-width-2-10"><?=Uni::t('app','User Name')?></th>
                                 <th class="uk-width-2-10"><?=Uni::t('app','Title')?></th>
                                <th class="uk-width-2-10 uk-text-center"><?=Uni::t('app','Company ')?></th>
                                <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app','Created')?></th>
                                <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app','Status')?></th>
                                <th class="uk-width-2-10 uk-text-center"><?=Uni::t('app','Actions')?></th>
                            </tr>
                            </thead>

                            <tbody>
                            	 <?foreach($data->models as $m):?>	
                                <tr>
                                    <td class="uk-text-center uk-table-middle small_col">
                                    	<div class="icheckbox_md"><input type="checkbox" data-md-icheck="" class="check_row" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
                                    	<ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
                                    	
                                    </ins>
                                    </div>
                                    </td>
                                    <td class="uk-text-center">
                                    	<img class="md-user-image" src="<?=$m->user->avatar?>" alt="<?=$m->user->avatar?>"></td>
                                    <td><?=($m->user) ? $m->user->makeFIO() : ''?></td>
                                     <td><?=$m->title?></td>
                                    <td class="uk-text-center"><?=($m->companym) ? $m->companym->name : ''?></td>
                                    <td class="uk-text-center"><?=$m->created?></td>
                                    <td class="uk-text-center">
                                    	<?=($m->status==1) ? "<span class=\"uk-badge\">Active</span>" : "<span class=\"uk-badge uk-badge-danger\">Inactive</span>"?>

                                    </td>
                                    <td class="uk-text-center">
                                        <a href="/users/settings/edit/<?=$m->id?>"><i class="md-icon material-icons uk-text-primary">&#xE254;</i></a>
                                        <a href="/users/settings/template/<?=$m->id?>"><i class="md-icon material-icons uk-text-danger">&#xE417;</i></a>
                                        <a href="/users/settings/delete/<?=$m->id?>">
                                        	<i class="md-icon material-icons uk-text-warning">&#xE612;</i>
                                        </a>
                                        <a href="/users/settings/active/<?=$m->id?>">
                                            <i class="md-icon material-icons uk-text-warning">&#xE612;</i>
                                        </a>
                                    </td>
                                </tr>
                                <?endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <?= uni\widgets\LinkPager::widget([
                        'pagination' => $data->pagination,
                        'options' => [
                        'class' => 'uk-pagination uk-margin-medium-top',]  
                    ]) ?>
                </div>
</div>

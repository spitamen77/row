<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body dark-grey">Справочник - <?=$model->surename?>	<?=$model->name?>	<?=$model->middle_name?></div>
            <div class="panel-profil">
                <div class="photo-camera green center-block">
                    <?if($model->personal_picture){?>
                        <img src="/filemanager/uploads/?module=hr&folder=avatars&file=<?=$model->personal_picture?>&mode=photo" alt=""/>
                    <?}else{?>
                        <img src="/themes/admin/images/photo-camera.svg" alt="">
                    <?}?>
                </div>
                <div class="text-center"><?=$model->surename?>	<?=$model->name?>	<?=$model->middle_name?></div>
            </div>
            <div class="panel-footer">
                <div class="table-responsive">
                    <table class="table table-biography">
                        <tbody>
                        <tr>
                            <td>Должность</td>
                            <td>с <?=$last_time?> года сотрудник по срочному трудовому договору юридического отдела Государственной акционерной внешнеторговой компании</td>
                        </tr>
                        <tr>
                            <td>Дата рождения</td>
                            <td><?=($model->info)?$model->info->birthday:""?></td>
                        </tr>
                        <tr>
                            <td>Место рождения</td>
                            <td><?=($model->info)?$model->info->getBirthPlace():""?></td>
                        </tr>
                        <tr>
                            <td>Национальность</td>
                            <td><?=($model->info)?$model->info->nationality:"" ?></td>
                        </tr>
                        <tr>
                            <td>Партийность</td>
                            <td><?=($model->other)?$model->other->party_membership:"не состоит в партии"?></td>
                        </tr>
                        <tr>
                            <td>Образование</td>
                            <td><?=$rank?></td>
                        </tr>
                        <tr>
                            <td>Окончил(а)</td>
                            <td>в 1995 году, Ташкентский государственный технический университет</td>
                        </tr>
                        <tr>
                            <td>Специальность по образованию</td>
                            <td><?=$spec?></td>
                        </tr>
                        <tr>
                            <td>Какими иностранными языками владеет</td>
                            <td><?=$lang?></td>
                        </tr>
                        <tr>
                            <td>Имеет ли государственные награды (какие)</td>
                            <td><?=($model->other)?$model->other->state_awards:"не имеет"?></td>
                        </tr>
                        <tr>
                            <td>Является ли народным депутатом, членом центральных, республиканских, областных, городских, районных и других выборных органов (указать полностью):</td>
                            <td><?=($model->other)?$model->other->deputy:"не является"?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="biography-text">Трудовая  деятельность</div>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="blue">
                        <tr>
                            <th>Должность и место работы</th>
                            <th>Дата устройства</th>
                            <th>Дата увольнения</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?if($model->activity)foreach($model->activity as $a){?>
                            <tr>
                                <td><?=$a->work_title?>зано</td>
                                <td><?=$a->begin_date?></td>
                                <td><?=$a->end_date?></td>
                            </tr>
                        <?}else{?>
                            <tr>
                                <td colspan="3" class="text-center">Не указано</td>
                            </tr>
                        <?}?>

                        </tbody>
                    </table>
                </div>
                <div class="biography-text">Сведения о близких родственниках</div>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="blue">
                        <tr>
                            <th width="10%">Степень родства</th>
                            <th>Фамилия Имя Отчество</th>
                            <th>Дата и место рождения</th>
                            <th>Место работы и должность</th>
                            <th>Место жительства</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?if($model->relatives)foreach($model->relatives as $r){?>
                            <tr>
                                <td class="text-center"><?=$r->getRelStep()?></td>
                                <td class="text-center"><?=$r->makeFIO()?></td>
                                <td class="text-center"><?=$r->dob_year?> г.<br> <?=$r->getBirthPlace()?><br> </td>
                                <td class="text-center"><?=$r->position.$r->job?><br></td>
                                <td class="text-center"><?if($r->dead==1){ echo "Умер в	".$r->dead_year; }else { echo " ".$r->getResPlace();}?></td>
                            </tr>
                        <?}else{?>
                            <tr>
                                <td colspan="5" class="text-center">Не указано</td>
                            </tr>
                        <?}?>

                        </tbody>
                    </table>
                </div>
                <div class="btn-wrapper">
                    <button class="btn red" onclick="history.back()"><i class="fal fa-arrow-left"></i><?=Yii::t('app','Back')?></button>
                    <a href="<?=$this->to("hr/employee/edit/general/".$model->per_id)?>"> <button class="btn yellow">Редактировать</button></a>
                    <button class="btn green">Скачать файл</button>
                </div>
            </div>
        </div>
    </div>
</div>
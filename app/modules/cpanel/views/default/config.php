<?=Uni::$app->controller->renderPartial("/default/menu")?>
<?
$this->registerJs("
$(\"#savetheme\").click(function(){
 var data=$('#themeselect').serialize();
        console.log(data);
      var url='/cpanel/default/saveconfiguration';
        $.post(url,data,function(data){
             location.reload();
        });
});
$(\"#submittfp\").click(function(){
 var data=$('#ftpform').serialize();
        console.log(data);
      var url='/cpanel/default/saveconfiguration';
        $.post(url,{data:data},function(data){
             location.reload();
        });
});
$(\"#companyFtp\").click(function(){
 var data=$('#company').serialize();
      var url='/cpanel/default/saveconfiguration';
        $.post(url,{data:data},function(data){
             location.reload();
        });
});
");
$this->registerCss('
.conf-2 .col-md-4:first{
    min-height:350px;
}
');
$company=\app\models\Company::find()->one();
if(!$company)$company=new \app\models\Company();

?>
<hr class="uk-divider"/>
<div class="uk-grid">
    <div class="uk-width-1-3" style="min-height: 420px;" >
        <div class="md-card" style="min-height: 400px;">
            <div class="md-card-head-text">
               <?=Uni::t('app',' FTP Configuration Server')?>
            </div>
            <div class="md-card-content">



                <form method="post" id="ftpform">
                    <div class="uk-grid">
                            <div class="uk-width-8-10">
                                <input class="md-input" name="address" placeholder="<?=Uni::t('app','IP address')?>" <?if($ftp){?> value="<?=$ftp->value['address']?>"<?}?>/>
                            </div>
                            <div class="uk-width-2-10">
                                <input class="md-input" name="port" placeholder="<?=Uni::t('app','Port')?>"  <?if($ftp){?> value="<?=$ftp->value['port']?>"<?}?>/>
                            </div>
                    <div class="uk-width-1-1">
                        <input class="md-input" name="user" placeholder="<?=Uni::t('app','Username')?>"/>
                    </div>
                    <div class="uk-form-row ">
                        <input type="password" class="md-input col-md-12" name="password" placeholder="<?=Uni::t('app','Password')?>"/>
                    </div>
                    <div class="uk-form-row ">
                        <input class="md-input col-md-12" name="mainfolder" placeholder="<?=Uni::t('app','MainFolder')?>" <?if($ftp){?> value="<?=$ftp->value['mainfolder']?>"<?}?>/>
                    </div>
                    <div class="uk-width-1-1 ">
                        <input type="hidden" name="action" value="saveftp"/>
                        <input type="hidden" name="_csrf" value="<?=Uni::$app->request->getCsrfToken()?>"/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <input id="submittfp" type="button" class=" md-btn  md-btn-success md-btn-block" name="submitftp" value="<?=Uni::t('app','Update')?>"/>
                    </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
    <div class="uk-width-1-3">
        <div class="md-card" >
            <div class="md-card-head-text" >
                    <?=Uni::t('app','Database Configuration')?>
            </div>
            <div class="md-card-content">
                <form method="post" id="ftpform" >
                    <div class="uk-form-row col-md-12">
                        <input class="md-input" name="host" placeholder="Host"/>
                    </div>
                    <div class="uk-form-row col-md-12">
                        <input class="md-input" name="username" placeholder="<?=Uni::t('app','Username')?>"/>
                    </div>
                    <div class="uk-form-row col-md-12">
                        <input class="md-input" name="password" placeholder="<?=Uni::t('app','Password')?>"/>
                    </div>
                    <div class="uk-form-row col-md-12">
                        <input class="md-input" name="database" placeholder="<?=Uni::t('app','Database Name')?>"/>
                    </div>
                    <div class="uk-form-row ">
                        <input type="submit" class="md-input md-btn md-btn-success md-btn-block" name="submitdb" value="<?=Uni::t('app','Update')?>"/>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div class="uk-width-1-3">
        <div class="md-card" style="min-height: 321px;">
            <div class="md-card-head-text">

                    <?=Uni::t('app','System configuration')?>

            </div>
            <div class="md-card-content">
                <form id="themeselect">
                        <input name="_csrf" value="<?=Uni::$app->request->getCsrfToken()?>" type="hidden">
                        <input name="action" value="savetheme" type="hidden">
                        <div class="uk-form-row">
                            <select class="md-input" name="theme" >
                                <option value="theme_light.css" <?if($theme&&$theme->value=="theme_light.css") echo 'selected';?>><?=Uni::t('app','Default')?></option>
                                <option value="theme_dark.css" <?if($theme&&$theme->value=="theme_dark.css") echo 'selected';?>>
                                <?=Uni::t('app','Darken theme')?></option>
                                <option value="theme_black_and_white.css" <?if($theme&&$theme->value=="theme_black_and_white.css") echo 'selected';?>>
                                <?=Uni::t('app','Black and White Theme')?></option>
                                <option value="theme_navy.css" <?if($theme&&$theme->value=="theme_navy.css") echo 'selected';?>>
                                <?=Uni::t('app','The Navy')?></option>
                                <option value="theme_green.css" <?if($theme&&$theme->value=="theme_green.css") echo 'selected';?>>
                                    <?=Uni::t('app','Green theme')?></option>
                            </select>
                        </div>
                        <div class="uk-form-row">
                            <input class="md-input" name="siteaddress" placeholder="Site address" value="edoc.kvarts.uz"/>
                        </div>
                        <div class="uk-form-row">
                            <input class="md-input" name="ip" placeholder="ИП АДРЕС" value=""/>
                        </div>

                        <div class="uk-form-row">
                            <input class="md-input" name="wrong" placeholder="Количество неудачных" title="Количество неудачных" value="5"/>
                        </div>
                        <div class="uk-form-row">
                            <input type="button" id="savetheme" class="md-input md-btn md-btn-success md-btn-block" name="savetheme" value="<?=Uni::t('app','Update')?>"/>
                        </div>
                </form>
            </div>

        </div>
    </div>
    <br/>
    <br/>
    <div class="uk-width-1-1">
        <div class="md-card">
            <div class="md-card-head-text">
                    <?=Uni::t('app','Information about the company')?>
            </div>
            <div class="md-card-content">
                <form id="company"  method="post">
                    <input name="_csrf" value="<?=Uni::$app->request->getCsrfToken()?>" type="hidden">
                    <input name="action" value="savecompany" type="hidden">
                    <div class="uk-grid">


                    <div class="uk-width-1-3">
                        <div class="uk-form-row">
                            <input type="text" name="name" class="md-input" placeholder="Официальное название" <?=$company->name?"value='".$company->name."'":""?>/>

                        </div>
                        <div class="uk-form-row">
                            <input type="text" name="name_uz" class="md-input" placeholder="Название на узбекском языке"  <?=$company->name?"value='".$company->name."'":""?>/>
                        </div>
                        <div class="uk-form-row">
                            <input type="text" name="name_ru" class="md-input" placeholder="Название на русском"  <?=$company->name?"value='".$company->name."'":""?>/>
                        </div>
                    </div>
                    <div class="uk-width-1-3">
                        <div class="uk-form-row">
                            <input type="text" name="address" class="md-input" placeholder="Адресь" <?=$company->name?"value='".$company->name."'":""?>/>
                        </div>
                        <div class="uk-form-row">
                            <input type="text" name="phone" class="md-input" placeholder="Официальный телефон" <?=$company->name?"value='".$company->name."'":""?>/>
                        </div>
                        <div class="uk-form-row">
                            <input type="text" name="telephone" class="md-input" placeholder="Рабочий телефон" <?=$company->name?"value='".$company->name."'":""?>/>
                        </div>
                    </div>
                    <div class="uk-width-1-3">
                        <div class="uk-form-row">
                            <input type="text" name="fax" class="md-input" placeholder="Факс компании" <?=$company->name?"value='".$company->name."'":""?>/>
                        </div>

                        <div class="uk-form-row">
                            <input type="text" name="email" class="md-input" placeholder="Адрес электронной почты компании" <?=$company->name?"value='".$company->name."'":""?>/>
                        </div>
                        <div class="uk-form-row">
                            <?if($company->logotype){?>
                                <img src="<?=$company->logotype?>" class="img-responsive"/>
                            <?}?>

                        </div>
                    </div>
                    <div class="uk-width-1-1" style="margin-top:10px;margin-bottom:10px">
                        <div class="uk-form-row uk-form-file md-btn md-btn-primary">
                            <?=Uni::t('app','Select')?>
                            <input id="form-file" type="file">
                        </div>
                        <?=Uni::t('app','Company `s logo')?>
                        <div class="uk-form-file uk-text-primary"><?=Uni::t('app','upload')?><input id="form-file" type="file"></div>.
                    </div>
                    <div class="uk-width-1-1">
                    <button class="md-btn md-btn-success md-btn-block" type="button" id="companyFtp"><?=Uni::t('app','Save Information')?></button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
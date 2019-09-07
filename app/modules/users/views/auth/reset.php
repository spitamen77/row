<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 06.02.2019 18:03
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

use uni\ui\Form;
use app\components\manager\Url;

$user=new \app\models\UserModel();
$this->registerCssFile("/themes/ui/assets/css/login_page.min.css");
$this->registerJsFile ("/themes/ui/assets/js/pages/login.min.js",['depends' => ['app\assets\CoreAssets']]);
$this->registerJsFile ("/themes/ui/components/jquery.inputmask/dist/jquery.inputmask.bundle.js",['depends' => ['app\assets\CoreAssets']]);
$this->registerJs('Muxr.masked_inputs();Muxr.char_words_counter();Muxr.register();');

?>
<div class="login_page_wrapper" style="width: 400px;padding-bottom: 8px !important; ">
    <div class="md-card uk-animation-15" id="login_card" style="min-height: 100%">
        <div class="md-card-content large-padding uk-position-relative" id="login_help" style="display: block">
<!--            <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>-->
            <h2 class="heading_b uk-text-success"><?=Uni::t('app', 'The email was sent')?>?</h2>
            <p><?=Uni::t('app', 'Check your Inbox')?>.</p>
            <p><?=Uni::t('app', 'If you do not receive this email, please check your Spam folders')?>.</p>
            <p><?=Uni::t('app', 'Go to main page')?> <a href="<?=Url::to('users/auth/login')?>" class='' ><?=Uni::t('app', 'Back')?></a></p>
        </div>
    </div>
</div>
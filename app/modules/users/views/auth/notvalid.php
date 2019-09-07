<?php
use app\components\manager\Url;
?>
<div class="container">
    <div class="center"><i class="fa fa-user success-icon"></i>
        <p class="congrats"><?=Uni::t('app','Not found')?>!</p>
        <h2>Foydalanuvchi topilmadi yoki bu foydalanuvchi aktivatsiyadan o'tgan.</h2>
        <div><a href="<?= Url::to('') ?>" class="btn btn-large main-bg"><?=Yii::t('app', 'Home')?></a></div>
    </div>
</div>

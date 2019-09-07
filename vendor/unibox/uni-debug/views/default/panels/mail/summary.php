<?php
/* @var $panel uni\debug\panels\MailPanel */
/* @var $mailCount integer */
if ($mailCount): ?>
<div class="uni-debug-toolbar-block">
    <a href="<?= $panel->getUrl() ?>">Mail <span class="label"><?= $mailCount ?></span></a>
</div>
<?php endif ?>

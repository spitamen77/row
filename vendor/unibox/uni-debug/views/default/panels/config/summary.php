<?php
/* @var $panel uni\debug\panels\ConfigPanel */
?>
<div class="uni-debug-toolbar-block">
    <a href="<?= $panel->getUrl() ?>">
        <span class="label"><?= $panel->data['application']['uni'] ?></span>
        PHP
        <span class="label"><?= $panel->data['php']['version'] ?></span>
    </a>
</div>

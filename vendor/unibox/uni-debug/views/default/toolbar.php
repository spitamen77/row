<?php
/* @var $this \uni\web\View */
/* @var $panels \uni\debug\Panel[] */
/* @var $tag string */
/* @var $position string */

use uni\helpers\Url;

$minJs = <<<EOD
document.getElementById('uni-debug-toolbar').style.display = 'none';
document.getElementById('uni-debug-toolbar-min').style.display = 'block';
if (window.localStorage) {
    localStorage.setItem('uni-debug-toolbar', 'minimized');
}
EOD;

$maxJs = <<<EOD
document.getElementById('uni-debug-toolbar-min').style.display = 'none';
document.getElementById('uni-debug-toolbar').style.display = 'block';
if (window.localStorage) {
    localStorage.setItem('uni-debug-toolbar', 'maximized');
}
EOD;

$firstPanel = reset($panels);
$url = $firstPanel->getUrl();
?>
<div id="uni-debug-toolbar" class="uni-debug-toolbar-<?= $position ?> hidden-print">
    <div class="uni-debug-toolbar-block title">
        <a href="<?= Url::to(['index']) ?>">
            <img width="29" height="30" alt="" src="<?= \uni\debug\Module::getUniLogo() ?>">
        </a>
    </div>

    <?php foreach ($panels as $panel): ?>
        <?= $panel->getSummary() ?>
    <?php endforeach; ?>
    <span class="uni-debug-toolbar-toggler" onclick="<?= $minJs ?>">›</span>
</div>
<div id="uni-debug-toolbar-min" class="hidden-print">
    <a href="<?= $url ?>" title="Open Uni Debugger" id="uni-debug-toolbar-logo">
        <img width="29" height="30" alt="" src="<?= \uni\debug\Module::getUniLogo() ?>">
    </a>
    <span class="uni-debug-toolbar-toggler" onclick="<?= $maxJs ?>">‹</span>
</div>

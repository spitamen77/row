<?php
/* @var $panel uni\debug\panels\AssetPanel */
if (!empty($panel->data)):
?>
<div class="uni-debug-toolbar-block">
    <a href="<?= $panel->getUrl() ?>" title="Number of asset bundles loaded">Asset Bundles <span class="label label-info"><?= count($panel->data) ?></span></a>
</div>
<?php endif; ?>

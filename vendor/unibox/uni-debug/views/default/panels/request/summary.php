<?php
/* @var $panel uni\debug\panels\RequestPanel */

use uni\helpers\Html;
use uni\web\Response;

$statusCode = $panel->data['statusCode'];
if ($statusCode === null) {
    $statusCode = 200;
}
if ($statusCode >= 200 && $statusCode < 300) {
    $class = 'label-success';
} elseif ($statusCode >= 300 && $statusCode < 400) {
    $class = 'label-info';
} else {
    $class = 'label-important';
}
$statusText = Html::encode(isset(Response::$httpStatuses[$statusCode]) ? Response::$httpStatuses[$statusCode] : '');
?>
<div class="uni-debug-toolbar-block">
    <a href="<?= $panel->getUrl() ?>" title="Status code: <?= $statusCode ?> <?= $statusText ?>">Status <span class="label <?= $class ?>"><?= $statusCode ?></span></a>
    <a href="<?= $panel->getUrl() ?>" title="Action: <?= $panel->data['action'] ?>">Route <span class="label"><?= $panel->data['route'] ?></span></a>
</div>
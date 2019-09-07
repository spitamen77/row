<?php
/* @var $panel uni\debug\panels\LogPanel */
/* @var $data array */

use uni\log\Target;
use uni\log\Logger;

?>

<?php
$title = 'Logged ' . count($data['messages']) . ' messages';
$errorCount = count(Target::filterMessages($data['messages'], Logger::LEVEL_ERROR));
$warningCount = count(Target::filterMessages($data['messages'], Logger::LEVEL_WARNING));
$output = [];

if ($errorCount) {
    $output[] = "<span class=\"label label-important\">$errorCount</span>";
    $title .= ", $errorCount errors";
}

if ($warningCount) {
    $output[] = "<span class=\"label label-warning\">$warningCount</span>";
    $title .= ", $warningCount warnings";
}
?>

<div class="uni-debug-toolbar-block">
    <a href="<?= $panel->getUrl() ?>" title="<?= $title ?>">Log
        <span class="label"><?= count($data['messages']) ?></span>
        <?= implode('&nbsp;', $output) ?>
    </a>
</div>

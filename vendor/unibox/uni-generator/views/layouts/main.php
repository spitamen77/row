<?php
use uni\ui\NavBar;
use uni\ui\Nav;
use uni\helpers\Html;

/**
 * @var \uni\web\View $this
 * @var string $content
 */
$asset = uni\generator\GeneratorAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php
NavBar::begin([
    'brandLabel' => "<h1 style='font-size:22px;color:#fff;margin-top:10px;'>UNIBOX CODE GENERATOR</h1>",
    'brandUrl' => ['default/index'],
    'options' => ['class' => 'navbar-inverse navbar-fixed-top'],
]);
echo Nav::widget([
    'options' => ['class' => 'nav navbar-nav navbar-right'],
    'items' => [
        ['label' => Uni::t('app','Main'), 'url' => ['default/index']],
        ['label' => Uni::t('app','Help'), 'url' => 'https://efco.uz/unibox/info/generator'],
        ['label' => Uni::t('app','Application'), 'url' => Uni::$app->homeUrl],
    ],
]);
NavBar::end();
?>

<div class="container">
    <?= $content ?>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">All rights reserved <a href="http://www.efco.uz/unibox">EFFECT CONSULTING</a></p>
        <p class="pull-right"><?= Uni::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

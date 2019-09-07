<?php
use uni\helpers\Html;

/**
 * @var \uni\web\View $this
 * @var \uni\generator\Generator[] $generators
 * @var string $content
 */
$generators = Uni::$app->controller->module->generators;
$this->title = 'Welcome to Gii';
?>
<div class="default-index">
    <div class="page-header">
        <h1>UNIBOX tizim  <small>kod generatsiya boshqaruv paneli</small></h1>
    </div>

    <p class="lead">Mavjud generatorlar ro'yxati:</p>

    <div class="row">
        <?php foreach ($generators as $id => $generator): ?>
        <div class="generator col-lg-4">
            <h3><?= Html::encode($generator->getName()) ?></h3>
            <p><?= $generator->getDescription() ?></p>
            <p><?= Html::a('Start »', ['default/view', 'id' => $id], ['class' => 'btn btn-default']) ?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <p><a class="btn btn-success" href="http://www.efco.uz/unibox/generators">Kod generatorlari haqida</a></p>

</div>

<?php
use uni\helpers\Html;

/**
 * @var \uni\web\View $this
 * @var \uni\generator\Generator[] $generators
 * @var \uni\generator\Generator $activeGenerator
 * @var string $content
 */
$generators = Uni::$app->controller->module->generators;
$activeGenerator = Uni::$app->controller->generator;
?>
<?php $this->beginContent('@uni/generator/views/layouts/main.php'); ?>
<div class="row">
    <div class="col-md-3 col-sm-4">
        <div class="list-group">
            <?php
            foreach ($generators as $id => $generator) {
                $label = '<i class="glyphicon glyphicon-chevron-right"></i>' . Html::encode($generator->getName());
                echo Html::a($label, ['default/view', 'id' => $id], [
                    'class' => $generator === $activeGenerator ? 'list-group-item active' : 'list-group-item',
                ]);
            }
            ?>
        </div>
    </div>
    <div class="col-md-9 col-sm-8">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent(); ?>

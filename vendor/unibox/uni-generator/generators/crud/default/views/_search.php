<?php

use uni\helpers\Inflector;
use uni\helpers\StringHelper;

/**
 * @var uni\web\View $this
 * @var uni\generator\generators\crud\Generator $generator
 */

echo "<?php\n";
?>

use uni\helpers\Html;
use uni\widgets\Form;

/**
 * @var uni\web\View $this
 * @var <?= ltrim($generator->searchModelClass, '\\') ?> $model
 * @var uni\widgets\Form $form
 */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search">

    <?= "<?php " ?>$form = Form::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

<?php
$count = 0;
foreach ($generator->getColumnNames() as $attribute) {
    if (++$count < 6) {
        echo "    <?= " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
    } else {
        echo "    <?php // echo " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
    }
}
?>
    <div class="form-group">
        <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Search') ?>, ['class' => 'btn btn-primary']) ?>
        <?= "<?= " ?>Html::resetButton(<?= $generator->generateString('Reset') ?>, ['class' => 'btn btn-default']) ?>
    </div>

    <?= "<?php " ?>Form::end(); ?>

</div>

<?php

use uni\helpers\Inflector;
use uni\helpers\StringHelper;

/**
 * @var uni\web\View $this
 * @var uni\generator\generators\crud\Generator $generator
 */

/** @var \uni\db\ActiveRecord $model */
$model = new $generator->modelClass;
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use uni\helpers\Html;
use uni\widgets\Form;

/**
 * @var uni\web\View $this
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
 * @var uni\widgets\Form $form
 */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = Form::begin(); ?>

<?php foreach ($safeAttributes as $attribute) {
    echo "    <?= " . $generator->generateField($attribute) . " ?>\n\n";
} ?>
    <div class="form-group">
        <?= "<?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('Create') ?> : <?= $generator->generateString('Update') ?>, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?= "<?php " ?>Form::end(); ?>

</div>

<?php
/**
 * This is the template for generating an action view file.
 *
 * @var uni\web\View $this
 * @var uni\generator\generators\form\Generator $generator
 */

echo "<?php\n";
?>

use uni\helpers\Html;
use uni\widgets\Form;

/**
 * @var uni\web\View $this
 * @var <?= $generator->modelClass ?> $model
 * @var Form $form
 */
<?= "?>" ?>

<div class="<?= str_replace('/', '-', trim($generator->viewName, '_')) ?>">

    <?= "<?php " ?>$form = Form::begin(); ?>

    <?php foreach ($generator->getModelAttributes() as $attribute): ?>
    <?= "<?= " ?>$form->field($model, '<?= $attribute ?>') ?>
    <?php endforeach; ?>

        <div class="form-group">
            <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Submit') ?>, ['class' => 'btn btn-primary']) ?>
        </div>
    <?= "<?php " ?>Form::end(); ?>

</div><!-- <?= str_replace('/', '-', trim($generator->viewName, '-')) ?> -->

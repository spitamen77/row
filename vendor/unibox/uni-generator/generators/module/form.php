<?php
/**
 * @var uni\web\View $this
 * @var uni\widgets\Form $form
 * @var uni\generator\generators\module\Generator $generator
 */
?>
<div class="module-form">
<?php
    echo $form->field($generator, 'moduleClass');
    echo $form->field($generator, 'moduleID');
?>
</div>

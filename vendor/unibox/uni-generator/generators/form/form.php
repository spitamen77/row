<?php
/**
 * @var uni\web\View $this
 * @var uni\widgets\Form $form
 * @var uni\generator\generators\form\Generator $generator
 */
echo $form->field($generator, 'viewName');
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'scenarioName');
echo $form->field($generator, 'viewPath');
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');

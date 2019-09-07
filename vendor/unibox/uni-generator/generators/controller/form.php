<?php
/**
 * @var uni\web\View $this
 * @var uni\widgets\Form $form
 * @var uni\generator\generators\controller\Generator $generator
 */
echo $form->field($generator, 'controller');
echo $form->field($generator, 'actions');
echo $form->field($generator, 'ns');
echo $form->field($generator, 'baseClass');

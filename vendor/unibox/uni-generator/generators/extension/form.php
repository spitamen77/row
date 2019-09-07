<?php
/**
 * @var uni\web\View $this
 * @var uni\widgets\Form $form
 * @var uni\generator\generators\module\Generator $generator
 */
?>
<div class="alert alert-info">
    Please read the
    <?= \uni\helpers\Html::a('Extension Guidelines', 'https://github.com/unibox/uni/blob/master/docs/guide/extensions.md', ['target'=>'new']) ?>
    before creating an extension.
</div>
<div class="module-form">
<?php
    echo $form->field($generator, 'vendorName');
    echo $form->field($generator, 'packageName');
    echo $form->field($generator, 'namespace');
    echo $form->field($generator, 'type')->dropDownList($generator->optsType());
    echo $form->field($generator, 'keywords');
    echo $form->field($generator, 'license')->dropDownList($generator->optsLicense(), ['prompt'=>'Choose...']);
    echo $form->field($generator, 'title');
    echo $form->field($generator, 'description');
    echo $form->field($generator, 'authorName');
    echo $form->field($generator, 'authorEmail');
    echo $form->field($generator, 'outputPath');
?>
</div>

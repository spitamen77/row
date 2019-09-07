<?php
$this->title = Uni::t('app', 'Create text');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', ['model' => $model]) ?>